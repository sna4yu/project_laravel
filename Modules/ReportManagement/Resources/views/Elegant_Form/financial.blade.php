@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

    @include('reportmanagement::Elegant_Form.Layouts.navbar')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Financial</h1>
        <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput" class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
    </section>
    <hr>
    <section class="content">
        <!-- Search Input -->
            <div class="row" id="reportContainer">
                <div class="col-md-6 report-item" data-title="Profit / Loss Report">
                    <div class="box box-info">
                        <div class="bg-info box-header with-border">
                            <h3 class="box-title"><b>Profit / Loss Report</b></h3>
                        </div>
                        <div class="box-body">
                            Profit / Loss Report
                            <br />
                            <a href="{{ route('report_profit_loss') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="content-header">
        <h1>Accounting</h1>
    </section>
    <hr>
    <section class="content">
        <!-- Search Input -->
            <div class="row" id="reportContainer">
                <div class="col-md-6 report-item" data-title="Expense Report">
                    <div class="box box-info">
                        <div class="bg-info box-header with-border">
                            <h3 class="box-title"><b>Expense Report</b></h3>
                        </div>
                        <div class="box-body">
                            Expense Report
                            <br />
                            <a href="{{ route('expense_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

@endsection

<script type="text/javascript">
function filterReports(val) {
        val = val.toUpperCase();
        let financialReportItems = document.querySelectorAll('#financial-reportContainer .report-item');
        let accountingReportItems = document.querySelectorAll('#accounting-reportContainer .report-item');

        // Toggle financial header visibility based on filter input
        document.getElementById('financial-header').style.display = (val === '') ? 'block' : 'none';

        // Toggle accounting header visibility based on filter input
        document.getElementById('accounting-header').style.display = (val === '') ? 'block' : 'none';

        filterReportItems(val, financialReportItems);
        filterReportItems(val, accountingReportItems);
    }
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
.box {
            border: 1px solid #00BFFF;
        }
</style>
