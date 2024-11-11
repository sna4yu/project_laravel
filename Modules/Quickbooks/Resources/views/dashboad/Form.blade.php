@extends('layouts.app')

@section('title', __('test::lang.report_management'))

@section('content')

<section class="section">
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
    <section class="content-header">
        <h1>SELECT FORM</h1><br>
    </section>
    <div class="row" id="reportContainer">
        <div class="col-md-3 mb-5 report-item " data-title="CRM">
            <div class="box bgboxs">
                <div class="boxs">
                    <div class="icons"><i class="fa fa-user"></i></div>
                    <div class="content">
                        <h3 class="box-title">Classic</h3>
                        <a href="{{ route('quickbooks_report_management') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box bgboxs">
                <div class="boxs">
                    <div class="icons"><i class="fa fa-user"></i></div>
                    <div class="content">
                        <h3 class="box-title">Elegant</h3>
                        <a href="{{ route('Elegant_Form') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box bgboxs">
                <div class="boxs">
                    <div class="icons"><i class="fa fa-user"></i></div>
                    <div class="content">
                        <h3 class="box-title">Modien</h3>
                        <a href="{{ route('Modien_Form') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box bgboxs">
                <div class="boxs">
                    <div class="icons"><i class="fa fa-user"></i></div>
                    <div class="content">
                        <h3 class="box-title">Tax</h3>
                        <a href="{{ route('Tax_Form') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-5 report-item" data-title="CRM">
            <div class="box bgboxs">
                <div class="boxs">
                    <div class="icons"><i class="fa fa-user"></i></div>
                    <div class="content">
                        <h3 class="box-title">Mony</h3>
                        <a href="{{ route('Mony_Form') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<style>
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

    .bgboxs {
        position: relative;
        width: 320px;
        height: 440px;
        background: linear-gradient(45deg, #03a9f4, #ff0058);

        box-shadow: inset 5px 5px 5px rgba(0, 0, 0, 0.05),
            inset -5px -5px 5px rgba(255, 255, 255, 0.05),
            5px 5px 5px rgba(0, 0, 0, 0.05),
            -5px -5px 5px rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }

    .bgboxs .boxs {
        position: absolute;
        top: 0px;
        left: 0px;
        right: 0px;
        bottom: 0px;
        background: #ebf5fc;
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.25), 0 6px 6px rgba(0, 0, 0, 0.25);
        border-radius: 5px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 0 20px #03a9f4;

    }

    .bgboxs:hover .boxs {
        transform: scale(1.08);
    }

    .icons {
        height: 320px;
        width: 100%;
        background: linear-gradient(45deg, #03a9f4, #ff0058);
        border-radius: 0% 0% 0% 100% / 0% 0% 0% 50%;
        display: grid;
        color: rgba(0, 0, 0, 0.5);
        top: -1px;
        place-items: center;
        position: absolute;
        font-size: 3em;
        transition: 0.5s;
        pointer-events: none;
    }

    .bgboxs:hover .boxs .icons {
        color: #fff;
    }

    .bgboxs .boxs .box-title {
        color: rgba(0, 0, 0, 0.5);
    }

    .bgboxs:hover .boxs .box-title {
        color: #fff;
    }

    .bgboxs .boxs .content {
        display: grid;
        bottom: -1px;
        place-items: center;
        position: absolute;
        padding: none;
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
        text-align: center;
    }

    .bgboxs:hover .boxs .content a {
        background: #ff0058;
    }

    .bg {
        position: absolute;
        width: 100%;
        height: 100vh;
        overflow: hidden;
    }

    .bubbles {
        position: relative;
        display: flex;
    }

    .bubbles span {
        position: relative;
        min-width: 30px;
        height: 30px;
        background: #4fc3dc;
        border-radius: 50%;
        box-shadow: 0 0 0 10px #4fc3dc44, 0 0 50px #4fc3dc, 0 0 100px #4fc3dc;
        margin: 0 6px;
        animation: animate 20s linear infinite;
        animation-duration: calc(85s / var(--i));
    }

    .bubbles span:nth-child(even) {
        background: #ff2d75;
        box-shadow: 0 0 0 10px #ff2d7544, 0 0 50px #ff2d75, 0 0 100px #ff2d75;
    }

    @keyframes animate {
        0% {
            transform: translateY(100vh) scale(0);
        }

        100% {
            transform: translateY(-100vh) scale(1);
        }
    }
</style>