@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

    @include('reportmanagement::Layouts.navbar')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Report Management</h1>
        <input style="margin-left: auto; border-color: orange;" type="text" id="filterInput" class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
    </section>

    <section class="content">
        <!-- Search Input -->
            <div class="row" id="reportContainer">
                <div class="col-md-6 report-item" data-title="Profit / Loss Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Profit / Loss Report</b></h3>
                        </div>
                        <div class="box-body">
                            Profit / Loss Report
                            <br />
                            <a href="{{ route('report_profit_loss') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Purchase & Sale">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Purchase & Sale</b></h3>
                        </div>
                        <div class="box-body">
                            Purchase & Sale
                            <br />
                            <a href="{{ route('report_purchase_sell') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Tax Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Tax Report</b></h3>
                        </div>
                        <div class="box-body">
                            Tax Report
                            <br />
                            <a href="{{ route('tax_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Supplier & Customer Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Supplier & Customer Report</b></h3>
                        </div>
                        <div class="box-body">
                            Supplier & Customer Report
                            <br />
                            <a href="{{ route('customer_supplier_report') }}"
                                class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Customer Group Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Customer Group Report</b></h3>
                        </div>
                        <div class="box-body">
                            Customer Group Report
                            <br />
                            <a href="{{ route('customer_group_report') }}"
                                class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Stock Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Stock Report</b></h3>
                        </div>
                        <div class="box-body">
                            Stock Report
                            <br />
                            <a href="{{ route('stock_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Stock Expiry Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Stock Expiry Report</b></h3>
                        </div>
                        <div class="box-body">
                            Stock Expiry Report
                            <br />
                            <a href="{{ route('stock_expiry') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Stock Adjustment Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Stock Adjustment Report</b></h3>
                        </div>
                        <div class="box-body">
                            Stock Adjustment Report
                            <br />
                            <a href="{{ route('stock_adjustment') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Trending Products">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Trending Products</b></h3>
                        </div>
                        <div class="box-body">
                            Trending Products
                            <br />
                            <a href="{{ route('trending_product') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Items Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Items Report</b></h3>
                        </div>
                        <div class="box-body">
                            Items Report
                            <br />
                            <a href="{{ route('items_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Product Purchase Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Product Purchase Report</b></h3>
                        </div>
                        <div class="box-body">
                            Product Purchase Report
                            <br />
                            <a href="{{ route('product_purchase') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Product Sell Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Product Sell Report</b></h3>
                        </div>
                        <div class="box-body">
                            Product Sell Report
                            <br />
                            <a href="{{ route('product_sell_report') }}"
                                class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Purchase Payment Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Purchase Payment Report</b></h3>
                        </div>
                        <div class="box-body">
                            Purchase Payment Report
                            <br />
                            <a href="{{ route('purchase_payment') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Sell Payment Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Sell Payment Report</b></h3>
                        </div>
                        <div class="box-body">
                            Sell Payment Report
                            <br />
                            <a href="{{ route('sell_payment_report') }}"
                                class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Expense Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Expense Report</b></h3>
                        </div>
                        <div class="box-body">
                            Expense Report
                            <br />
                            <a href="{{ route('expense_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Register Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Register Report</b></h3>
                        </div>
                        <div class="box-body">
                            Register Report
                            <br />
                            <a href="{{ route('register_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Sale Representative Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Sale Representative Report</b></h3>
                        </div>
                        <div class="box-body">
                            Sale Representative Report
                            <br />
                            <a href="{{ route('sales_representative_report') }}"
                                class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Activity Log">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Activity Log</b></h3>
                        </div>
                        <div class="box-body">
                            Activity Log
                            <br />
                            <a href="{{ route('activity_log') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Trial Balance Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Trial Balance Report</b></h3>
                        </div>
                        <div class="box-body">
                            A trial balance displays summary of all ledger balances, and helps in checking whether the transactions are correct and balanced.
                            <br />
                            <a href="{{ route('trialBalance_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Ledger Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Ledger Report</b></h3>
                        </div>
                        <div class="box-body">
                            The ledger report contains the classified and detailed information of all the individual accounts including the debit and credit aspects.
                            <br />
                            <a href="{{$ledger_url}}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Balance Sheet Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Balance Sheet Report</b></h3>
                        </div>
                        <div class="box-body">
                            This report gives you an immediate status of your accounts at a specified date. 
                            <br />
                            <a href="{{ route('balanceSheet_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Account Receivable Ageing Report">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Account Receivable Ageing Report(Summary)</b></h3>
                        </div>
                        <div class="box-body">
                            This report shows summary of all the sales pending invoices in mentioned days range as per the due date.
                            <br />
                            <a href="{{ route('account_receivable_ageing_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Account Receivable Ageing Details (Details)">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Account Receivable Ageing Details (Details)</b></h3>
                        </div>
                        <div class="box-body">
                            This report shows details of all the sales pending invoices in mentioned days range as per the due date.
                            <br />
                            <a href="{{ route('account_receivable_ageing_details') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Account Payable Ageing Report (Summary)">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Account Payable Ageing Report (Summary)</b></h3>
                        </div>
                        <div class="box-body">
                            This report shows summary of all the purchase pending invoices in mentioned days range as per the due date.
                            <br />
                            <a href="{{ route('account_payable_ageing_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Account Payable Ageing Details (Details)">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Account Payable Ageing Details (Details)</b></h3>
                        </div>
                        <div class="box-body">
                            This report shows summary of all the purchase pending invoices in mentioned days range as per the due date.
                            <br />
                            <a href="{{ route('account_payable_ageing_details') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Yearly Income & Expense">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Yearly Income & Expense</b></h3>
                        </div>
                        <div class="box-body">
                            This report shows yearly income and expense report. This report shows  invoices in mentioned days range as per the due date.
                            <br />
                            <a href="{{ route('yearly_income_expense') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Payroll">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Payroll</b></h3>
                        </div>
        
                        <div class="box-body">
                            @lang( 'accounting::lang.balance_sheet_description')
                            <br/>
                            <li class="list-unstyled" ><a href="{{action([\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'index'])}}" class="btn btn-primary btn-sm pt-2">view</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 report-item" data-title="Crm">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>CRM</b></h3>
                        </div>
        
                        <div class="box-body">
                            @lang( 'accounting::lang.balance_sheet_description')
                            <br/>
                            <li class="list-unstyled" ><a href="{{action([\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'index'])}}" class="btn btn-primary btn-sm pt-2">view</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 report-item" data-title="Delivery">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Delivery</b></h3>
                        </div>
        
                        <div class="box-body">
                            This is the Daily of the Delivery Report.
                            <br/>
                            <a href="{{ route('delivery_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>

            </div>
    </section>

@endsection

<script type="text/javascript">
    function filterReports(val) {
        val = val.toUpperCase();
        let reportItems = document.getElementsByClassName('report-item');

        Array.prototype.forEach.call(reportItems, item => {
            let title = item.getAttribute('data-title').toUpperCase();

            if (!title.includes(val)) {
                item.style.display = "none";
            } else {
                item.style.display = "block";
            }
        });
    }
</script>

<style>
   #filterInput {
    width: 250px;              /* Sets the width to 50 pixels */
    border-radius: 25px;       /* Applies rounded corners */
    text-align: center;        /* Aligns text to the right */
    padding-right: 10px;      /* Adds some padding on the right for better spacing */
}
</style>
