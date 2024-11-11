<?php

namespace Modules\Quickbooks\Http\Controllers;

use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\AccountingAccount;
use Modules\Accounting\Entities\AccountingAccTransMapping;
use Modules\Accounting\Utils\AccountingUtil;
use Yajra\DataTables\Facades\DataTables;


class ReportManagementController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $util;

    /**
     * Constructor
     *
     * @param  ProductUtils  $product
     * @return void
     */
    public function __construct(Util $util, ModuleUtil $moduleUtil, AccountingUtil $accountingUtil)
    {
        $this->util = $util;
        $this->moduleUtil = $moduleUtil;
        $this->accountingUtil = $accountingUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module')) ||
        //     ! (auth()->user()->can('accounting.view_transfer'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            $transfers = AccountingAccTransMapping::where('accounting_acc_trans_mappings.business_id', $business_id)
                        ->join('users as u', 'accounting_acc_trans_mappings.created_by', 'u.id')
                        ->join('accounting_accounts_transactions as from_transaction', function ($join) {
                            $join->on('from_transaction.acc_trans_mapping_id', '=', 'accounting_acc_trans_mappings.id')
                                    ->where('from_transaction.type', 'debit');
                        })
                        ->join('accounting_accounts_transactions as to_transaction', function ($join) {
                            $join->on('to_transaction.acc_trans_mapping_id', '=', 'accounting_acc_trans_mappings.id')
                                    ->where('to_transaction.type', 'credit');
                        })
                        ->join('accounting_accounts as from_account',
                        'from_transaction.accounting_account_id', 'from_account.id')
                        ->join('accounting_accounts as to_account',
                        'to_transaction.accounting_account_id', 'to_account.id')
                        ->where('accounting_acc_trans_mappings.type', 'transfer')
                        ->select(['accounting_acc_trans_mappings.id',
                            'accounting_acc_trans_mappings.ref_no',
                            'accounting_acc_trans_mappings.operation_date',
                            'accounting_acc_trans_mappings.note',
                            DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) 
                            as added_by"),
                            'from_transaction.amount',
                            'from_account.name as from_account_name',
                            'to_account.name as to_account_name',
                        ]);

            if (! empty(request()->start_date) && ! empty(request()->end_date)) {
                $start = request()->start_date;
                $end = request()->end_date;
                $transfers->whereDate('accounting_acc_trans_mappings.operation_date', '>=', $start)
                            ->whereDate('accounting_acc_trans_mappings.operation_date', '<=', $end);
            }

            if (! empty(request()->transfer_from)) {
                $transfers->where('from_account.id', request()->transfer_from);
            }

            if (! empty(request()->transfer_to)) {
                $transfers->where('to_account.id', request()->transfer_to);
            }

            return Datatables::of($transfers)
                ->addColumn(
                    'action', function ($row) {
                        $html = '<div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                                    data-toggle="dropdown" aria-expanded="false">'.
                                    __('messages.actions').
                                    '<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">';
                        if (auth()->user()->can('accounting.edit_transfer')) {
                            $html .= '<li>
                                <a href="#" data-href="'.action([\Modules\Accounting\Http\Controllers\TransferController::class, 'edit'],
                                [$row->id]).'" class="btn-modal" data-container="#create_transfer_modal">
                                    <i class="fas fa-edit"></i>'.__('messages.edit').'
                                </a>
                            </li>';
                        }
                        if (auth()->user()->can('accounting.delete_transfer')) {
                            $html .= '<li>
                                    <a href="#" data-href="'.action([\Modules\Accounting\Http\Controllers\TransferController::class, 'destroy'], [$row->id]).'" class="delete_transfer_button">
                                        <i class="fas fa-trash" aria-hidden="true"></i>'.__('messages.delete').'
                                    </a>
                                    </li>';
                        }

                        $html .= '</ul></div>';

                        return $html;
                    })
                ->editColumn('amount', function ($row) {
                    return $this->util->num_f($row->amount, true);
                })
                ->editColumn('operation_date', function ($row) {
                    return $this->util->format_date($row->operation_date, true);
                })
                ->filterColumn('added_by', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(u.surname, ''), ' ', 
                    COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, '')) like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $business_id = request()->session()->get('user.business_id');

        $first_account = AccountingAccount::where('business_id', $business_id)
                            ->where('status', 'active')
                            ->first();
        $ledger_url = null;
        if (! empty($first_account)) {
            $ledger_url = route('ledger_report', $first_account);
        }

        return view('quickbooks::index')
        ->with(compact('ledger_url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */

    public function people()
    {
        return view('quickbooks::Report_management.people');
    }
    public function operation()
    {
        return view('quickbooks::Report_management.operation');
    }
    public function financial()
    {
        return view('quickbooks::Report_management.financial');
    }
    public function other()
    {
        return view('quickbooks::Report_management.other');
    }
}
