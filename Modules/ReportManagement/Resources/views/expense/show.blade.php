@extends('layouts.app')

@section('title', __('accounting::lang.account_expense_header'))

@section('content')

    @include('accounting::layouts.nav')

    <section class="content-header">
        <h1>@lang('accounting::lang.print_form')</h1>
    </section>

    <section class="content no-print">

        @component('components.widget', ['class' => 'box-warning'])
            <div class="box-header with-border text-center">
                <h2 class="box-title">@lang('accounting::lang.account_expense_header')</h2>
            </div>
            <table class="table table-bordered table-striped ajax_view text-center" id="sell_table">
                <thead class="text-center">
                    <tr>
                        <th> លរ </th>
                        <th> ថ្ងៃខែទិញ </th>
                        <th> ឈ្មោះអ្នកលក់ ផ្គត់ផ្គង់សេវា </th>
                        <th> លេខវិក័យបត្រ </th>
                        <th> ប្រភពចំណាយ </th>
                        <th> ទឹកប្រាក់ដុល្លារ </th>
                        <th> ទឹកប្រាក់រៀល </th>
                        <th> អតបធាតុចូល </th>
                        <th> ពន្ធកាត់ទុក </th>
                        <th> អត្រាប្តូរប្រាក់ </th>
                    </tr>

                    <tr class="text-center">
                        <th>@lang('lang_v1.id')</th>
                        <th>@lang('lang_v1.invoice_date')</th>
                        <th>@lang('lang_v1.supplier_name')</th>
                        <th>@lang('lang_v1.invoice_no')</th>
                        <th>@lang('lang_v1.expense_type')</th>
                        <th>@lang('lang_v1.amount_dollar')</th>
                        <th>@lang('lang_v1.amount_riel')</th>
                        <th>@lang('lang_v1.vat_inputs')</th>
                        <th>@lang('lang_v1.wht_tax')</th>
                        <th>@lang('lang_v1.rate')</th>
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
                    url: '{{ action([\Modules\Accounting\Http\Controllers\AccountExpenseController::class, 'index']) }}',
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
