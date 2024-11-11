<?php

namespace Modules\ReportManagement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Transaction;
use Yajra\DataTables\Facades\DataTables;
class StockAdjustmentController extends Controller
{
public function getStockAdjustmentReport(Request $request)
    {
        return view('reportmanagement::Inventory.index');
    }
}