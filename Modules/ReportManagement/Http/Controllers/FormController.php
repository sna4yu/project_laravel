<?php

namespace Modules\ReportManagement\Http\Controllers;

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
        return view('reportmanagement::Dashboad.Form');
    }
    public function ElegantForm()
    {
        return view('reportmanagement::Elegant_Form.index');
    }
    public function ElegantPeople()
    {
        return view('reportmanagement::Elegant_Form.people');
    }
    public function ElegantOperations()
    {
        return view('reportmanagement::Elegant_Form.operation');
    }
    public function ElegantFinancial()
    {
        return view('reportmanagement::Elegant_Form.financial');
    }
    public function ElegantOther()
    {
        return view('reportmanagement::Elegant_Form.other');
    }
    public function ModienForm()
    {
        return view('reportmanagement::Modien_Form.index');
    }
    public function ModienPeople()
    {
        return view('reportmanagement::Modien_Form.people');
    }
    public function ModienOperations()
    {
        return view('reportmanagement::Modien_Form.operation');
    }
    public function ModienFinancial()
    {
        return view('reportmanagement::Modien_Form.financial');
    }
    public function ModienOther()
    {
        return view('reportmanagement::Modien_Form.other');
    }
    public function MonyForm()
    {
        return view('reportmanagement::Mony_Form.index');
    }
    public function MonyPeople()
    {
        return view('reportmanagement::Mony_Form.people');
    }
    public function MonyOperations()
    {
        return view('reportmanagement::Mony_Form.operation');
    }
    public function MonyFinancial()
    {
        return view('reportmanagement::Mony_Form.financial');
    }
    public function MonyOther()
    {
        return view('reportmanagement::Mony_Form.other');
    }
    public function TaxForm()
    {
        return view('reportmanagement::Tax_Form.index');
    }
    public function TaxPeople()
    {
        return view('reportmanagement::Tax_Form.people');
    }
    public function TaxOperations()
    {
        return view('reportmanagement::Tax_Form.operation');
    }
    public function TaxFinancial()
    {
        return view('reportmanagement::Tax_Form.financial');
    }
    public function TaxOther()
    {
        return view('reportmanagement::Tax_Form.other');
    }


}
