@extends('layouts.app')
@section('title', __('invetorymangament::inventory.inventory'))
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('invetorymangament::inventory.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
@endsection

@section('content')

    <section class="content-header">
        <h1>@lang('invetorymangament::inventory.stock_inventory')</h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header text-center" style="background-color:#484848;color:#EDAF11;font-size: 30px;">
                @lang("invetorymangament::inventory.products_reports_decrease")
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" id="product_row_index" value="0">
                    <input type="hidden" id="total_amount" name="final_total" value="0">
                    <div class="table-responsive">

                    </div>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>

        <table id="example1" class="display nowrap" style="width:100%">
            <thead>
            <tr>
                <th  style="text-align: right">@lang("invetorymangament::inventory.product_name")</th>
                <th  style="text-align: right">@lang("invetorymangament::inventory.product_barcode")</th>
                <th  style="text-align: right">@lang("invetorymangament::inventory.current_amount")</th>
                <th  style="text-align: right">@lang("invetorymangament::inventory.amount_after_inventory")</th>
                <th  style="text-align: right">@lang("invetorymangament::inventory.amount_difference")</th>
                {{-- <th  style="text-align: right">@lang("invetorymangament::inventory.options")</th> --}}

            </tr>
            </thead>
            <tbody>
            @include("invetorymangament::partials.disabilityReports" , [$disabilityProductReport])
            </tbody>

        </table>



    </section>

@endsection
@section('javascript')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example1').DataTable({
                columnDefs: [
                    {
                        targets: [0],
                        orderData: [0, 1],
                    },
                    {
                        targets: [1],
                        orderData: [1, 0],
                    },
                    {
                        targets: [4],
                        orderData: [4, 0],
                    },
                ],
            });
        });
    </script>
    <script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script>
    {{-- <script src="{{ asset('invetorymangament::js/inventory.js?v=' . $asset_v) }}"></script> --}}
@include('invetorymangament::partials.mainscript')

    <script src="{{ asset('js/vendor.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">
        __page_leave_confirmation('#purchase_return_form');
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
