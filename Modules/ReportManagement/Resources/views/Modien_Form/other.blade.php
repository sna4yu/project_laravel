@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

    @include('reportmanagement::Modien_Form.Layouts.navbar')

<!-- Other -->
<section class="content-header">
    <h1>Others</h1>
    <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput"
           class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
</section>
<hr>
<section class="content">
    <div class="row" id="reportContainer">
        <div class="col-md-6 report-item" data-title="Stock Report">
            <div class="box box-primary">
                <div class=" box-header with-border text-center">
                    <h3 class="box-title"><b>Stock Report</b></h3>
                </div>
                <div class="box-body">
                    Stock Report
                    <br/>
                </div>
                <a href="{{ route('stock_report') }}" class="btn bg-primary text-white btn-sm pt-2 Effect btn-block">View</a>
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
    .box {
            border: 1px solid #17a2b8;
            border-radius: .50rem;
        }
</style>