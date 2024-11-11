@extends('layouts.app')
@section('title', __('report.stock_report'))
@section('content')
    @include('reportmanagement::Layouts.navbar')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ __('report.stock_report') }}</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {!! Form::open([
                        'url' => action([\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getStockReport']),
                        'method' => 'get',
                        'id' => 'stock_report_filter_form',
                    ]) !!}
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('location_id', __('purchase.business_location') . ':') !!}
                            {!! Form::select('location_id', $business_locations, null, [
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('category_id', __('category.category') . ':') !!}
                            {!! Form::select('category_id', $categories, null, [
                                'placeholder' => __('messages.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'category_id',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('sub_category_id', __('product.sub_category') . ':') !!}
                            {!! Form::select('sub_category_id', [], null, [
                                'placeholder' => __('messages.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'sub_category_id',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('brand', __('product.brand') . ':') !!}
                            {!! Form::select('brand', $brands, null, [
                                'placeholder' => __('messages.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'brand',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('unit', __('product.unit') . ':') !!}
                            {!! Form::select('unit', $units, null, [
                                'placeholder' => __('messages.all'),
                                'class' => 'form-control select2',
                                'style' => 'width:100%',
                                'id' => 'unit',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('stock_report_date_range', __('report.date_range') . ':') !!}
                            {!! Form::text('stock_report_date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'readonly' => 'readonly',
                                'id' => 'stock_report_date_range',
                            ]) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @endcomponent
            </div>
        </div>
        @can('view_product_stock_value')
            <div class="row">
                <div class="col-md-12">
                    @component('components.widget', ['class' => 'box-warning'])
                        <table class="table no-border">
                            <tr>
                                <td>@lang('report.closing_stock') (@lang('lang_v1.by_purchase_price'))</td>
                                <td>@lang('report.closing_stock') (@lang('lang_v1.by_sale_price'))</td>
                                <td>@lang('lang_v1.potential_profit')</td>
                                <td>@lang('lang_v1.profit_margin')</td>
                            </tr>
                            <tr>
                                <td>
                                    <h3 id="closing_stock_by_pp" class="mb-0 mt-0"></h3>
                                </td>
                                <td>
                                    <h3 id="closing_stock_by_sp" class="mb-0 mt-0"></h3>
                                </td>
                                <td>
                                    <h3 id="potential_profit" class="mb-0 mt-0"></h3>
                                </td>
                                <td>
                                    <h3 id="profit_margin" class="mb-0 mt-0"></h3>
                                </td>
                            </tr>
                        </table>
                    @endcomponent
                </div>
            </div>
        @endcan
        <div class="row">
            <div class="col-md-12">
                @component('components.widget', ['class' => 'box-warning'])
                    @include('report.partials.stock_report_table')
                @endcomponent
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            // Date range picker initialization
            $('#stock_report_date_range').daterangepicker(dateRangeSettings, function(start, end) {
                $('#stock_report_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                stock_report_table.ajax.reload();
                get_stock_value(); // Update stock values when date range changes
            });

            // DataTable columns definition
            var stock_report_cols = [
                { data: 'action', name: 'action', searchable: false, orderable: false },
                { data: 'sku', name: 'variations.sub_sku' },
                { data: 'product', name: 'p.name' },
                { data: 'variation', name: 'variation' },
                { data: 'category_name', name: 'c.name' },
                { data: 'location_name', name: 'l.name' },
                { data: 'unit_price', name: 'variations.sell_price_inc_tax' },
                { data: 'stock', name: 'stock', searchable: false }
            ];

            // Additional columns based on conditions
            if ($('th.stock_price').length) {
                stock_report_cols.push(
                    { data: 'stock_price', name: 'stock_price', searchable: false },
                    { data: 'stock_value_by_sale_price', name: 'stock_value_by_sale_price', searchable: false, orderable: false },
                    { data: 'potential_profit', name: 'potential_profit', searchable: false, orderable: false }
                );
            }

            stock_report_cols.push(
                { data: 'total_sold', name: 'total_sold', searchable: false },
                { data: 'total_transfered', name: 'total_transfered', searchable: false },
                { data: 'total_adjusted', name: 'total_adjusted', searchable: false },
                { data: 'product_custom_field1', name: 'p.product_custom_field1' },
                { data: 'product_custom_field2', name: 'p.product_custom_field2' },
                { data: 'product_custom_field3', name: 'p.product_custom_field3' },
                { data: 'product_custom_field4', name: 'p.product_custom_field4' }
            );

            if ($('th.current_stock_mfg').length) {
                stock_report_cols.push({ data: 'total_mfg_stock', name: 'total_mfg_stock', searchable: false });
            }

            // DataTable initialization
            var stock_report_table = $('#stock_report_table').DataTable({
                processing: true,
                serverSide: true,
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    url: '/report/stock-report',
                    data: function(d) {
                        var start = '';
                        var end = '';
                        if ($('#stock_report_date_range').val()) {
                            start = $('#stock_report_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                            end = $('#stock_report_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                        }
                        d.location_id = $('#location_id').val();
                        d.category_id = $('#category_id').val();
                        d.sub_category_id = $('#sub_category_id').val();
                        d.brand_id = $('#brand').val();
                        d.unit_id = $('#unit').val();
                        d.start_date = start;
                        d.end_date = end;
                        d.only_mfg_products = $('#only_mfg_products').length && $('#only_mfg_products').is(':checked') ? 1 : 0;
                    }
                },
                columns: stock_report_cols,
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#stock_report_table'));
                },
                footerCallback: function(row, data, start, end, display) {
                    var footer_total_stock = 0;
                    var footer_total_sold = 0;
                    var footer_total_transfered = 0;
                    var total_adjusted = 0;
                    var total_stock_price = 0;
                    var footer_stock_value_by_sale_price = 0;
                    var total_potential_profit = 0;
                    var footer_total_mfg_stock = 0;
                    for (var r in data) {
                        footer_total_stock += $(data[r].stock).data('orig-value') ? parseFloat($(data[r].stock).data('orig-value')) : 0;
                        footer_total_sold += $(data[r].total_sold).data('orig-value') ? parseFloat($(data[r].total_sold).data('orig-value')) : 0;
                        footer_total_transfered += $(data[r].total_transfered).data('orig-value') ? parseFloat($(data[r].total_transfered).data('orig-value')) : 0;
                        total_adjusted += $(data[r].total_adjusted).data('orig-value') ? parseFloat($(data[r].total_adjusted).data('orig-value')) : 0;
                        total_stock_price += $(data[r].stock_price).data('orig-value') ? parseFloat($(data[r].stock_price).data('orig-value')) : 0;
                        footer_stock_value_by_sale_price += $(data[r].stock_value_by_sale_price).data('orig-value') ? parseFloat($(data[r].stock_value_by_sale_price).data('orig-value')) : 0;
                        total_potential_profit += $(data[r].potential_profit).data('orig-value') ? parseFloat($(data[r].potential_profit).data('orig-value')) : 0;
                        footer_total_mfg_stock += $(data[r].total_mfg_stock).data('orig-value') ? parseFloat($(data[r].total_mfg_stock).data('orig-value')) : 0;
                    }
                    $('.footer_total_stock').html(__currency_trans_from_en(footer_total_stock, false));
                    $('.footer_total_stock_price').html(__currency_trans_from_en(total_stock_price));
                    $('.footer_total_sold').html(__currency_trans_from_en(footer_total_sold, false));
                    $('.footer_total_transfered').html(__currency_trans_from_en(footer_total_transfered, false));
                    $('.footer_total_adjusted').html(__currency_trans_from_en(total_adjusted, false));
                    $('.footer_stock_value_by_sale_price').html(__currency_trans_from_en(footer_stock_value_by_sale_price));
                    $('.footer_potential_profit').html(__currency_trans_from_en(total_potential_profit));
                    if ($('th.current_stock_mfg').length) {
                        $('.footer_total_mfg_stock').html(__currency_trans_from_en(footer_total_mfg_stock, false));
                    }
                }
            });

            // Event handlers for filter form elements
            $('#stock_report_filter_form').on('change', '#location_id, #category_id, #sub_category_id, #brand, #unit, #view_stock_filter, #start_date, #end_date', function() {
                stock_report_table.ajax.reload();
                get_stock_value(); // Update stock values when filters change
            });

            // Event handler for 'only_mfg_products' checkbox
            $('#only_mfg_products').on('change', function() {
                stock_report_table.ajax.reload();
            });

            // Initial call to retrieve stock values
            get_stock_value();
        });

        function get_stock_value() {
            var loader = __fa_awesome(); // Function to get loader icon or text

            // Display loader while fetching data
            $('#closing_stock_by_pp').html(loader);
            $('#closing_stock_by_sp').html(loader);
            $('#potential_profit').html(loader);
            $('#profit_margin').html(loader);

            // Retrieve start and end dates from date range picker
            var start = '';
            var end = '';
            if ($('#stock_report_date_range').val()) {
                start = $('#stock_report_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                end = $('#stock_report_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }

            // Prepare data object with filters and date range
            var data = {
                location_id: $('#location_id').val(),
                category_id: $('#category_id').val(),
                sub_category_id: $('#sub_category_id').val(),
                brand_id: $('#brand').val(),
                unit_id: $('#unit').val(),
                started_date: start,
                ended_date: end
            };

            // Make AJAX request to fetch stock values
            $.ajax({
                url: '/report/get-stock-value',
                data: data,
                success: function(data) {
                    $('#closing_stock_by_pp').text(__currency_trans_from_en(data.closing_stock_by_pp));
                    $('#closing_stock_by_sp').text(__currency_trans_from_en(data.closing_stock_by_sp));
                    $('#potential_profit').text(__currency_trans_from_en(data.potential_profit));
                    $('#profit_margin').text(__currency_trans_from_en(data.profit_margin, false));
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching stock values:', error);
                    // Handle error scenario if needed
                }
            });
        }
    </script>
@endsection
