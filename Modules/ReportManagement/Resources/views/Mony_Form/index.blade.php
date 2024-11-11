@extends('layouts.app')

@section('title', __('reportmanagement::lang.report_management'))

@section('content')

<section class="section">
@include('reportmanagement::Mony_Form.Layouts.navbar')

<section class="content-header">
    <h1>Financial</h1>
    <input style="margin-left: auto; border-color: primary;" type="text" id="filterInput" class="form-control search-input" placeholder="Search Reports..." oninput="filterReports(this.value)">
</section><hr>

    <div class="Container">
        <div class="report-item" data-title="CRM">
            <div class="boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="report-item" data-title="CRM">
            <div class="boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="report-item" data-title="CRM">
            <div class="boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
                    <a href="{{ route('customer_supplier_report') }}" class="btn-sm pt-2 Effect btn-block">View</a>
                </div>
            </div>
        </div>
        <div class="report-item" data-title="CRM">
            <div class="boxs">
                <span></span>
                <div class="content">
                    <h3 class="box-title">Header</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, quod!</p>
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
        width: 250px;              /* Sets the width to 250 pixels */
        border-radius: 25px;       /* Applies rounded corners */
        text-align: center;        /* Aligns text to the center */
        padding-right: 10px;       /* Adds some padding on the right for better spacing */
    }
    .section {
        background: #0c192c;
        overflow: hidden ;
    }
    
    .content-header h1 {
        color: #fff;
        font-size: 50px;
        font-family: 'Franklin Gothic Medium';
        font-style: oblique;
    }
    .Container{
        display: flex ;
        justify-content: center ;
        align-items: center ;
        flex-wrap: wrap ;
        padding: 40px 0;
    }
    .Container .boxs{
        position: relative;
        width: 320px;
        height: 400px;
        display: flex ;
        justify-content: center ;
        align-items: center;
        transition: 0.5s;
        margin: 40px 30px;
    }
    .Container .boxs::before{
        content: '';
        position: absolute ;
        top: 0;
        left: 30%;
        width: 50%;
        height: 100%;
        background: #fff;
        border-radius: 10px;
        transform: skewX(15deg);
        transition: 0.5s;
    }
    .Container .boxs::after{
        content: '';
        position: absolute ;
        top: 0;
        left: 30%;
        width: 50%;
        height: 100%;
        background: #fff;
        border-radius: 10px;
        transform: skewX(15deg);
        transition: 0.5s;
        filter: blur(30px) ;
        transition: 0.5s;
    }
    .Container .boxs:hover::before,
    .Container .boxs:hover::after
    {
        transform: skewX(0) ;
        left: 20px;
        width: calc(100% - 90px);
    }
    .Container .boxs::before,
    .Container .boxs::after
    {
        background: linear-gradient(315deg, #03a9f4 , #ff0058) ;
    }
    .Container .boxs span{
        display: block ;
        position: absolute ;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 50;
        pointer-events: none;
    }
    .Container .boxs span::before{
        content: '';
        position: absolute ;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        background: rgba(255, 255, 255,0.1);
        backdrop-filter: blur(10px) ;
        opacity: 0;
        transition: 0.5s;
        animation: animate 2s ease-in-out infinite ;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
    .Container .boxs:hover span::before
    {
        top: -50px;
        left: 50px;
        width: 100px;
        height: 100px;
        opacity: 1;
    }
    .Container .boxs span::after{
        content: '';
        position: absolute ;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        background: rgba(255, 255, 255,0.1);
        backdrop-filter: blur(10px) ;
        opacity: 0;
        transition: 0.5s;
        animation: animate 2s ease-in-out infinite ;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        animation-delay: -1s;
        }
    .Container .boxs:hover span::after
    {
        bottom: -50px;
        right: 50px;
        width: 100px;
        height: 100px;
        opacity: 1;
    }
    @keyframes animate {
        0%,100%
        {
            transform: translateY(10px) ;
        }
        50%
        {
            transform: translateY(-10px) ;
        }
    }
    .Container .boxs .content{
        position: relative;
        left: 0;
        padding: 40px 40px;
        background: rgba(255, 255, 255,0.05);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        backdrop-filter: blur(10px) ;
        z-index: 1;
        transform: 0.5s;
        color: #fff;
    }
    .Container .boxs:hover .content{
        left: -25px;
        height: 350px;
        padding: 60px 40px;
    }
    .Container .boxs .content h3{
        font-size: 2em;
        color: #fff;
        margin-bottom: 10px;
    }
    .Container .boxs .content a{
        display: inline-block;
        font-size: 1.1em;
        color: #111;
        padding: 10px;
        border-radius: 4px;
        font-weight: 700;
        margin-top: 5px;
        background: #fff;
        width: 100px;
        text-align: center;
        
    }
</style>
