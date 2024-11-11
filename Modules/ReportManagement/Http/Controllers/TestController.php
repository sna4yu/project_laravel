<?php

namespace Modules\ReportManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Transaction;
use App\Utils\BusinessUtil;
use Yajra\DataTables\Facades\DataTables;

class TestController extends Controller
{
    protected $businessUtil;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(BusinessUtil $businessUtil)
    {
        $this->businessUtil = $businessUtil;
    }
    public function index()
    {
        return view('reportmanagement::index');
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
            ->addColumn('reportmanagement', function ($row) {
                return;
            })       
            ->make(true);

        }


        // $transactions = Transaction::where('business_id', $business_id)->whereBetween('transactions.transaction_date', [$start_date, $end_date])->get();
        // Return the results to the view
        return view('reportmanagement::income_report.index');
    }
}
