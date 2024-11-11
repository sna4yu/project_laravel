@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

@include('reportmanagement::Mony_Form.Layouts.navbar')

<section class="section">
    <section class="content-header">
        <h1>Financial</h1>
        <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput"
            class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
    </section>
    <hr>

    <div class="row" id="reportContainer">
        <div class="col-md-3 mb-5 report-item " data-title="CRM">
            <div class="box box-primary bgboxs">
                <div class="boxs">
                    <div class="content">
                        <h2><i class="fa fa-user"></i></h2>
                        <h3 class="box-title">Header</h3>
                        <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                        <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box box-primary bgboxs">
                <div class="boxs ">
                    <div class="content">
                        <h2><i class="fa fa-user"></i></h2>
                        <h3 class="box-title">Header</h3>
                        <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                        <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box box-primary bgboxs">
                <div class="boxs">
                    <div class="content">
                        <h2><i class="fa fa-user"></i></h2>
                        <h3 class="box-title">Header</h3>
                        <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                        <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box box-primary bgboxs">
                <div class="boxs">
                    <div class="content">
                        <h2><i class="fa fa-user"></i></h2>
                        <h3 class="box-title">Header</h3>
                        <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                        <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box box-primary bgboxs">
                <div class="boxs">
                    <div class="content">
                        <h2><i class="fa fa-user"></i></h2>
                        <h3 class="box-title">Header</h3>
                        <p class="box-body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                        <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
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
    function falling() {
        let e = document.createElement('div');
        e.setAttribute('class', 'circle');
        document.querySelector('.section').appendChild(e);
        let size =Math.random() *25;
        e.style.width = 5 +size + 'px';
        e.style.left = Math.random() * +innerWidth + 'px';
        let angle = Math.random() *360;
        e.style.filter = `hue-rotate(${angle}deg)`;

        setTimeout(function () {
            document.querySelector('.section').removeChild(e);
        }, 10000);
    }

    setInterval(function () {
        falling();
    }, 200);

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
        background: #0c192c;
        padding: 10px;
        background-image: linear-gradient(to right,#333 1px, transparent 1px),
        linear-gradient(to bottom,#333 1px, transparent 1px)  ;
        background-size: 3vh 3vh ;
        overflow: hidden ;
        position: relative;
    }

    .content-header h1 {
        color: #fff;
        font-size: 50px;
        font-family: 'Franklin Gothic Medium';
        font-style: oblique;
    }

    .bgboxs {
        position: relative;
        width: 420px;
        height: 440px;
    }

    .bgboxs .boxs {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        background: #ebf5fc;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-radius: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: 0.5s;
    }

    .bgboxs:hover .boxs {
        transform: translateY(-50px);
        box-shadow: 0 0 20px #03a9f4;
        background: linear-gradient(45deg, #03a9f4, #ff0058);
    }

    .bgboxs .boxs .content {
        padding: 20px;
        text-align: center;
    }

    .bgboxs .boxs .content h2 {
        position: absolute;
        top: -10px;
        right: 30px;
        font-size: 9em;
        color: rgba(0, 0, 0, 0.08);
        transition: 0.5s;
        pointer-events: none;
    }

    .bgboxs:hover .boxs .content h2 {
        color: rgba(0, 0, 0, 0.5);
    }

    .bgboxs .boxs .content h3 {
        font-size: 1.8em;
        color: #777;
        z-index: 1;
        transition: 0.5s;
    }

    .bgboxs:hover .boxs .content h3 {
        color: #fff;
    }

    .bgboxs .boxs .content p {
        font-size: 1em;
        font-weight: 300;
        color: #777;
        z-index: 1;
        transition: 0.5s;
    }

    .bgboxs:hover .boxs .content p {
        color: #fff;
    }

    .bgboxs .boxs .content a {
        position: relative;
        display: inline-block;
        padding: 8px 20px;
        background: #03a9f4;
        margin-top: 20px;
        border-radius: 20px;
        color: #fff;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        width: 10em;
    }

    .bgboxs:hover .boxs .content a {
        background: #4aff03;
    }

    .circle {
        position: absolute ;
        top: 0;
        width: 20px;
        aspect-ratio: 1/1;
        border: 5px solid rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        background: #0f0;
        animation: animate 10s linear forwards;
        transform-origin: top;
    }

    @keyframes animate {
        0% {
            transform: translateY(0vh) scale(0);
        }
        10% {
            transform: translateY(0vh) scale(1);
        }
        45% {
            transform: translateY(0vh) scale(1);
        }
        55% {
            transform: translateY(calc(100vh - 100%)) scale(1);
        }
        90% {
            transform: translateY(calc(100vh - 100%)) scale(1);
            transform-origin: bottom;
        }
        100% {
            transform: translateY(calc(100vh - 100%)) scale(0);
            transform-origin: bottom;
        }
    }
</style>