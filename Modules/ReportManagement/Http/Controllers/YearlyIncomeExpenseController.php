<?php

namespace Modules\ReportManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\AccountingAccount;
use Yajra\DataTables\DataTables;
use Modules\Accounting\Entities\AccountingAccountType;

class YearlyIncomeExpenseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $business_id = $request->session()->get('user.business_id');

                // Base query to fetch yearly income and expense
                $query = AccountingAccount::leftJoin('accounting_accounts_transactions as AAT', function ($join) {
                        $join->on('accounting_accounts.id', '=', 'AAT.accounting_account_id')
                             ->where(DB::raw('YEAR(AAT.created_at)'), '=', DB::raw('YEAR(CURDATE())'));
                    })
                    ->where('accounting_accounts.business_id', $business_id)
                    ->groupBy('accounting_accounts.id')
                    ->select([
                        'accounting_accounts.id',
                        'accounting_accounts.name',
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 1 THEN AAT.amount ELSE 0 END) as Jan'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 2 THEN AAT.amount ELSE 0 END) as Feb'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 3 THEN AAT.amount ELSE 0 END) as Mar'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 4 THEN AAT.amount ELSE 0 END) as Apr'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 5 THEN AAT.amount ELSE 0 END) as May'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 6 THEN AAT.amount ELSE 0 END) as Jun'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 7 THEN AAT.amount ELSE 0 END) as Jul'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 8 THEN AAT.amount ELSE 0 END) as Aug'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 9 THEN AAT.amount ELSE 0 END) as Sep'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 10 THEN AAT.amount ELSE 0 END) as Oct'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 11 THEN AAT.amount ELSE 0 END) as Nov'),
                        DB::raw('SUM(CASE WHEN MONTH(AAT.created_at) = 12 THEN AAT.amount ELSE 0 END) as Decem'),
                        DB::raw('SUM(AAT.amount) as total_amount')
                    ]);

                // Apply account type filter
                if ($request->has('account_type_filter') && !empty($request->account_type_filter)) {
                    $query->where('accounting_accounts.account_primary_type', $request->account_type_filter);
                }

                // Apply name filter if present
                if ($request->has('name_filter') && !empty($request->name_filter)) {
                    $query->where('name', 'like', '%' . $request->name_filter . '%');
                }
            
                if ($request->has('id_filter') && !empty($request->id_filter)) {
                    $query->where('id', $request->id_filter);
                }

                // DataTables response
                return DataTables::of($query)
                    ->editColumn('Jan', function ($row) {
                        return '$' . number_format($row->Jan, 2);
                    })
                    ->editColumn('Feb', function ($row) {
                        return '$' . number_format($row->Feb, 2);
                    })
                    ->editColumn('Mar', function ($row) {
                        return '$' . number_format($row->Mar, 2);
                    })
                    ->editColumn('Apr', function ($row) {
                        return '$' . number_format($row->Apr, 2);
                    })
                    ->editColumn('May', function ($row) {
                        return '$' . number_format($row->May, 2);
                    })
                    ->editColumn('Jun', function ($row) {
                        return '$' . number_format($row->Jun, 2);
                    })
                    ->editColumn('Jul', function ($row) {
                        return '$' . number_format($row->Jul, 2);
                    })
                    ->editColumn('Aug', function ($row) {
                        return '$' . number_format($row->Aug, 2);
                    })
                    ->editColumn('Sep', function ($row) {
                        return '$' . number_format($row->Sep, 2);
                    })
                    ->editColumn('Oct', function ($row) {
                        return '$' . number_format($row->Oct, 2);
                    })
                    ->editColumn('Nov', function ($row) {
                        return '$' . number_format($row->Nov, 2);
                    })
                    ->editColumn('Decem', function ($row) {
                        return '$' . number_format($row->Decem, 2);
                    })
                    ->editColumn('total_amount', function ($row) {
                        return '$' . number_format($row->total_amount, 2);
                    })
                    ->make(true);
            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error fetching yearly income and expense data: ' . $e->getMessage());

                // Return error response
                return response()->json(['error' => 'Error fetching data. Please try again later.'], 500);
            }
        }

        $account_types = AccountingAccountType::accounting_primary_type();

        foreach ($account_types as $k => $v) {
            $account_types[$k] = $v['label'];
        }

        // Return non-AJAX view if needed
        return view('reportmanagement::accounting.yearly_income_expense')->with(compact('account_types'));
    }
}
