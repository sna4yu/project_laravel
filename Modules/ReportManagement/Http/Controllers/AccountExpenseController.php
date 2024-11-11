<?php

namespace Modules\ReportManagement\Http\Controllers;

use App\BusinessLocation;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Modules\Accounting\Entities\AccountingAccount;
use Modules\Accounting\Utils\AccountingUtil;
use App\ExpenseCategory;
use App\Transaction;
use Yajra\DataTables\Facades\DataTables;



class AccountExpenseController extends Controller
{
    protected $accountingUtil;

    protected $businessUtil;

    protected $moduleUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(AccountingUtil $accountingUtil, BusinessUtil $businessUtil, ModuleUtil $moduleUtil)
    {
        $this->accountingUtil = $accountingUtil;
        $this->businessUtil = $businessUtil;
        $this->moduleUtil = $moduleUtil;
    }

    public function index()
    {
        $business_id = request()->session()->get('user.business_id');

        if (request()->ajax()) {
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $transactions = DB::table('transactions')
                ->leftJoin('expense_categories AS ec', 'transactions.expense_category_id', '=', 'ec.id')
                ->leftJoin('contacts AS c', 'transactions.contact_id', '=', 'c.id')
                ->where('transactions.business_id', '=', $business_id)
                ->select(
                    'transactions.*',
                    'ec.name AS category_name',
                    'ec.id AS ec_id',
                    'c.supplier_business_name AS sbm',
                    'transactions.invoice_no AS invoice_no'
                );

            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (!empty($location_id)) {
                    $transactions->where('transactions.location_id', $location_id);
                }
            }

            if (!empty($start_date) && !empty($end_date)) {
                $transactions->whereDate('transactions.transaction_date', '>=', $start_date)
                    ->whereDate('transactions.transaction_date', '<=', $end_date);
            }

            return Datatables::of($transactions)->make(true);


        }
        
        $business_locations = BusinessLocation::forDropdown($business_id, true);


        return view('reportmanagement::expense.index')
            ->with(compact('business_locations'));
    }

    public function printReport() 
{
    return view('reportmanagement::expense.show');
}
}
