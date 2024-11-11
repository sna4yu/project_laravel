@extends('layouts.app')

@section('title', __('reportmanagement::lang.account_expense'))

@section('content')
@include('reportmanagement::Layouts.navbar')
    {{-- @include('accounting::layouts.nav') --}}

    <section class="content-header">
        <h1>Expense Report</h1>
    </section>

    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('location_id', __('Business Locations') . ':') !!}
                    {!! Form::select('location_id', $business_locations, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('transaction_date_range', __('report.date_range') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        {!! Form::text('transaction_date_range', null, [
                            'class' => 'form-control',
                            'readonly',
                            'placeholder' => __('report.date_range'),
                        ]) !!}
                    </div>
                </div>
            </div>
            @if (!empty($sources))
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sell_list_filter_source', __('lang_v1.sources') . ':') !!}
                        {!! Form::select('sell_list_filter_source', $sources, null, [
                            'class' => 'form-control select2',
                            'style' => 'width:100%',
                            'placeholder' => __('lang_v1.all'),
                        ]) !!}
                    </div>
                </div>
            @endif
        @endcomponent

        @component('components.widget', ['class' => 'box-warning'])
            <div class="box-header with-border text-center">
                <h2 class="box-title">Expense Report</h2>
            </div>
            <table class="table table-bordered table-striped ajax_view" id="sell_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Invoice Date</th>
                        <th>Supplier Name</th>
                        <th>Invoice No</th>
                        <th>Type</th>
                        <th>Amount ($)</th>
                        <th>Amount (R)</th>
                        <th>VAT Inputs 10%</th>
                        <th>WHT Tax 10%</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="bg-gray font-17 footer-total text-center">
                        <td colspan="5"><strong>@lang('sale.total'):</strong></td>
                        <td class="footer_total_debit"></td>
                        {{-- <td class="footer_total_debit"></td> --}}
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
            </table>
        @endcomponent
    </section>
@stop

@section('javascript')
    <script type="text/javascript">
        $('#transaction_date_range').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#transaction_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                    moment_date_format));

                sell_table.ajax.reload();
            }
        );
        $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#transaction_date_range').val('');
            sell_table.ajax.reload();
        });

        $(document).ready(function() {
            sell_table = $('#sell_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: '{{ action([\Modules\ReportManagement\Http\Controllers\AccountExpenseController::class, 'index']) }}',
                    data: function(d) {
                        var start = '';
                        var end = '';
                        if ($('#transaction_date_range').val()) {
                            start = $('input#transaction_date_range').data('daterangepicker').startDate
                                .format('YYYY-MM-DD');
                            end = $('input#transaction_date_range').data('daterangepicker').endDate
                                .format('YYYY-MM-DD');
                        }
                        var transaction_type = $('select#transaction_type').val();
                        d.start_date = start;
                        d.end_date = end;
                        d.type = transaction_type;
                        d.location_id = $('select#location_id').val();
                    }
                },
                "ordering": false,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {   
                        data: 'transaction_date',
                        name: 'transaction_date',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'sbm',
                        name: 'sbm',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'invoice_no',
                        name: 'invoice_no'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'final_total', 
                        name: 'final_total',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            }).format(data);
                        }
                    },
                    {
                        data: 'final_total', 
                        name: 'final_total',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            }).format(data);
                        }
                    },
                    {
                        data: 'final_total', 
                        name: 'final_total',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            }).format(data);
                        }
                    },
                    {
                        data: 'final_total', 
                        name: 'final_total',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            }).format(data);
                        }
                    },
                    {
                        data: 'final_total', 
                        name: 'final_total',
                        render: function(data, type, row) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD'
                            }).format(data);
                        }
                    },

                ],
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api();

                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    var total = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    $(api.column(5).footer()).html(
                        new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        }).format(total)
                    );
                }
            });
            
            $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#transaction_date_range').val('');
                sell_table.ajax.reload();
            });

            $('select#location_id').on(
                'change',
                function() {
                    sell_table.ajax.reload();
                }
            );
        });
    </script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection
