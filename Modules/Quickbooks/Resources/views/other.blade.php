@extends('layouts.app')

@section('title', __('Other'))

@section('content')

@include('test::Layouts.navbar')

<!-- Other -->
<section class="content-header">
    <h1>Others</h1>
    <input style="margin-left: auto; border-color: orange;" type="text" id="filterInput"
           class="form-control search-input" placeholder="Search Reports..."" oninput="filterReports(this.value)">
</section>
<hr>
<section class="content">
    <div class="row" id="reportContainer">
        <div class="col-md-6 report-item" data-title="Stock Report">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Stock Report</b></h3>
                </div>
                <div class="box-body">
                    Stock Report
                    <br/>
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
                    <br/>
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
                    <br/>
                    <a href="{{ route('stock_adjustment') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
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
                    <br/>
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
                    <br/>
                    <a href="{{ route('sales_representative_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
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
                    <br/>
                    <a href="{{ route('activity_log') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
                </div>
            </div>
        </div>
    </div>
</section>                

@endsection

<script type="text/javascript">
    function filterReports(val) {
        val = val.toUpperCase();
        let reportItems = document.querySelectorAll('#reportContainer .report-item');

        filterReportItems(val, reportItems);

        // Toggle other header visibility based on filter input
        document.getElementById('other-header').style.display = (val === '') ? 'block' : 'none';
    }

    function filterReportItems(val, reportItems) {
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
        width: 250px;
        border-radius: 25px;
        text-align: center;
        padding-right: 10px;
    }
</style>
