@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

@include('reportmanagement::Elegant_Form.Layouts.navbar')

    <!-- Customer -->
    <section class="content-header">
        <h1>Customer</h1>
        <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput"
            class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
    </section>
    <hr>
    <section class="content">
                <div class="row" id="customer-reportContainer">
                    <div class="col-md-6 report-item" data-title="Customer Group Report">
                        <div class="box box-info">
                            <div class="bg-info box-header with-border">
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
                </div>
    </section>

    <!-- Supplier & Customer -->
    <section class="content-header">
        <h1>Supplier</h1>
    </section>
    <hr>
    <section class="content">
                <div class="row" id="supplier-reportContainer">
                    <div class="col-md-6 report-item" data-title="Supplier & Customer Report">
                        <div class="box box-info">
                            <div class="bg-info box-header with-border">
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
                </div>
    </section>

    <!-- Staff -->
    <section class="content-header">
        <h1>Staff</h1>
    </section>
    <hr>
    <section class="content">
                <div class="row" id="staff-reportContainer">
                    <div class="col-md-6 report-item" data-title="Supplier & Customer Report">
                        <div class="box box-info">
                            <div class="bg-info box-header with-border">
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
                </div>
    </section>

@endsection

<script type="text/javascript">
    function filterReports(val) {
        val = val.toUpperCase();
        let customerReportItems = document.querySelectorAll('#customer-reportContainer .report-item');
        let supplierReportItems = document.querySelectorAll('#supplier-reportContainer .report-item');
        let staffReportItems = document.querySelectorAll('#staff-reportContainer .report-item');

        // Toggle section headers visibility based on filter input
        document.getElementById('customer-header').style.display = (val === '') ? 'block' : 'none';
        document.getElementById('supplier-header').style.display = (val === '') ? 'block' : 'none';
        document.getElementById('staff-header').style.display = (val === '') ? 'block' : 'none';

        filterReportItems(val, customerReportItems);
        filterReportItems(val, supplierReportItems);
        filterReportItems(val, staffReportItems);
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
            border: 1px solid #00BFFF;
        }
</style>
