@extends('layouts.app')

@section('title', __('lang_v1.shipments'))

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>Delivery Report</h1>
    </section>

    <!-- Main content -->
    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('sell_list_filter_location_id', __('purchase.business_location') . ':') !!}
                    {!! Form::select('sell_list_filter_location_id', $business_locations, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('sell_list_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('sell_list_filter_date_range', null, [
                        'placeholder' => __('lang_v1.select_a_date_range'),
                        'class' => 'form-control',
                        'readonly',
                    ]) !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('shipping_status', __('lang_v1.shipping_status') . ':') !!}
                    {!! Form::select('shipping_status', $shipping_statuses, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>
        @endcomponent

        <div class="box-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Total Status</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2"><strong>Ordered:</strong> <span id="ordered_count">0</span></div>
                                <div class="col-md-2"><strong>Packed:</strong> <span id="packed_count">0</span></div>
                                <div class="col-md-2"><strong>Shipped:</strong> <span id="shipped_count">0</span></div>
                                <div class="col-md-2"><strong>Delivered:</strong> <span id="delivered_count">0</span></div>
                                <div class="col-md-2"><strong>Cancelled:</strong> <span id="cancelled_count">0</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @component('components.widget', ['class' => 'box-warning'])
            <div class="box-header with-border text-center">
                <h2 class="box-title">Delivery Report</h2>
            </div>
            <table class="table table-bordered table-striped" id="sell_table">
                <thead>
                    <tr>
                        <th>@lang('messages.date')</th>
                        <th>@lang('sale.invoice_no')</th>
                        <th>@lang('sale.customer_name')</th>
                        <th>@lang('lang_v1.contact_no')</th>
                        <th>@lang('sale.location')</th>
                        <th>@lang('lang_v1.delivery_person')</th>
                        <th>@lang('lang_v1.shipping_status')</th>
                    </tr>
                </thead>

            </table>
        @endcomponent
    </section>
    <!-- /.content -->

    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

@stop

@section('javascript')
    <script type="text/javascript">
        function updateStatusCounts() {
            var start_date = moment($('#sell_list_filter_date_range').data('daterangepicker').startDate).format('YYYY-MM-DD');
            var end_date = moment($('#sell_list_filter_date_range').data('daterangepicker').endDate).format('YYYY-MM-DD');
            var location_id = $('#sell_list_filter_location_id').val();
            var shipping_status = $('#shipping_status').val();

            $.ajax({
                url: "{{ route('shipment_counts') }}",
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    location_id: location_id,
                    shipping_status: shipping_status
                },
                success: function(response) {
                    console.log(response); // Log the response to the console
                    $('#ordered_count').text(response.ordered);
                    $('#packed_count').text(response.packed);
                    $('#shipped_count').text(response.shipped);
                    $('#delivered_count').text(response.delivered);
                    $('#cancelled_count').text(response.cancelled);
                }
            });
        }

        $(document).ready(function() {
            var today = moment();

            $('#sell_list_filter_date_range').daterangepicker({
                startDate: today,
                endDate: today,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                        .endOf('year')
                    ]
                }
            }, function(start, end) {
                $('#sell_list_filter_date_range').val(start.format('YYYY-MM-DD') + ' ~ ' + end.format(
                    'YYYY-MM-DD'));
                sell_table.ajax.reload();
                updateStatusCounts();
            });

            var sell_table = $('#sell_table').DataTable({
                processing: true,
                serverSide: true,
                aaSorting: [
                    [1, 'desc']
                ],
                scrollY: "75vh",
                scrollX: true,
                scrollCollapse: true,
                ajax: {
                    url: "{{ route('delivery_report') }}",
                    data: function(d) {
                        d.start_date = moment($('#sell_list_filter_date_range').data('daterangepicker')
                            .startDate).format('YYYY-MM-DD');
                        d.end_date = moment($('#sell_list_filter_date_range').data('daterangepicker')
                            .endDate).format('YYYY-MM-DD');
                        d.location_id = $('#sell_list_filter_location_id').val();
                        d.shipping_status = $('#shipping_status').val();
                    }
                },
                columns: [{
                        data: 'transaction_date',
                        name: 'transaction_date'
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'name',
                        name: 'contact_name'
                    },
                    {
                        data: 'mobile',
                        name: 'contacts.mobile'
                    },
                    {
                        data: 'business_location',
                        name: 'bl.name'
                    },
                    {
                        data: 'delivery_person',
                        name: 'delivery_person'
                    },
                    {
                        data: 'shipping_status',
                        name: 'shipping_status'
                    }
                ],
                fnDrawCallback: function(oSettings) {
                    updateStatusCounts();
                },
                createdRow: function(row, data, dataIndex) {
                    $(row).find('td:eq(4)').addClass('clickable_td');
                }
            });

            $('#sell_list_filter_location_id, #shipping_status').change(function() {
                sell_table.ajax.reload();
                updateStatusCounts();
            });

            updateStatusCounts();
        });
    </script>
@stop
