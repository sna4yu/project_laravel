@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

@include('reportmanagement::Tax_Form.Layouts.navbar')

<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>Financial</h1>
        <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput" class="form-control search-input" placeholder="Search Reports..."" oninput="filterReports(this.value)">
    </section>
<hr>

<section class="content">
    <!-- Search Input -->
    <div class="row" id="reportContainer">
        <div class="col-md-4 mb-5 report-item" data-title="Payroll">
            <div class="boxs ">
                <div class="bg-primary ">
                    <div class="row ">
                        <div class="col-md-4 p-4 text-center ">
                            <i class="fas fa-user fa-8x text-white"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="box-header">
                                <h3 class="box-title text-white"><b>Payroll</b></h3>
                            </div>
                            <div class="box-body text-white">
                                This report gives you an immediate status of your accounts at a specified date. You can
                                call
                                it a "Snapshot" view of the current position (day) of the financial year.
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{action([\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'index'])}}"
                    class="btn bg-white text-primary text-left btn-sm pt-2 Effect btn-block">
                    View <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="boxs ">
                <div class="bg-primary ">
                    <div class="row ">
                        <div class="col-md-4 p-4 text-center ">
                            <i class="fas fa-users-cog fa-8x text-white"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="box-header">
                                <h3 class="box-title text-white"><b>CRM</b></h3>
                            </div>
                            <div class="box-body text-white">
                                This report gives you an immediate status of your accounts at a specified date. You can
                                call
                                it a "Snapshot" view of the current position (day) of the financial year.
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ action([\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'index']) }}"
                    class="btn bg-white text-primary text-left btn-sm pt-2 Effect btn-block">
                    View <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="Product Purchase">
            <div class="boxs mb-3">
                <div class="bg-primary ">
                    <div class="row ">
                        <div class="col-md-4 p-4 text-center ">
                            <i class="fas fa-shopping-cart fa-8x text-white"></i>
                        </div>
                        <div class="col-md-8">
                            <div class="box-header">
                                <h3 class="box-title text-white"><b>Product Purchase</b></h3>
                            </div>
                            <div class="box-body text-white">
                                This report gives you an immediate status of your accounts at a specified date. You can
                                call
                                it a "Snapshot" view of the current position (day) of the financial year.
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('product_purchase') }}"
                    class="btn bg-white text-primary text-left btn-sm btn-block">
                    View <i class="fas fa-arrow-right"></i>
                </a>
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
.boxs {
        border: 1px solid #17a2b8;
        border-radius: 0.5rem;
    }
</style>