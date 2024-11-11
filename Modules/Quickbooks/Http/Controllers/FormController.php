<?php

namespace Modules\Quickbooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Transaction;
use App\Utils\BusinessUtil;
use Yajra\DataTables\Facades\DataTables;

class FormController extends Controller
{
    public function index()
    {
        return view('quickbooks::index');
    }
    public function ElegantForm()
    {
        return view('quickbooks::Elegant_Form.index');
    }
    public function ElegantPeople()
    {
        return view('quickbooks::Elegant_Form.people');
    }
    public function ElegantOperations()
    {
        return view('quickbooks::Elegant_Form.operation');
    }
    public function ElegantFinancial()
    {
        return view('quickbooks::Elegant_Form.financial');
    }
    public function ElegantOther()
    {
        return view('quickbooks::Elegant_Form.other');
    }
    public function ModienForm()
    {
        return view('quickbooks::Modien_Form.index');
    }
    public function ModienPeople()
    {
        return view('quickbooks::Modien_Form.people');
    }
    public function ModienOperations()
    {
        return view('quickbooks::Modien_Form.operation');
    }
    public function ModienFinancial()
    {
        return view('quickbooks::Modien_Form.financial');
    }
    public function ModienOther()
    {
        return view('quickbooks::Modien_Form.other');
    }
    public function MonyForm()
    {
        return view('quickbooks::Mony_Form.index');
    }
    public function MonyPeople()
    {
        return view('quickbooks::Mony_Form.people');
    }
    public function MonyOperations()
    {
        return view('quickbooks::Mony_Form.operation');
    }
    public function MonyFinancial()
    {
        return view('quickbooks::Mony_Form.financial');
    }
    public function MonyOther()
    {
        return view('quickbooks::Mony_Form.other');
    }
    public function TaxForm()
    {
        return view('quickbooks::Tax_Form.index');
    }
    public function TaxPeople()
    {
        return view('quickbooks::Tax_Form.people');
    }
    public function TaxOperations()
    {
        return view('quickbooks::Tax_Form.operation');
    }
    public function TaxFinancial()
    {
        return view('quickbooks::Tax_Form.financial');
    }
    public function TaxOther()
    {
        return view('quickbooks::Tax_Form.other');
    }


}