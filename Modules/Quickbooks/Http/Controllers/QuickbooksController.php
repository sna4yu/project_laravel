<?php

namespace Modules\Quickbooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Transaction;
use App\Utils\BusinessUtil;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\BusinessLocation;
use App\Utils\ModuleUtil;
use Modules\Accounting\Entities\AccountingAccount;
use Modules\Accounting\Entities\AccountingAccountType;
use Modules\Accounting\Entities\AccountingAccountsTransaction;
use Modules\Accounting\Utils\AccountingUtil;
use Carbon\Carbon;
use App\Account;
use App\AccountTransaction;

class QuickbooksController extends Controller
{
    protected $accountingUtil;

    protected $businessUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(
        AccountingUtil $accountingUtil,
        BusinessUtil $businessUtil,
        ModuleUtil $moduleUtil
    ) {
        $this->accountingUtil = $accountingUtil;
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');

        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('accounting.view_reports'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        $first_account = AccountingAccount::where('business_id', $business_id)
            ->where('status', 'active')
            ->first();
        $ledger_url = null;
        if (!empty($first_account)) {
            $ledger_url = route('ledger_report', $first_account);
        }

        return view('quickbooks::Accounting.index')
            ->with(compact('ledger_url'));
    }

    public function trialBalance()
    {
        $business_id = request()->session()->get('user.business_id');

        // Authorization Check
        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('quickbooks.Balance_Sheet'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        // Date Range
        if (!empty(request()->start_date) && !empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            // Default to the current year
            $start_date = Carbon::now()->startOfYear()->toDateString();
            $end_date = Carbon::now()->endOfYear()->toDateString();
        }

        $balance_formula = $this->accountingUtil->balanceFormula();

        $account_types = AccountingAccountType::accounting_primary_type();
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();

        // Fetch all accounts with their balances and related information including debit and credit
        $query = AccountingAccount::where('business_id', $business_id)
            ->whereNull('parent_account_id')
            ->with([
                'child_accounts' => function ($query) use ($balance_formula, $start_date, $end_date) {
                    $query->select([
                        'accounting_accounts.*',
                        DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                        JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                        WHERE AAT.accounting_account_id = accounting_accounts.id
                        AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS balance"),
                        DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                        WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'debit'
                        AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS debit"),
                        DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                        WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'credit'
                        AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS credit"),
                    ]);
                },
                'child_accounts.detail_type',
                'detail_type',
                'account_sub_type',
                'child_accounts.account_sub_type',
            ])
            ->select([
                'accounting_accounts.*',
                DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id
                AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS balance"),
                DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'debit'
                AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS debit"),
                DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'credit'
                AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS credit"),
            ]);

        if (!empty(request()->input('account_type'))) {
            $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
        }
        if (!empty(request()->input('status'))) {
            $query->where('accounting_accounts.status', request()->input('status'));
        }

        $accounts = $query->get();

        $transactions = AccountingAccountsTransaction::leftjoin('accounting_acc_trans_mappings as ATM', 'accounting_accounts_transactions.acc_trans_mapping_id', '=', 'ATM.id')
            ->leftjoin('transactions as T', 'accounting_accounts_transactions.transaction_id', '=', 'T.id')
            ->leftjoin('users AS U', 'accounting_accounts_transactions.created_by', 'U.id')
            ->select(
                'accounting_accounts_transactions.operation_date',
                'accounting_accounts_transactions.sub_type',
                'accounting_accounts_transactions.type',
                'ATM.ref_no',
                'ATM.note',
                'accounting_accounts_transactions.amount',
                DB::raw("CONCAT(COALESCE(U.surname, ''),' ',COALESCE(U.first_name, ''),' ',COALESCE(U.last_name,'')) as added_by"),
                'T.invoice_no',
                'T.ref_no'
            )
            ->whereBetween('accounting_accounts_transactions.operation_date', [$start_date, $end_date])
            ->get();

        return view('quickbooks::for_my_accountant.trial_balance')
            ->with(compact('accounts', 'account_sub_types', 'account_types', 'start_date', 'end_date', 'transactions'));
    }

    public function ledger($account_id)
{
    $business_id = request()->session()->get('user.business_id');

    // // Authorization check
    // if (!auth()->user()->can('superadmin') && !$this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module') && !auth()->user()->can('quickbooks.Ledger_Report')) {
    //     abort(403, 'Unauthorized action.');
    // }

    // Fetch the account with related data
    $account = AccountingAccount::where('business_id', $business_id)
        ->with(['account_sub_type', 'detail_type'])
        ->findorFail($account_id);

    if (request()->ajax()) {
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        // Fetch transactions with relationships
        $transactions = AccountingAccountsTransaction::where('accounting_account_id', $account->id)
            ->with(['accTransMapping', 'transaction', 'createdBy'])
            ->select([
                'operation_date',
                'sub_type',
                'type',
                'amount',
                'transaction.invoice_no',
                'accTransMapping.ref_no',
                'accTransMapping.note',
                DB::raw("CONCAT(COALESCE(users.surname, ''), ' ', COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name,'')) as added_by")
            ])
            ->when($start_date && $end_date, function($query) use ($start_date, $end_date) {
                $query->whereBetween('operation_date', [$start_date, $end_date]);
            })
            ->get();

        return DataTables::of($transactions)
            ->editColumn('operation_date', function ($row) {
                return $this->accountingUtil->format_date($row->operation_date, true);
            })
            ->editColumn('ref_no', function ($row) {
                $description = '';
                if ($row->sub_type == 'journal_entry') {
                    $description = '<b>' . __('accounting::lang.journal_entry') . '</b>';
                    $description .= '<br>' . __('purchase.ref_no') . ': ' . $row->ref_no;
                } elseif ($row->sub_type == 'opening_balance') {
                    $description = '<b>' . __('accounting::lang.opening_balance') . '</b>';
                } elseif ($row->sub_type == 'sell') {
                    $description = '<b>' . __('sale.sale') . '</b>';
                    $description .= '<br>' . __('sale.invoice_no') . ': ' . $row->invoice_no;
                } elseif ($row->sub_type == 'expense') {
                    $description = '<b>' . __('accounting::lang.expense') . '</b>';
                    $description .= '<br>' . __('purchase.ref_no') . ': ' . $row->ref_no;
                }
                return $description;
            })
            ->addColumn('debit', function ($row) {
                if ($row->type == 'debit') {
                    return '<span class="debit" data-orig-value="' . $row->amount . '">' . $this->accountingUtil->num_f($row->amount, true) . '</span>';
                }
                return '';
            })
            ->addColumn('credit', function ($row) {
                if ($row->type == 'credit') {
                    return '<span class="credit" data-orig-value="' . $row->amount . '">' . $this->accountingUtil->num_f($row->amount, true) . '</span>';
                }
                return '';
            })
            ->editColumn('action', function ($row) {
                return ''; // Placeholder for action buttons if needed
            })
            ->filterColumn('added_by', function ($query, $keyword) {
                $query->whereRaw("CONCAT(COALESCE(users.surname, ''), ' ', COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, '')) like ?", ["%{$keyword}%"]);
            })
            ->rawColumns(['ref_no', 'credit', 'debit', 'action'])
            ->make(true);
    }

    // Calculate the current balance
    $current_bal = AccountingAccount::leftjoin(
        'accounting_accounts_transactions as AAT',
        'AAT.accounting_account_id',
        '=',
        'accounting_accounts.id'
    )
    ->where('business_id', $business_id)
    ->where('accounting_accounts.id', $account->id)
    ->select([DB::raw($this->accountingUtil->balanceFormula())])
    ->first()->balance;

    // Return the ledger view with the necessary data
    return view('quickbooks::for_my_accountant.ledger')
        ->with(compact('account', 'current_bal'));
}

    
    
    public function accountReceivableAgeingReport()
{
    $business_id = request()->session()->get('user.business_id');

    if (
        !(auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        !(auth()->user()->can('quickbooks.Account_Receivable_Ageing_Report_(Summary)'))
    ) {
        abort(403, 'Unauthorized action.');
    }

    $location_id = request()->input('location_id', null);
    $report_details = $this->accountingUtil->getAgeingReport($business_id, 'sell', 'contact', $location_id);
    $business_locations = BusinessLocation::forDropdown($business_id, true);

    return view('quickbooks::favourites.account_receivable_ageing_report')
        ->with(compact('report_details', 'business_locations'));
}

public function getAgeingReport($business_id, $type, $group_by, $location_id = null)
    {
        $today = \Carbon::now()->format('Y-m-d');
        $query = Transaction::where('transactions.business_id', $business_id);

        if ($type == 'sell') {
            $query->where('transactions.type', 'sell')
            ->where('transactions.status', 'final');
        } elseif ($type == 'purchase') {
            $query->where('transactions.type', 'purchase')
                ->where('transactions.status', 'received');
        }

        if (! empty($location_id)) {
            $query->where('transactions.location_id', $location_id);
        }

        $dues = $query->whereNotNull('transactions.pay_term_number')
                ->whereIn('transactions.payment_status', ['partial', 'due'])
                ->join('contacts as c', 'c.id', '=', 'transactions.contact_id')
                ->select(
                    DB::raw(
                        'DATEDIFF(
                            "'.$today.'", 
                            IF(
                                transactions.pay_term_type="days",
                                DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number DAY),
                                DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number MONTH)
                            )
                        ) as diff'
                    ),
                    DB::raw('SUM(transactions.final_total - 
                        (SELECT COALESCE(SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)), 0) 
                        FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) )  
                        as total_due'),

                    'c.name as contact_name',
                    'transactions.contact_id',
                    'transactions.invoice_no',
                    'transactions.ref_no',
                    'transactions.transaction_date',
                    DB::raw('IF(
                        transactions.pay_term_type="days",
                        DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number DAY),
                        DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number MONTH)
                    ) as due_date')
                )
                ->groupBy('transactions.id')
                ->get();

        $report_details = [];
        if ($group_by == 'contact') {
            foreach ($dues as $due) {
                if (! isset($report_details[$due->contact_id])) {
                    $report_details[$due->contact_id] = [
                        'name' => $due->contact_name,
                        '<1' => 0,
                        '1_30' => 0,
                        '31_60' => 0,
                        '61_90' => 0,
                        '>90' => 0,
                        'total_due' => 0,
                    ];
                }

                if ($due->diff < 1) {
                    $report_details[$due->contact_id]['<1'] += $due->total_due;
                } elseif ($due->diff >= 1 && $due->diff <= 30) {
                    $report_details[$due->contact_id]['1_30'] += $due->total_due;
                } elseif ($due->diff >= 31 && $due->diff <= 60) {
                    $report_details[$due->contact_id]['31_60'] += $due->total_due;
                } elseif ($due->diff >= 61 && $due->diff <= 90) {
                    $report_details[$due->contact_id]['61_90'] += $due->total_due;
                } elseif ($due->diff > 90) {
                    $report_details[$due->contact_id]['>90'] += $due->total_due;
                }

                $report_details[$due->contact_id]['total_due'] += $due->total_due;
            }
        } elseif ($group_by == 'due_date') {
            $report_details = [
                'current' => [],
                '1_30' => [],
                '31_60' => [],
                '61_90' => [],
                '>90' => [],
            ];
            foreach ($dues as $due) {
                $temp_array = [
                    'transaction_date' => $this->format_date($due->transaction_date),
                    'due_date' => $this->format_date($due->due_date),
                    'ref_no' => $due->ref_no,
                    'invoice_no' => $due->invoice_no,
                    'contact_name' => $due->contact_name,
                    'due' => $due->total_due,
                ];
                if ($due->diff < 1) {
                    $report_details['current'][] = $temp_array;
                } elseif ($due->diff >= 1 && $due->diff <= 30) {
                    $report_details['1_30'][] = $temp_array;
                } elseif ($due->diff >= 31 && $due->diff <= 60) {
                    $report_details['31_60'][] = $temp_array;
                } elseif ($due->diff >= 61 && $due->diff <= 90) {
                    $report_details['61_90'][] = $temp_array;
                } elseif ($due->diff > 90) {
                    $report_details['>90'][] = $temp_array;
                }
            }
        }

        return $report_details;
    }

public function accountReceivableAgeingDetails()
    {
        $business_id = request()->session()->get('user.business_id');

        // if (
        //     !(auth()->user()->can('superadmin') ||
        //         $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     !(auth()->user()->can('quickbooks.Account_Receivable_Ageing_Details_(Details)'))
        // ) {
        //     abort(403, 'Unauthorized action.');
        // }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport(
            $business_id,
            'sell',
            'due_date',
            $location_id
        );

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('quickbooks::who_owes_you.account_receivable_ageing_details')
            ->with(compact('business_locations', 'report_details'));
    }

    public function accountPayableAgeingReport()
    {
        $business_id = request()->session()->get('user.business_id');

        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('quickbooks.Account_Payable_Ageing_Report_(Summary)'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        $location_id = request()->input('location_id', null);
        $report_details = $this->accountingUtil->getAgeingReport(
            $business_id,
            'purchase',
            'contact',
            $location_id
        );
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('quickbooks::what_you_owe.account_payable_ageing_report')
            ->with(compact('report_details', 'business_locations'));
    }

    public function accountPayableAgeingDetails()
    {
        $business_id = request()->session()->get('user.business_id');

        if (!(auth()->user()->can('quickbooks.Account_Payable_Ageing_Details_(Details)'))) {
            abort(403, 'Unauthorized action.');
        }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport(
            $business_id,
            'purchase',
            'due_date',
            $location_id
        );

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('quickbooks::what_you_owe.account_payable_ageing_details')
            ->with(compact('business_locations', 'report_details'));
    }

    public function accountList()
    {
        $business_id = request()->session()->get('user.business_id');

        // Authorization Check
        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('quickbooks.Balance_Sheet'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        // Date Range
        $start_date = request()->input('start_date', Carbon::now()->startOfYear()->toDateString());
        $end_date = request()->input('end_date', Carbon::now()->endOfYear()->toDateString());

        $balance_formula = $this->accountingUtil->balanceFormula();

        $account_types = AccountingAccountType::accounting_primary_type();
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();

        // Aggregate Balances for Assets, Liabilities, and Equities
        // $assets = $this->getAggregatedBalances($business_id, 'asset', $start_date, $end_date, $balance_formula);
        // $liabilities = $this->getAggregatedBalances($business_id, 'liability', $start_date, $end_date, $balance_formula);
        // $equities = $this->getAggregatedBalances($business_id, 'equity', $start_date, $end_date, $balance_formula);

        // Fetch all accounts with their balances
        $query = AccountingAccount::where('business_id', $business_id)
            ->whereNull('parent_account_id')
            ->with([
                'child_accounts' => function ($query) use ($balance_formula) {
                    $query->select([
                        DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                        JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                        WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                        'accounting_accounts.*'
                    ]);
                },
                'child_accounts.detail_type',
                'detail_type',
                'account_sub_type',
                'child_accounts.account_sub_type',
            ])
            ->select([
                DB::raw("(SELECT $balance_formula
                FROM accounting_accounts_transactions AS AAT 
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                'accounting_accounts.*',
            ])
            ->whereBetween('accounting_accounts.created_at', [$start_date, $end_date]);

        if (!empty(request()->input('account_type'))) {
            $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
        }
        if (!empty(request()->input('status'))) {
            $query->where('accounting_accounts.status', request()->input('status'));
        }

        $accounts = $query->get();

        return view('quickbooks::Favourites.account_list')
            ->with(compact('accounts', 'account_sub_types', 'account_types', 'assets', 'liabilities', 'equities', 'start_date', 'end_date', 'transactions'));
    }

    public function journal()
    {
        $business_id = request()->session()->get('user.business_id');

        // Authorization Check
        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('quickbooks.Balance_Sheet'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        // Date Range
        if (!empty(request()->start_date) && !empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            // Default to the current year
            $start_date = Carbon::now()->startOfYear()->toDateString();
            $end_date = Carbon::now()->endOfYear()->toDateString();
        }

        $balance_formula = $this->accountingUtil->balanceFormula();

        $account_types = AccountingAccountType::accounting_primary_type();
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();

        // Fetch all accounts with their balances and related information including debit and credit
        $query = AccountingAccount::where('business_id', $business_id)
            ->whereNull('parent_account_id')
            ->with([
                'child_accounts' => function ($query) use ($balance_formula, $start_date, $end_date) {
                    $query->select([
                        'accounting_accounts.*',
                        DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                        JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                        WHERE AAT.accounting_account_id = accounting_accounts.id 
                        AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS balance"),
                        DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                        WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'debit' 
                        AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS debit"),
                        DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                        WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'credit' 
                        AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS credit"),
                    ]);
                },
                'child_accounts.detail_type',
                'detail_type',
                'account_sub_type',
                'child_accounts.account_sub_type',
            ])
            ->select([
                'accounting_accounts.*',
                DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT 
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id 
                AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS balance"),
                DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'debit' 
                AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS debit"),
                DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'credit' 
                AND AAT.operation_date BETWEEN '$start_date' AND '$end_date') AS credit"),
            ])
            ->whereExists(function ($query) use ($start_date, $end_date) {
                $query->select(DB::raw(1))
                    ->from('accounting_accounts_transactions')
                    ->whereColumn('accounting_accounts_transactions.accounting_account_id', 'accounting_accounts.id')
                    ->whereBetween('accounting_accounts_transactions.operation_date', [$start_date, $end_date]);
            });

        if (!empty(request()->input('account_type'))) {
            $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
        }
        if (!empty(request()->input('status'))) {
            $query->where('accounting_accounts.status', request()->input('status'));
        }

        $accounts = $query->get();

        $transactions = AccountingAccountsTransaction::leftjoin('accounting_acc_trans_mappings as ATM', 'accounting_accounts_transactions.acc_trans_mapping_id', '=', 'ATM.id')
            ->leftjoin('transactions as T', 'accounting_accounts_transactions.transaction_id', '=', 'T.id')
            ->leftjoin('users AS U', 'accounting_accounts_transactions.created_by', 'U.id')
            ->select(
                'accounting_accounts_transactions.operation_date',
                'accounting_accounts_transactions.sub_type',
                'accounting_accounts_transactions.type',
                'ATM.ref_no',
                'ATM.note',
                'accounting_accounts_transactions.amount',
                DB::raw("CONCAT(COALESCE(U.surname, ''),' ',COALESCE(U.first_name, ''),' ',COALESCE(U.last_name,'')) as added_by"),
                'T.invoice_no',
                'T.ref_no'
            )
            ->whereBetween('accounting_accounts_transactions.operation_date', [$start_date, $end_date])
            ->get();

        return view('quickbooks::Favourites.journal_report')
            ->with(compact('accounts', 'account_sub_types', 'account_types', 'start_date', 'end_date', 'transactions'));
    }

    public function balanceSheet()
    {
        $business_id = request()->session()->get('user.business_id');

        // Authorization Check
        // if (
        //     !(auth()->user()->can('superadmin') ||
        //         $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     !(auth()->user()->can('quickbooks.Balance_Sheet'))
        // ) {
        //     abort(403, 'Unauthorized action.');
        // }

        // Date Range
        $start_date = request()->input('start_date', Carbon::now()->startOfYear()->toDateString());
        $end_date = request()->input('end_date', Carbon::now()->endOfYear()->toDateString());

        $balance_formula = $this->accountingUtil->balanceFormula();

        $account_types = AccountingAccountType::accounting_primary_type();
        // dd($account_types);
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();
            // dd($account_sub_types);
        // Aggregate Balances for Assets, Liabilities, and Equities
        // $assets = $this->getAggregatedBalances($business_id, 'asset', $start_date, $end_date, $balance_formula);
        // $liabilities = $this->getAggregatedBalances($business_id, 'liability', $start_date, $end_date, $balance_formula);
        // $equities = $this->getAggregatedBalances($business_id, 'equity', $start_date, $end_date, $balance_formula);

        // Fetch all accounts with their balances
        $query = AccountingAccount::where('business_id', $business_id)
            ->whereNull('parent_account_id')
            ->with([
                'child_accounts' => function ($query) use ($balance_formula) {
                    $query->select([
                        DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                        JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                        WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                        'accounting_accounts.*'
                    ]);
                },
                'child_accounts.detail_type',
                'detail_type',
                'account_sub_type',
                'child_accounts.account_sub_type',
            ])
            ->select([
                DB::raw("(SELECT $balance_formula
                FROM accounting_accounts_transactions AS AAT 
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                'accounting_accounts.*',
            ])
            ->whereBetween('accounting_accounts.created_at', [$start_date, $end_date]);
            // dd($query);
        if (!empty(request()->input('account_type'))) {
            $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
        }
        if (!empty(request()->input('status'))) {
            $query->where('accounting_accounts.status', request()->input('status'));
        }

        $accounts = $query->get();

        return view('quickbooks::favourites.balance_sheet')
            ->with(compact('accounts', 'account_sub_types', 'account_types', 'assets', 'liabilities', 'equities', 'start_date', 'end_date', 'transactions'));
    }

    public function balanceSheetCompare()
{
    $business_id = request()->session()->get('user.business_id');

    // Authorization Check
    if (
        !(auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        !(auth()->user()->can('quickbooks.Balance_Sheet'))
    ) {
        abort(403, 'Unauthorized action.');
    }

    // Get date range from request or set default
    $start_date = request()->input('start_date', '2024-01-01');
    $end_date = request()->input('end_date', '2024-12-31');

    $start_date_2023 = request()->input('start_date_2023', '2023-01-01');
    $end_date_2023 = request()->input('end_date_2023', '2023-12-31');

    $balance_formula = $this->accountingUtil->balanceFormula();

    // Fetch account types and sub-types
    $account_types = AccountingAccountType::accounting_primary_type();
    $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
        ->where(function ($q) use ($business_id) {
            $q->whereNull('business_id')
                ->orWhere('business_id', $business_id);
        })
        ->get();

    // Fetch all accounts with their balances for the selected years
    $accounts = [
        '2024' => $this->getAccountsBalances($business_id, $start_date, $end_date, $balance_formula),
        '2023' => $this->getAccountsBalances($business_id, $start_date_2023, $end_date_2023, $balance_formula),
    ];

    return view('quickbooks::favourites.balance_sheet_compare')
        ->with(compact('accounts', 'account_sub_types', 'account_types', 'start_date', 'end_date', 'start_date_2023', 'end_date_2023'));
}

private function getAccountsBalances($business_id, $start_date, $end_date, $balance_formula)
{
    $query = AccountingAccount::where('business_id', $business_id)
        ->whereNull('parent_account_id')
        ->with([
            'child_accounts' => function ($query) use ($balance_formula) {
                $query->select([
                    DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                    JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                    WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                    'accounting_accounts.*'
                ]);
            },
            'child_accounts.detail_type',
            'detail_type',
            'account_sub_type',
            'child_accounts.account_sub_type',
        ])
        ->select([
            DB::raw("(SELECT $balance_formula
            FROM accounting_accounts_transactions AS AAT 
            JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
            WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
            'accounting_accounts.*',
        ])
        ->whereBetween('accounting_accounts.created_at', [$start_date, $end_date]);

    if (!empty(request()->input('account_type'))) {
        $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
    }
    if (!empty(request()->input('status'))) {
        $query->where('accounting_accounts.status', request()->input('status'));
    }

    return $query->get();
}


    public function balanceSheetDetail()
    {
        $business_id = request()->session()->get('user.business_id');

        // Authorization Check
        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('quickbooks.Balance_Sheet'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        // Date Range
        if (!empty(request()->start_date) && !empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            // Default to the current year
            $start_date = Carbon::now()->startOfYear()->toDateString();
            $end_date = Carbon::now()->endOfYear()->toDateString();
        }

        $balance_formula = $this->accountingUtil->balanceFormula();

        $account_types = AccountingAccountType::accounting_primary_type();
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();

        // Fetch all accounts with their balances and related information including debit and credit
        $query = AccountingAccount::where('business_id', $business_id)
            ->whereNull('parent_account_id')
            ->with([
                'child_accounts' => function ($query) use ($balance_formula) {
                    $query->select([
                        'accounting_accounts.*',
                        DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                        JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                        WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                        DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                        WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'debit') AS debit"),
                        DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                        WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'credit') AS credit"),
                    ]);
                },
                'child_accounts.detail_type',
                'detail_type',
                'account_sub_type',
                'child_accounts.account_sub_type',
            ])
            ->select([
                'accounting_accounts.*',
                DB::raw("(SELECT $balance_formula
                FROM accounting_accounts_transactions AS AAT 
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'debit') AS debit"),
                DB::raw("(SELECT SUM(amount) FROM accounting_accounts_transactions AS AAT
                WHERE AAT.accounting_account_id = accounting_accounts.id AND type = 'credit') AS credit"),
            ])
            ->whereBetween('accounting_accounts.created_at', [$start_date, $end_date]);

        if (!empty(request()->input('account_type'))) {
            $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
        }
        if (!empty(request()->input('status'))) {
            $query->where('accounting_accounts.status', request()->input('status'));
        }

        $accounts = $query->get();

        $transactions = AccountingAccountsTransaction::leftjoin('accounting_acc_trans_mappings as ATM', 'accounting_accounts_transactions.acc_trans_mapping_id', '=', 'ATM.id')
            ->leftjoin('transactions as T', 'accounting_accounts_transactions.transaction_id', '=', 'T.id')
            ->leftjoin('users AS U', 'accounting_accounts_transactions.created_by', 'U.id')
            ->select(
                'accounting_accounts_transactions.operation_date',
                'accounting_accounts_transactions.sub_type',
                'accounting_accounts_transactions.type',
                'ATM.ref_no',
                'ATM.note',
                'accounting_accounts_transactions.amount',
                DB::raw("CONCAT(COALESCE(U.surname, ''),' ',COALESCE(U.first_name, ''),' ',COALESCE(U.last_name,'')) as added_by"),
                'T.invoice_no',
                'T.ref_no'
            )
            ->whereBetween('accounting_accounts_transactions.operation_date', [$start_date, $end_date])
            ->get();

        return view('quickbooks::favourites.balance_sheet_detail')
            ->with(compact('accounts', 'account_sub_types', 'account_types', 'start_date', 'end_date', 'transactions'));
    }

    public function balanceSheetSummary()
    {
        $business_id = request()->session()->get('user.business_id');

        // Authorization Check
        if (
            !(auth()->user()->can('superadmin') ||
                $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            !(auth()->user()->can('quickbooks.Balance_Sheet'))
        ) {
            abort(403, 'Unauthorized action.');
        }

        // Date Range
        if (!empty(request()->start_date) && !empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
            $start_date = $fy['start'];
            $end_date = $fy['end'];
        }

        $balance_formula = $this->accountingUtil->balanceFormula();

        $account_types = AccountingAccountType::accounting_primary_type();
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();

        // Aggregate Balances for Assets, Liabilities, and Equities
        // $assets = $this->getAggregatedBalances($business_id, 'asset', $start_date, $end_date, $balance_formula);
        // $liabilities = $this->getAggregatedBalances($business_id, 'liability', $start_date, $end_date, $balance_formula);
        // $equities = $this->getAggregatedBalances($business_id, 'equity', $start_date, $end_date, $balance_formula);

        // Fetch all accounts with their balances
        $query = AccountingAccount::where('business_id', $business_id)
            ->whereNull('parent_account_id')
            ->with([
                'child_accounts' => function ($query) use ($balance_formula) {
                    $query->select([
                        DB::raw("(SELECT $balance_formula FROM accounting_accounts_transactions AS AAT
                        JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                        WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                        'accounting_accounts.*'
                    ]);
                },
                'child_accounts.detail_type',
                'detail_type',
                'account_sub_type',
                'child_accounts.account_sub_type',
            ])
            ->select([
                DB::raw("(SELECT $balance_formula
                FROM accounting_accounts_transactions AS AAT 
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
                'accounting_accounts.*',
            ]);

        if (!empty(request()->input('account_type'))) {
            $query->where('accounting_accounts.account_primary_type', request()->input('account_type'));
        }
        if (!empty(request()->input('status'))) {
            $query->where('accounting_accounts.status', request()->input('status'));
        }

        $accounts = $query->get();

        return view('quickbooks::favourites.balance_sheet_summary')
            ->with(compact('accounts', 'account_sub_types', 'account_types', 'assets', 'liabilities', 'equities', 'start_date', 'end_date'));
    }

    
    public function getData() //Get Data from DataBase function
    {
        // Define the business ID
        $business_id = request()->session()->get('user.business_id');
        //new
        // if (! empty(request()->start_date) && ! empty(request()->end_date)) 
        // {
        //     $start_date = request()->start_date;
        //     $end_date = request()->end_date;
        // } 
        // else 
        // {
        //     $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
        //     $start_date = $fy['start'];
        //     $end_date = $fy['end'];
        // }

        if (request()->ajax()) {
            $transactions = Transaction::where('business_id', $business_id)->get();

            return Datatables::of($transactions)
            ->addColumn('quickbooks', function ($row) {
                return;
            })       
            ->make(true);

        }


        // $transactions = Transaction::where('business_id', $business_id)->whereBetween('transactions.transaction_date', [$start_date, $end_date])->get();
        // Return the results to the view
        return view('quickbooks::Income_report.index');
    }

    public function cashFlow()
    {
        if (! auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $accounts = AccountTransaction::join(
                'accounts as A',
                'account_transactions.account_id',
                '=',
                'A.id'
                )
                ->leftjoin(
                    'transaction_payments as TP',
                    'account_transactions.transaction_payment_id',
                    '=',
                    'TP.id'
                )
                ->leftjoin(
                    'transaction_payments as child_payments',
                    'TP.id',
                    '=',
                    'child_payments.parent_id'
                )
                ->leftjoin(
                    'transactions as child_sells',
                    'child_sells.id',
                    '=',
                    'child_payments.transaction_id'
                )
                ->leftJoin('users AS u', 'account_transactions.created_by', '=', 'u.id')
                ->leftJoin('contacts AS c', 'TP.payment_for', '=', 'c.id')
                ->where('A.business_id', $business_id)
                ->with(['transaction', 'transaction.contact', 'transfer_transaction', 'transaction.transaction_for'])
                ->select(['account_transactions.type', 'account_transactions.amount', 'operation_date',
                    'account_transactions.sub_type', 'transfer_transaction_id',
                    'account_transactions.transaction_id',
                    'account_transactions.id',
                    'A.name as account_name',
                    'TP.payment_ref_no as payment_ref_no',
                    'TP.is_return',
                    'TP.is_advance',
                    'TP.method',
                    'TP.transaction_no',
                    'TP.card_transaction_number',
                    'TP.card_number',
                    'TP.card_type',
                    'TP.card_holder_name',
                    'TP.card_month',
                    'TP.card_year',
                    'TP.card_security',
                    'TP.cheque_number',
                    'TP.bank_account_number',
                    'account_transactions.account_id',
                    DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by"),
                    'c.name as payment_for_contact',
                    'c.type as payment_for_type',
                    'c.supplier_business_name as payment_for_business_name',
                    DB::raw('SUM(child_payments.amount) total_recovered'),
                    DB::raw("GROUP_CONCAT(child_sells.invoice_no SEPARATOR ', ') as child_sells"),
                ])
                 ->groupBy('account_transactions.id')
                 ->orderBy('account_transactions.operation_date', 'asc');
            if (! empty(request()->input('type'))) {
                $accounts->where('account_transactions.type', request()->input('type'));
            }

            $permitted_locations = auth()->user()->permitted_locations();
            $account_ids = [];
            if ($permitted_locations != 'all') {
                $locations = BusinessLocation::where('business_id', $business_id)
                                ->whereIn('id', $permitted_locations)
                                ->get();

                foreach ($locations as $location) {
                    if (! empty($location->default_payment_accounts)) {
                        $default_payment_accounts = json_decode($location->default_payment_accounts, true);
                        foreach ($default_payment_accounts as $key => $account) {
                            if (! empty($account['is_enabled']) && ! empty($account['account'])) {
                                $account_ids[] = $account['account'];
                            }
                        }
                    }
                }

                $account_ids = array_unique($account_ids);
            }

            if ($permitted_locations != 'all') {
                $accounts->whereIn('A.id', $account_ids);
            }

            $location_id = request()->input('location_id');
            if (! empty($location_id)) {
                $location = BusinessLocation::find($location_id);
                if (! empty($location->default_payment_accounts)) {
                    $default_payment_accounts = json_decode($location->default_payment_accounts, true);
                    $account_ids = [];
                    foreach ($default_payment_accounts as $key => $account) {
                        if (! empty($account['is_enabled']) && ! empty($account['account'])) {
                            $account_ids[] = $account['account'];
                        }
                    }

                    $accounts->whereIn('A.id', $account_ids);
                }
            }

            if (! empty(request()->input('account_id'))) {
                $accounts->where('A.id', request()->input('account_id'));
            }

            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            if (! empty($start_date) && ! empty($end_date)) {
                $accounts->whereBetween(DB::raw('date(operation_date)'), [$start_date, $end_date]);
            }

            if (request()->has('only_payment_recovered')) {
                //payment date is today and transaction date is less than today
                $accounts->leftJoin('transactions AS t', 'TP.transaction_id', '=', 't.id')
                    ->whereDate('operation_date', '=', \Carbon::now()->format('Y-m-d'))
                    ->where(function ($q) {
                        $q->whereDate('t.transaction_date', '<',
                        \Carbon::now()->format('Y-m-d'))
                        ->orWhere('TP.is_advance', 1);
                    });
            }

            $payment_types = $this->commonUtil->payment_types(null, true, $business_id);

            return DataTables::of($accounts)
                ->editColumn('method', function ($row) use ($payment_types) {
                    if (! empty($row->method) && isset($payment_types[$row->method])) {
                        return $payment_types[$row->method];
                    } else {
                        return '';
                    }
                })
                ->addColumn('payment_details', function ($row) {
                    $arr = [];
                    if (! empty($row->transaction_no)) {
                        $arr[] = '<b>'.__('lang_v1.transaction_no').'</b>: '.$row->transaction_no;
                    }

                    if ($row->method == 'card' && ! empty($row->card_transaction_number)) {
                        $arr[] = '<b>'.__('lang_v1.card_transaction_no').'</b>: '.$row->card_transaction_number;
                    }

                    if ($row->method == 'card' && ! empty($row->card_number)) {
                        $arr[] = '<b>'.__('lang_v1.card_no').'</b>: '.$row->card_number;
                    }
                    if ($row->method == 'card' && ! empty($row->card_type)) {
                        $arr[] = '<b>'.__('lang_v1.card_type').'</b>: '.$row->card_type;
                    }
                    if ($row->method == 'card' && ! empty($row->card_holder_name)) {
                        $arr[] = '<b>'.__('lang_v1.card_holder_name').'</b>: '.$row->card_holder_name;
                    }
                    if ($row->method == 'card' && ! empty($row->card_month)) {
                        $arr[] = '<b>'.__('lang_v1.month').'</b>: '.$row->card_month;
                    }
                    if ($row->method == 'card' && ! empty($row->card_year)) {
                        $arr[] = '<b>'.__('lang_v1.year').'</b>: '.$row->card_year;
                    }
                    if ($row->method == 'card' && ! empty($row->card_security)) {
                        $arr[] = '<b>'.__('lang_v1.security_code').'</b>: '.$row->card_security;
                    }
                    if (! empty($row->cheque_number)) {
                        $arr[] = '<b>'.__('lang_v1.cheque_no').'</b>: '.$row->cheque_number;
                    }
                    if (! empty($row->bank_account_number)) {
                        $arr[] = '<b>'.__('lang_v1.card_no').'</b>: '.$row->bank_account_number;
                    }

                    return implode(', ', $arr);
                })
                ->addColumn('debit', '@if($type == "debit")<span class="debit" data-orig-value="{{$amount}}">@format_currency($amount)</span>@endif')
                ->addColumn('credit', '@if($type == "credit")<span class="debit" data-orig-value="{{$amount}}">@format_currency($amount)</span>@endif')
                ->addColumn('balance', function ($row) {
                    $balance = AccountTransaction::where('account_id',
                                        $row->account_id)
                                    ->where('operation_date', '<=', $row->operation_date)
                                    ->whereNull('deleted_at')
                                    ->select(DB::raw("SUM(IF(type='credit', amount, -1 * amount)) as balance"))
                                    ->first()->balance;

                    return '<span class="balance" data-orig-value="'.$balance.'">'.$this->commonUtil->num_f($balance, true).'</span>';
                })
                ->addColumn('total_balance', function ($row) use ($business_id, $account_ids, $permitted_locations) {
                    $query = AccountTransaction::join(
                                        'accounts as A',
                                        'account_transactions.account_id',
                                        '=',
                                        'A.id'
                                    )
                                    ->where('A.business_id', $business_id)
                                    ->where('operation_date', '<=', $row->operation_date)
                                    ->whereNull('account_transactions.deleted_at')
                                    ->select(DB::raw("SUM(IF(type='credit', amount, -1 * amount)) as balance"));

                    if (! empty(request()->input('type'))) {
                        $query->where('type', request()->input('type'));
                    }
                    if ($permitted_locations != 'all' || ! empty(request()->input('location_id'))) {
                        $query->whereIn('A.id', $account_ids);
                    }

                    if (! empty(request()->input('account_id'))) {
                        $query->where('A.id', request()->input('account_id'));
                    }

                    $balance = $query->first()->balance;

                    return '<span class="total_balance" data-orig-value="'.$balance.'">'.$this->commonUtil->num_f($balance, true).'</span>';
                })
                ->editColumn('operation_date', function ($row) {
                    return $this->commonUtil->format_date($row->operation_date, true);
                })
                ->editColumn('sub_type', function ($row) {
                    return $this->__getPaymentDetails($row);
                })
                ->removeColumn('id')
                ->rawColumns(['credit', 'debit', 'balance', 'sub_type', 'total_balance', 'payment_details'])
                ->make(true);
        }
        $accounts = Account::forDropdown($business_id, false);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('quickbooks::business_overview.cash_flow')
                 ->with(compact('accounts', 'business_locations'));
    }
}
