@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

@include('reportmanagement::Mony_Form.Layouts.navbar')
<div class="bg">
    <div class="bubbles">
        <span style="--i:11"></span>
        <span style="--i:12"></span>
        <span style="--i:24"></span>
        <span style="--i:10"></span>
        <span style="--i:14"></span>
        <span style="--i:23"></span>
        <span style="--i:18"></span>
        <span style="--i:16"></span>
        <span style="--i:19"></span>
        <span style="--i:20"></span>
        <span style="--i:22"></span>
        <span style="--i:25"></span>
        <span style="--i:18"></span>
        <span style="--i:21"></span>
        <span style="--i:13"></span>
        <span style="--i:15"></span>
        <span style="--i:21"></span>
        <span style="--i:17"></span>
        <span style="--i:13"></span>
        <span style="--i:28"></span>
        <span style="--i:11"></span>
        <span style="--i:12"></span>
        <span style="--i:24"></span>
        <span style="--i:10"></span>
        <span style="--i:14"></span>
        <span style="--i:23"></span>
        <span style="--i:18"></span>
        <span style="--i:16"></span>
        <span style="--i:19"></span>
        <span style="--i:20"></span>
        <span style="--i:22"></span>
        <span style="--i:25"></span>
        <span style="--i:18"></span>
        <span style="--i:21"></span>
        <span style="--i:13"></span>
        <span style="--i:15"></span>
        <span style="--i:21"></span>
        <span style="--i:17"></span>
        <span style="--i:13"></span>
        <span style="--i:28"></span>
    </div>
</div>

<section class="section">

    <section class="content-header">
        <h1>Financial</h1>
        <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput"
            class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
    </section>
    <hr>
    <!-- Search Input -->
    <div class="row" id="reportContainer">
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs boxxx">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 report-item" data-title="CRM">
            <div class="box box-danger boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
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
        width: 250px;
        /* Sets the width to 250 pixels */
        border-radius: 25px;
        /* Applies rounded corners */
        text-align: center;
        /* Aligns text to the center */
        padding-right: 10px;
        /* Adds some padding on the right for better spacing */
    }

    .section {
        background-color: #0c192c;
        padding: 10px;
    }

    .content-header h1 {
        color: #fff;
        font-size: 50px;
        font-family: 'Franklin Gothic Medium';
        font-style: oblique;
    }

    .boxs:hover {
        transform: translateY(-20px);
        transition: 0.3s;
    }

    .boxs::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(315deg, #03a9f4, #ff0058);
    }

    .boxs::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, #03a9f4, #ff0058);
        filter: blur(30px);
    }

    .boxs span {
        position: absolute;
        top: 3px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        background: rgba(0, 0, 0, 0.5);
        z-index: 2;
    }

    .boxs span::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 50%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        pointer-events: none;
    }

    .boxs .content {
        position: relative;
        z-index: 10;
        padding: 20px 20px;
        color: #fff;
    }

    .boxs .content h3 {
        font-size: 2em;
        color: #fff;
        margin: 20px;
    }

    .boxs .content p {
        font-size: 1.1em;
        color: #fff;
    }

    .boxs .content a {
        display: inline-block;
        font-size: 1.1em;
        color: #000;
        background: #fff;
        padding: 10px;
        font-weight: 700;
        width: 10rem;
        margin: 20px;
        text-align: center;
    }

    .bg {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .bubbles {
        position: relative;
        display: flex;
    }

    .bubbles span {
        position: relative;
        min-width: 10px;
        height: 10px;
        background: #4fc3dc;
        border-radius: 50%;
        box-shadow: 0 0 0 10px #4fc3dc44, 0 0 50px #4fc3dc, 0 0 100px #4fc3dc;
        margin: 0 20px;
        animation: animate 20s linear infinite;
        animation-duration: calc(85s / var(--i));
    }

    .bubbles span:nth-child(even) {
        background: #ff2d75;
        box-shadow: 0 0 0 10px #ff2d7544, 0 0 10px #ff2d75, 0 0 10px #ff2d75;
    }

    @keyframes animate {
        0% {
            transform: translateY(-100vh) scale(0);
        }

        20% {
            transform: translateY(100vh) scale(1);
        }
    }
</style>