@extends('layouts.app')

@section('title', __('Operation'))

@section('content')

@include('reportmanagement::Layouts.navbar')

<!-- Product -->
<section class="content-header">
    <h1>Product</h1>
    <input style="margin-left: auto; border-color: orange;" type="text" id="filterInput"
           class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
</section>
<hr>
<section class="content">
    <div class="row" id="reportContainer">
        <div class="col-md-6 report-item" data-title="Product Purchase Report">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Product Purchase Report</b></h3>
                </div>
                <div class="box-body">
                    Product Purchase Report
                    <br/>
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
                    <br/>
                    <a href="{{ route('product_sell_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
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
                    <br/>
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
                    <br/>
                    <a href="{{ route('items_report') }}" class="btn btn-primary btn-sm pt-2 Effect">View</a>
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
