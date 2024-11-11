@extends('layouts.app')
@section('title', __('lang_v1.cash_flow'))

@section('content')

    <section class="content" style="background-color: #ffffff;">
        <div class="row" style="padding: 20px; background-color: #ffffff;">
            <div class="box-body" style="background-color: #F4F5F8;">
                <!-- Back to report list link -->
                <a href="http://127.0.0.1:8000/AccountingQuickbooks/resource/view" class="btn btn-link"
                    style="display: inline-flex; align-items: center; text-decoration: none; color: #007bff; font-size: 12px; margin-bottom: 15px;">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
                        <path fill-rule="evenodd"
                            d="M10.354 3.646a.5.5 0 0 1 0 .708L6.707 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0z" />
                    </svg>
                    @lang('Back to report list')
                </a>

                <!-- Title -->

                <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 12px;">Statement of Cash
                    Flows Report</h3>
                <h3 style="font-size: 12px; margin-bottom: 20px; padding-left: 12px;">Report period</h3>
                <!-- Form elements -->
                <form class="form-inline"
                    style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between;">

                    <!-- Top Row -->
                    <div style="display: flex; gap: 15px; align-items: center;">
                        <!-- Report Period -->
                        <div class="form-group">
                            {!! Form::text('transaction_date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'readonly',
                                'id' => 'transaction_date_range',
                                'style' => 'border-radius: 10px; border: 1px solid #ccd1d9; padding: 8px 12px; background-color: #ffffff;',
                            ]) !!}
                            {{-- {!! Form::select(
                            'report_period',
                            [
                                'Today' => 'Today',
                                'All Dates' => 'All Dates',
                                'Custom' => 'Custom',
                                'This Week' => 'This Week',
                                'This Week-to-date' => 'This Week-to-date',
                                'This Month' => 'This Month',
                                'This Month-to-date' => 'This Month-to-date',
                                'Quarter' => 'Quarter',
                                'Quarter-to-date' => 'Quarter-to-date',
                                'Year' => 'Year',
                                'Year-to-date' => 'Year-to-date',
                                'Year-to-last-month' => 'Year-to-last-month',
                                'Yesterday' => 'Yesterday',
                                'Recent' => 'Recent',
                                'Last Week' => 'Last Week',
                                'Last Week-to-date' => 'Last Week-to-date',
                                'Last Month' => 'Last Month',
                                'Last Month-to-date' => 'Last Month-to-date',
                                'Last Quarter' => 'Last Quarter',
                                'Last Quarter-to-date' => 'Last Quarter-to-date',
                                'Last Year' => 'Last Year',
                                'Last Year-to-date' => 'Last Year-to-date',
                                'Since 30 Days Ago' => 'Since 30 Days Ago',
                                'Since 60 Days Ago' => 'Since 60 Days Ago',
                                'Since 90 Days Ago' => 'Since 90 Days Ago',
                                'Since 365 Days Ago' => 'Since 365 Days Ago',
                                'Next Week' => 'Next Week',
                                'Next 4 Weeks' => 'Next 4 Weeks',
                                'Next Month' => 'Next Month',
                                'Next Quarter' => 'Next Quarter',
                                'Next Year' => 'Next Year',
                            ],
                            null,
                            ['class' => 'form-control', 'style' => 'font-size: 12px; width: 160px;'],
                        ) !!} --}}
                        </div>

                        {{-- <div class="form-group">
                           
                            {!! Form::select(
                                'report_period',
                                [
                                    'Today' => 'Today',
                                    'All Dates' => 'All Dates',
                                    'Custom' => 'Custom',
                                    'This Week' => 'This Week',
                                    'This Week-to-date' => 'This Week-to-date',
                                    'This Month' => 'This Month',
                                    'This Month-to-date' => 'This Month-to-date',
                                    'Quarter' => 'Quarter',
                                    'Quarter-to-date' => 'Quarter-to-date',
                                    'Year' => 'Year',
                                    'Year-to-date' => 'Year-to-date',
                                    'Year-to-last-month' => 'Year-to-last-month',
                                    'Yesterday' => 'Yesterday',
                                    'Recent' => 'Recent',
                                    'Last Week' => 'Last Week',
                                    'Last Week-to-date' => 'Last Week-to-date',
                                    'Last Month' => 'Last Month',
                                    'Last Month-to-date' => 'Last Month-to-date',
                                    'Last Quarter' => 'Last Quarter',
                                    'Last Quarter-to-date' => 'Last Quarter-to-date',
                                    'Last Year' => 'Last Year',
                                    'Last Year-to-date' => 'Last Year-to-date',
                                    'Since 30 Days Ago' => 'Since 30 Days Ago',
                                    'Since 60 Days Ago' => 'Since 60 Days Ago',
                                    'Since 90 Days Ago' => 'Since 90 Days Ago',
                                    'Since 365 Days Ago' => 'Since 365 Days Ago',
                                    'Next Week' => 'Next Week',
                                    'Next 4 Weeks' => 'Next 4 Weeks',
                                    'Next Month' => 'Next Month',
                                    'Next Quarter' => 'Next Quarter',
                                    'Next Year' => 'Next Year',
                                ],
                                null,
                                ['class' => 'form-control', 'style' => 'font-size: 12px; width: 160px;'],
                            ) !!}
                        </div> --}}

                        <!-- As of Date Fields in a Row -->
                        <div class="form-group" style="display: flex; gap: 10px;">
                            <div>

                                {!! Form::date('as_of', \Carbon\Carbon::now()->format('Y-m-d'), [
                                    'class' => 'form-control',
                                    'style' => 'width: 130px; font-size: 12px;',
                                ]) !!}
                            </div>
                            <div>
                                {!! Form::label('as_of', __('To'), ['style' => 'display: block; font-size: 12px; color: #333;']) !!}

                            </div>
                            <div>

                                {!! Form::date('as_of_2', \Carbon\Carbon::now()->format('Y-m-d'), [
                                    'class' => 'form-control',
                                    'style' => 'width: 130px; font-size: 12px;',
                                ]) !!}
                            </div>
                        </div>

                    </div>

                    <!-- Top Right Buttons -->
                    <div class="form-group" style="margin-left: auto;">
                        <button type="button" class="btn btn-outline-secondary"
                            style="font-size: 14px; border-radius: 20px; padding: 5px 15px; border-color: gray;">@lang('Customise')</button>
                        <button type="button" class="btn btn-success"
                            style="font-size: 14px; border-radius: 20px; padding: 5px 15px; background-color: #2ca01c;">@lang('Save customisation')</button>
                    </div>


                    <!-- Bottom Row -->
                    <div
                        style="display: flex; flex-wrap: wrap; gap: 15px; width: 100%; align-items: center; margin-top: 10px;">
                        <!-- Display Columns By -->
                        <div class="form-group">
                            {!! Form::label('display_columns', __('Display columns by'), [
                                'style' => 'display: block; font-size: 12px; color: #333;',
                            ]) !!}
                            {!! Form::select(
                                'display_columns',
                                [
                                    'Total Only' => 'Total Only',
                                    'Days' => 'Days',
                                    'Weeks' => 'Weeks',
                                    'Months' => 'Months',
                                    'Quarters' => 'Quarters',
                                    'Years' => 'Years',
                                    'Customers' => 'Customers',
                                    'Suppliers' => 'Suppliers',
                                    'Classes' => 'Classes',
                                    'Products/Services' => 'Products/Services',
                                ],
                                null,
                                [
                                    'class' => 'form-control',
                                    'style' => 'font-size: 12px; width: 160px; border-radius: 4px;',
                                ],
                            ) !!}
                        </div>

                       <!-- Show Non-Zero or Active Only -->
<div class="form-group">
    {!! Form::label('show_rows', __('Show non-zero or active only'), [
        'style' => 'display: block; font-size: 12px; color: #333;',
    ]) !!}
    <div class="dropdown" style="position: relative;">
        <button class="form-control" id="dropdownMenuButton" style="font-size: 12px; width: 220px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;" aria-haspopup="true" aria-expanded="false">
            Active rows/active columns
            <span style="font-size: 10px;">&#9662;</span> <!-- Down Arrow -->
        </button>

        <!-- Custom dropdown content -->
        <div class="dropdown-content" id="customDropdownContent" style="padding: 10px; font-size: 12px; display: none; position: absolute; top: 100%; left: 0; width: 220px; border: 1px solid #ddd; border-radius: 4px; background-color: #fff; z-index: 1000;">
            <div>
                <strong style="font-size: 12px;">Show rows</strong><br>
                <label style="font-size: 12px;"><input type="radio" name="show_rows" value="active" checked> Active</label><br>
                <label style="font-size: 12px;"><input type="radio" name="show_rows" value="all"> All</label><br>
                <label style="font-size: 12px;"><input type="radio" name="show_rows" value="non_zero"> Non-zero</label>
            </div>
            <hr style="margin: 10px 0;">
            <div>
                <strong style="font-size: 12px;">Show columns</strong><br>
                <label style="font-size: 12px;"><input type="radio" name="show_columns" value="active" checked> Active</label><br>
                <label style="font-size: 12px;"><input type="radio" name="show_columns" value="all"> All</label><br>
                <label style="font-size: 12px;"><input type="radio" name="show_columns" value="non_zero"> Non-zero</label>
            </div>
        </div>
    </div>
</div>

                        {{-- <!-- Days per Ageing Period -->
    <div class="form-group" style="margin-right: 15px;">
        {!! Form::label('days_per_period', __('Days per ageing period'), [
            'style' => 'display: block; font-size: 12px; color: #333;',
        ]) !!}
        {!! Form::text('days_per_period', '30', ['class' => 'form-control', 'style' => 'width: 60px; font-size: 12px;']) !!}
    </div>

    <!-- Number of Periods -->
    <div class="form-group" style="margin-right: 15px;">
        {!! Form::label('number_of_periods', __('Number of periods'), [
            'style' => 'display: block; font-size: 12px; color: #333;',
        ]) !!}
        {!! Form::text('number_of_periods', '4', [
            'class' => 'form-control',
            'style' => 'width: 50px; font-size: 12px;',
        ]) !!}
    </div> --}}

                        <!-- Run report Button -->
                        <div class="form-group" style="margin-top: 10px;">
                            <button type="button" class="btn btn-default"
                                style="font-size: 14px; border-radius: 20px; padding: 5px 15px; border-color: gray; border-width: 1px;">@lang('Run report')</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Main content -->
        <section class="content no-print">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-solid">
                        {{-- <div class="box-header">
                    <h3 class="box-title"> <i class="fa fa-filter" aria-hidden="true"></i> @lang('report.filters'):</h3>
                </div> --}}
                        <div class="box-body">
                            <div class="col-sm-4">
                                {{-- <div class="form-group">
                            {!! Form::label('account_id', __('account.account') . ':') !!}
                            {!! Form::select('account_id', $accounts, '', ['class' => 'form-control', 'placeholder' => __('messages.all')]) !!}
                        </div> --}}
                            </div>
                            <div class="col-md-4">
                                {{-- <div class="form-group">
                            {!! Form::label('cash_flow_location_id',  __('purchase.business_location') . ':') !!}
                            {!! Form::select('cash_flow_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                        </div> --}}
                            </div>
                            <div class="col-sm-4">
                                {{-- <div class="form-group">
                            {!! Form::label('transaction_date_range', __('report.date_range') . ':') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                {!! Form::text('transaction_date_range', null, ['class' => 'form-control', 'readonly', 'placeholder' => __('report.date_range')]) !!}
                            </div>
                        </div> --}}
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            @can('account.access')
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="cash_flow_table">
                                        <thead>
                                            <tr>
                                                <th>@lang('messages.date')</th>
                                                <th>@lang('account.account')</th>
                                                <th>@lang('lang_v1.description')</th>
                                                <th>@lang('lang_v1.payment_method')</th>
                                                <th>@lang('lang_v1.payment_details')</th>
                                                <th>@lang('account.debit')</th>
                                                <th>@lang('account.credit')</th>
                                                <th>@lang('lang_v1.account_balance') @show_tooltip(__('lang_v1.account_balance_tooltip'))</th>
                                                <th>@lang('lang_v1.total_balance') @show_tooltip(__('lang_v1.total_balance_tooltip'))</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="bg-gray font-17 footer-total text-center">
                                                <td colspan="5"><strong>@lang('sale.total'):</strong></td>
                                                <td class="footer_total_debit"></td>
                                                <td class="footer_total_credit"></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade account_model" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
            </div>

        </section>
        <!-- /.content -->

    @endsection

    @section('javascript')
        <script>
            $(document).ready(function() {

                // dateRangeSettings.autoUpdateInput = false
                $('#transaction_date_range').daterangepicker(
                    dateRangeSettings,
                    function(start, end) {
                        $('#transaction_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                            moment_date_format));
                        cash_flow_table.ajax.reload();
                    }
                );

                // Cash Flow Table
                cash_flow_table = $('#cash_flow_table').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": "{{ action([\App\Http\Controllers\AccountController::class, 'cashFlow']) }}",
                        "data": function(d) {
                            var start = '';
                            var end = '';
                            if ($('#transaction_date_range').val() != '') {
                                start = $('#transaction_date_range').data('daterangepicker').startDate
                                    .format('YYYY-MM-DD');
                                end = $('#transaction_date_range').data('daterangepicker').endDate.format(
                                    'YYYY-MM-DD');
                            }

                            d.account_id = $('#account_id').val();
                            d.type = $('#transaction_type').val();
                            d.start_date = start,
                                d.end_date = end
                            d.location_id = $('#cash_flow_location_id').val();

                        }
                    },
                    "ordering": false,
                    columns: [{
                            data: 'operation_date',
                            name: 'operation_date'
                        },
                        {
                            data: 'account_name',
                            name: 'A.name'
                        },
                        {
                            data: 'sub_type',
                            name: 'sub_type',
                            searchable: false
                        },
                        {
                            data: 'method',
                            name: 'TP.method'
                        },
                        {
                            data: 'payment_details',
                            name: 'TP.payment_ref_no'
                        },
                        {
                            data: 'debit',
                            name: 'amount',
                            searchable: false
                        },
                        {
                            data: 'credit',
                            name: 'amount',
                            searchable: false
                        },
                        {
                            data: 'balance',
                            name: 'balance',
                            searchable: false
                        },
                        {
                            data: 'total_balance',
                            name: 'total_balance',
                            searchable: false
                        },
                    ],
                    "fnDrawCallback": function(oSettings) {
                        __currency_convert_recursively($('#cash_flow_table'));
                    },
                    "footerCallback": function(row, data, start, end, display) {
                        var footer_total_debit = 0;
                        var footer_total_credit = 0;

                        for (var r in data) {
                            footer_total_debit += $(data[r].debit).data('orig-value') ? parseFloat($(data[r]
                                .debit).data('orig-value')) : 0;
                            footer_total_credit += $(data[r].credit).data('orig-value') ? parseFloat($(data[
                                r].credit).data('orig-value')) : 0;
                        }

                        $('.footer_total_debit').html(__currency_trans_from_en(footer_total_debit));
                        $('.footer_total_credit').html(__currency_trans_from_en(footer_total_credit));
                    }
                });
                $('#transaction_type, #account_id, #cash_flow_location_id').change(function() {
                    cash_flow_table.ajax.reload();
                });
                $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
                    $('#transaction_date_range').val('').change();
                    cash_flow_table.ajax.reload();
                });

            });

            // Toggle dropdown visibility on click
            document.getElementById('dropdownMenuButton').addEventListener('click', function() {
                var dropdownContent = document.getElementById('customDropdownContent');
                if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
                    dropdownContent.style.display = 'block';
                } else {
                    dropdownContent.style.display = 'none';
                }
            });

            // Hide dropdown when clicking outside of it
            window.onclick = function(event) {
                if (!event.target.matches('#dropdownMenuButton')) {
                    var dropdownContent = document.getElementById('customDropdownContent');
                    if (dropdownContent.style.display === 'block') {
                        dropdownContent.style.display = 'none';
                    }
                }
            }
        </script>
    @endsection
<!-- CSS for green radio buttons and custom styles -->
<style>
    /* Green radio button styles */
    input[type="radio"] {
        appearance: none;
        width: 16px;
        height: 16px;
        border: 2px solid #333;
        border-radius: 50%;
        outline: none;
        cursor: pointer;
        position: relative;
    }

    input[type="radio"]:checked::before {
        width: 10px;
        height: 10px;
        background-color: green; /* Green color for checked radio */
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Custom dropdown arrow and layout */
    #dropdownMenuButton::after {
        content: '\25BC'; /* Down arrow character */
        font-size: 10px;
        margin-left: 10px;
    }

    /* Dropdown visibility toggle */
    .dropdown-content {
        display: none;
    }

    .dropdown-content.show {
        display: block;
    }
</style>