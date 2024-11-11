<?php

namespace Modules\ReportManagement\Http\Controllers;

use App\BusinessLocation;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use DB;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\AccountingAccount;
use Modules\Accounting\Utils\AccountingUtil;

class AccountingReportController extends Controller
{
    protected $accountingUtil;

    protected $businessUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(AccountingUtil $accountingUtil, BusinessUtil $businessUtil,
    ModuleUtil $moduleUtil)
    {
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

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        $first_account = AccountingAccount::where('business_id', $business_id)
                            ->where('status', 'active')
                            ->first();
        $ledger_url = null;
        if (! empty($first_account)) {
            $ledger_url = route('ledger_report', $first_account);
        }

        return view('reportmanagement::Accounting.index')
            ->with(compact('ledger_url'));
    }

    /**
     * Trial Balance
     *
     * @return Response
     */
    public function trialBalance()
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        if (! empty(request()->start_date) && ! empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
            $start_date = $fy['start'];
            $end_date = $fy['end'];
        }

        $accounts = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                            ->where('business_id', $business_id)
                            ->whereDate('AAT.operation_date', '>=', $start_date)
                            ->whereDate('AAT.operation_date', '<=', $end_date)
                            ->select(
                                DB::raw("SUM(IF(AAT.type = 'credit', AAT.amount, 0)) as credit_balance"),
                                DB::raw("SUM(IF(AAT.type = 'debit', AAT.amount, 0)) as debit_balance"),
                                'accounting_accounts.name'
                            )
                            ->groupBy('accounting_accounts.name')
                            ->get();

        return view('reportmanagement::Accounting.trial_balance')
            ->with(compact('accounts', 'start_date', 'end_date'));
    }

    /**
     * Trial Balance
     *
     * @return Response
     */
    public function ledger($account_id)
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.manage_accounts'))) {
            abort(403, 'Unauthorized action.');
        }

        $account = AccountingAccount::where('business_id', $business_id)
                        ->with(['account_sub_type', 'detail_type'])
                        ->findorFail($account_id);

        if (request()->ajax()) {
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            // $before_bal_query = AccountingAccountsTransaction::where('accounting_account_id', $account->id)
            //                     ->leftjoin('accounting_acc_trans_mappings as ATM', 'accounting_accounts_transactions.acc_trans_mapping_id', '=', 'ATM.id')
            //         ->select([
            //             DB::raw('SUM(IF(accounting_accounts_transactions.type="credit", accounting_accounts_transactions.amount, -1 * accounting_accounts_transactions.amount)) as prev_bal')])
            //         ->where('accounting_accounts_transactions.operation_date', '<', $start_date);
            // $bal_before_start_date = $before_bal_query->first()->prev_bal;

            $transactions = AccountingAccountsTransaction::where('accounting_account_id', $account->id)
                            ->leftjoin('accounting_acc_trans_mappings as ATM', 'accounting_accounts_transactions.acc_trans_mapping_id', '=', 'ATM.id')
                            ->leftjoin('transactions as T', 'accounting_accounts_transactions.transaction_id', '=', 'T.id')
                            ->leftjoin('users AS U', 'accounting_accounts_transactions.created_by', 'U.id')
                            ->select('accounting_accounts_transactions.operation_date',
                                'accounting_accounts_transactions.sub_type',
                                'accounting_accounts_transactions.type',
                                'ATM.ref_no', 'ATM.note',
                                'accounting_accounts_transactions.amount',
                                DB::raw("CONCAT(COALESCE(U.surname, ''),' ',COALESCE(U.first_name, ''),' ',COALESCE(U.last_name,'')) as added_by"),
                                'T.invoice_no', 'T.ref_no'
                            );
            if (! empty($start_date) && ! empty($end_date)) {
                $transactions->whereDate('accounting_accounts_transactions.operation_date', '>=', $start_date)
                        ->whereDate('accounting_accounts_transactions.operation_date', '<=', $end_date);
            }

            return DataTables::of($transactions)
                    ->editColumn('operation_date', function ($row) {
                        return $this->accountingUtil->format_date($row->operation_date, true);
                    })
                    ->editColumn('ref_no', function ($row) {
                        $description = '';

                        if ($row->sub_type == 'journal_entry') {
                            $description = '<b>'.__('accounting::lang.journal_entry').'</b>';
                            $description .= '<br>'.__('purchase.ref_no').': '.$row->ref_no;
                        }

                        if ($row->sub_type == 'opening_balance') {
                            $description = '<b>'.__('accounting::lang.opening_balance').'</b>';
                        }

                        if ($row->sub_type == 'sell') {
                            $description = '<b>'.__('sale.sale').'</b>';
                            $description .= '<br>'.__('sale.invoice_no').': '.$row->invoice_no;
                        }

                        if ($row->sub_type == 'expense') {
                            $description = '<b>'.__('accounting::lang.expense').'</b>';
                            $description .= '<br>'.__('purchase.ref_no').': '.$row->ref_no;
                        }

                        return $description;
                    })
                    ->addColumn('debit', function ($row) {
                        if ($row->type == 'debit') {
                            return '<span class="debit" data-orig-value="'.$row->amount.'">'.$this->accountingUtil->num_f($row->amount, true).'</span>';
                        }

                        return '';
                    })
                    ->addColumn('credit', function ($row) {
                        if ($row->type == 'credit') {
                            return '<span class="credit"  data-orig-value="'.$row->amount.'">'.$this->accountingUtil->num_f($row->amount, true).'</span>';
                        }

                        return '';
                    })
                    // ->addColumn('balance', function ($row) use ($bal_before_start_date, $start_date) {
                    //     //TODO:: Need to fix same balance showing for transactions having same operation date
                    //     $current_bal = AccountingAccountsTransaction::where('accounting_account_id',
                    //                         $row->account_id)
                    //                     ->where('operation_date', '>=', $start_date)
                    //                     ->where('operation_date', '<=', $row->operation_date)
                    //                     ->select(DB::raw("SUM(IF(type='credit', amount, -1 * amount)) as balance"))
                    //                     ->first()->balance;
                    //     $bal = $bal_before_start_date + $current_bal;
                    //     return '<span class="balance" data-orig-value="' . $bal . '">' . $this->accountingUtil->num_f($bal, true) . '</span>';
                    // })
                    ->editColumn('action', function ($row) {
                        $action = '';

                        return $action;
                    })
                    ->filterColumn('added_by', function ($query, $keyword) {
                        $query->whereRaw("CONCAT(COALESCE(u.surname, ''), ' ', COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, '')) like ?", ["%{$keyword}%"]);
                    })
                    ->rawColumns(['ref_no', 'credit', 'debit', 'balance', 'action'])
                    ->make(true);
        }

        $current_bal = AccountingAccount::leftjoin('accounting_accounts_transactions as AAT',
                            'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                        ->where('business_id', $business_id)
                        ->where('accounting_accounts.id', $account->id)
                        ->select([DB::raw($this->accountingUtil->balanceFormula())]);
        $current_bal = $current_bal->first()->balance;

        return view('reportmanagement::Accounting.ledger')
            ->with(compact('account', 'current_bal'));
    }
     public function balanceSheet()
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        if (! empty(request()->start_date) && ! empty(request()->end_date)) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
        } else {
            $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
            $start_date = $fy['start'];
            $end_date = $fy['end'];
        }

        $balance_formula = $this->accountingUtil->balanceFormula();

        $assets = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                    ->join('accounting_account_types as AATP',
                                'AATP.id', '=', 'accounting_accounts.account_sub_type_id')
                    ->whereDate('AAT.operation_date', '>=', $start_date)
                    ->whereDate('AAT.operation_date', '<=', $end_date)
                    ->select(DB::raw($balance_formula), 'accounting_accounts.name', 'AATP.name as sub_type')
                    ->where('accounting_accounts.business_id', $business_id)
                    ->whereIn('accounting_accounts.account_primary_type', ['asset'])
                    ->groupBy('accounting_accounts.name')
                    ->get();

        $liabilities = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                    ->join('accounting_account_types as AATP',
                                'AATP.id', '=', 'accounting_accounts.account_sub_type_id')
                    ->whereDate('AAT.operation_date', '>=', $start_date)
                    ->whereDate('AAT.operation_date', '<=', $end_date)
                    ->select(DB::raw($balance_formula), 'accounting_accounts.name', 'AATP.name as sub_type')
                    ->where('accounting_accounts.business_id', $business_id)
                    ->whereIn('accounting_accounts.account_primary_type', ['liability'])
                    ->groupBy('accounting_accounts.name')
                    ->get();

        $equities = AccountingAccount::join('accounting_accounts_transactions as AAT',
                                'AAT.accounting_account_id', '=', 'accounting_accounts.id')
                    ->join('accounting_account_types as AATP',
                                'AATP.id', '=', 'accounting_accounts.account_sub_type_id')
                    ->whereDate('AAT.operation_date', '>=', $start_date)
                    ->whereDate('AAT.operation_date', '<=', $end_date)
                    ->select(DB::raw($balance_formula), 'accounting_accounts.name', 'AATP.name as sub_type')
                    ->where('accounting_accounts.business_id', $business_id)
                    ->whereIn('accounting_accounts.account_primary_type', ['equity'])
                    ->groupBy('accounting_accounts.name')
                    ->get();

        return view('reportmanagement::Accounting.balance_sheet')
            ->with(compact('assets', 'liabilities', 'equities', 'start_date', 'end_date'));
    }

    public function accountReceivableAgeingReport()
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'sell', 'contact', $location_id);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('reportmanagement::accounting.account_receivable_ageing_report')
        ->with(compact('report_details', 'business_locations'));
    }

    public function accountPayableAgeingReport()
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        $location_id = request()->input('location_id', null);
        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'purchase', 'contact',
        $location_id);
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('reportmanagement::Accounting.account_payable_ageing_report')
        ->with(compact('report_details', 'business_locations'));
    }

    public function accountReceivableAgeingDetails()
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'sell', 'due_date',
        $location_id);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('reportmanagement::Accounting.account_receivable_ageing_details')
        ->with(compact('business_locations', 'report_details'));
    }

    public function accountPayableAgeingDetails()
    {
        $business_id = request()->session()->get('user.business_id');

        if (! (auth()->user()->can('superadmin') ||
            $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
            ! (auth()->user()->can('accounting.view_reports'))) {
            abort(403, 'Unauthorized action.');
        }

        $location_id = request()->input('location_id', null);

        $report_details = $this->accountingUtil->getAgeingReport($business_id, 'purchase', 'due_date',
        $location_id);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        return view('reportmanagement::Accounting.account_payable_ageing_details')
        ->with(compact('business_locations', 'report_details'));
    }
}
