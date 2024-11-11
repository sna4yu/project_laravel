@extends('layouts.app')

@section('title', __('accounting::lang.account_receivable_ageing_details'))

@section('css')
    {{-- <style>
        .content {
            background-color: #f4f5f7;
            padding: 20px;
            border-radius: 5px;
        }

        .box {
            background-color: #F4F5F8;
        }

        .box-header {
            padding: 15px;
            color: white;
            border-bottom: none;
            text-align: center;
        }

        .box-title {
            font-size: 24px;
            font-weight: bold;
        }

        .table {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-bordered th,
        .table-bordered td {
            text-align: center;
        }

        /* .form-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: space-between;
        }

        .form-inline .form-group {
            display: flex;
            flex-direction: column;
            font-size: 12px;
            color: #333;
        } */

        .btn {
            font-size: 14px;
            border-radius: 20px;
            padding: 5px 15px;
        }

        .btn-outline-secondary {
            border-color: gray;
        }

        .btn-success {
            background-color: #2ca01c;
        }

        /* Sticky table headers */
        .table-sticky thead,
        .table-sticky tfoot {
            position: sticky;
        }

        .table-sticky thead {
            inset-block-start: 0;
        }

        .table-sticky tfoot {
            inset-block-end: 0;
        }

        /* Dropdown style */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 220px;
            border: 1px solid #ddd;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            padding: 10px;
        }

        .collapsed .collapse-tr {
            display: none;
        }
    </style> --}}
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="box box-default">
            <div class="box box-default" style="background-color: #356bd7;">
                <div class="box-body" style="background-color: #F4F5F8;">
                    <!-- Back to report list link -->
                    <a href="http://127.0.0.1:8000/test/report_management" class="btn btn-link"
                        style="display: inline-flex; align-items: center; text-decoration: none; color: #007bff; font-size: 14px; margin-bottom: 15px;">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
                            <path fill-rule="evenodd"
                                d="M10.354 3.646a.5.5 0 0 1 0 .708L6.707 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0z" />
                        </svg>
                        @lang('Back to report list')
                    </a>

                    <!-- Title -->
                    <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 20px;">A/R Ageing
                        Detail Report</h3>

                    <!-- Form elements -->
                    <form class="form-inline"
                        style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between;">
                        <!-- Top Row -->
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div class="form-group">
                                {!! Form::label('report_period', __('Report period'), [
                                    'style' => 'display: block; font-size: 12px; color: #333;',
                                ]) !!}
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
                                    ['class' => 'form-control', 'style' => 'font-size: 12px;'],
                                ) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('as_of', __('As of'), ['style' => 'display: block; font-size: 12px; color: #333;']) !!}
                                {!! Form::date('as_of', \Carbon\Carbon::now()->format('Y-m-d'), [
                                    'class' => 'form-control',
                                    'style' => 'width: 130px; font-size: 12px;',
                                ]) !!}
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
                            <div class="form-group" style="margin-right: 15px; position: relative;">
                                {!! Form::label('show_rows', __('Show non-zero or active only'), [
                                    'style' => 'display: block; font-size: 12px; color: #333;',
                                ]) !!}
                                <div class="dropdown" style="position: relative;">
                                    <select class="form-control" id="dropdownMenuButton"
                                        style="font-size: 12px; width: 220px; cursor: pointer;" aria-haspopup="true"
                                        aria-expanded="false">
                                        <option>Active rows/active columns</option>
                                    </select>

                                    <!-- Custom dropdown content -->
                                    <div class="dropdown-content" id="customDropdownContent"
                                        style="padding: 10px; font-size: 12px; display: none; position: absolute; top: 100%; left: 0; width: 220px; border: 1px solid #ddd; border-radius: 4px; background-color: #fff; z-index: 1000;">
                                        <div>
                                            <strong style="font-size: 12px;">Show rows</strong><br>
                                            <label style="font-size: 12px;"><input type="radio" name="show_rows"
                                                    value="active" checked> Active</label><br>
                                            <label style="font-size: 12px;"><input type="radio" name="show_rows"
                                                    value="all"> All</label><br>
                                            <label style="font-size: 12px;"><input type="radio" name="show_rows"
                                                    value="non_zero"> Non-zero</label>
                                        </div>
                                        <hr style="margin: 10px 0;">
                                        <div>
                                            <strong style="font-size: 12px;">Show columns</strong><br>
                                            <label style="font-size: 12px;"><input type="radio" name="show_columns"
                                                    value="active" checked> Active</label><br>
                                            <label style="font-size: 12px;"><input type="radio" name="show_columns"
                                                    value="all"> All</label><br>
                                            <label style="font-size: 12px;"><input type="radio" name="show_columns"
                                                    value="non_zero"> Non-zero</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ageing Method -->
                            <div class="form-group" style="margin-right: 15px;">
                                {!! Form::label('ageing_method', __('Ageing method'), [
                                    'style' => 'display: block; font-size: 12px; color: #333;',
                                ]) !!}
                                <div class="radio" style="display: inline-block; margin-right: 10px;">
                                    {!! Form::radio('ageing_method', 'current', false, ['id' => 'current', 'style' => 'accent-color: green;']) !!}
                                    {!! Form::label('current', __('Current'), ['style' => 'font-size: 12px; color: #333;']) !!}
                                </div>

                                <!-- Radio Button with Green Color -->
                                <div class="radio" style="display: inline-block;">
                                    {!! Form::radio('ageing_method', 'report_date', true, [
                                        'id' => 'report_date',
                                        'style' => 'accent-color: green;',
                                    ]) !!}
                                    {!! Form::label('report_date', __('Report date'), ['style' => 'font-size: 12px; color: #333;']) !!}
                                </div>

                            </div>

                            <div class="form-group" style="margin-right: 15px;">
                                {!! Form::label('days_per_period', __('Days per ageing period'), [
                                    'style' => 'display: block; font-size: 12px; color: #333;',
                                ]) !!}
                                {!! Form::text('days_per_period', '30', ['class' => 'form-control', 'style' => 'width: 60px; font-size: 12px;']) !!}
                            </div>

                            <div class="form-group" style="margin-right: 15px;">
                                {!! Form::label('number_of_periods', __('Number of periods'), [
                                    'style' => 'display: block; font-size: 12px; color: #333;',
                                ]) !!}
                                {!! Form::text('number_of_periods', '4', [
                                    'class' => 'form-control',
                                    'style' => 'width: 50px; font-size: 12px;',
                                ]) !!}
                            </div>

                            <!-- Run report Button -->
                            <div class="form-group" style="margin-top: 10px;">
                                <button type="button" class="btn btn-default"
                                    style="font-size: 14px; border-radius: 20px; padding: 5px 15px; border-color: gray; border-width: 1px;">@lang('Run report')</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-default">
                        <div class="box-header with-border text-center">
                            <h4 class="box-title" style="font-size: 24px;">{{ Session::get('business.name') }}</h4><br><br>
                            <h5 class="box-title"><b>A/R Ageing Detail</b></h5>
                            <p>{{ 'As of ' . \Carbon\Carbon::now()->format('F j, Y') }}</p>
                        </div>
                        <div class="box-body">
                            <table class="table table-stripped table-bordered table-sticky">
                                <thead>
                                    <tr>
                                        <th>@lang('messages.date')</th>
                                        <th>@lang('account.transaction_type')</th>
                                        <th>@lang('sale.invoice_no')</th>
                                        <th>@lang('contact.customer')</th>
                                        <th>@lang('lang_v1.due_date')</th>
                                        <th>@lang('lang_v1.due')</th>
                                    </tr>
                                </thead>
                                @foreach ($report_details as $key => $value)
                                    <tbody @if ($loop->index != 0) class="collapsed" @endif>
                                        <tr class="toggle-tr" style="cursor: pointer;">
                                            <th colspan="6">
                                                <span class="collapse-icon">
                                                    <i class="fas fa-arrow-circle-right"></i>
                                                </span>
                                                @if ($key == 'current')
                                                    <span>
                                                        @lang('accounting::lang.current') </span>
                                                @elseif($key == '1_30')
                                                    <span>
                                                        @lang('accounting::lang.days_past_due', ['days' => '1 - 30'])
                                                    </span>
                                                @elseif($key == '31_60')
                                                    <span>
                                                        @lang('accounting::lang.days_past_due', ['days' => '31 - 60'])
                                                    </span>
                                                @elseif($key == '61_90')
                                                    <span>
                                                        @lang('accounting::lang.days_past_due', ['days' => '61 - 90'])
                                                    </span>
                                                @elseif($key == '>90')
                                                    <span>
                                                        @lang('accounting::lang.91_and_over_past_due')
                                                    </span>
                                                @endif
                                            </th>
                                        </tr>
                                        @php $total=0; @endphp
                                        @foreach ($value as $details)
                                            @php $total += $details['due']; @endphp
                                            <tr class="collapse-tr">
                                                <td>{{ $details['transaction_date'] }}</td>
                                                <td>@lang('accounting::lang.invoice')</td>
                                                <td>{{ $details['invoice_no'] }}</td>
                                                <td>{{ $details['contact_name'] }}</td>
                                                <td>{{ $details['due_date'] }}</td>
                                                <td>@format_currency($details['due'])</td>
                                            </tr>
                                        @endforeach
                                        <tr class="collapse-tr bg-gray">
                                            <th>
                                                @if ($key == 'current')
                                                    @lang('accounting::lang.total_for_current')
                                                @elseif($key == '1_30')
                                                    @lang('accounting::lang.total_for_days_past_due', ['days' => '1 - 30'])
                                                @elseif($key == '31_60')
                                                    @lang('accounting::lang.total_for_days_past_due', ['days' => '31 - 60'])
                                                @elseif($key == '61_90')
                                                    @lang('accounting::lang.total_for_days_past_due', ['days' => '61 - 90'])
                                                @elseif($key == '>90')
                                                    @lang('accounting::lang.total_for_91_and_over')
                                                @endif
                                            </th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>@format_currency($total)</th>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div style="text-align: center; color: gray;">
                        {{ \Carbon\Carbon::now()->format('l, F j, Y g:i A T') }}
                    </div>
                </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#location_id').change(function() {
                if ($(this).val()) {
                    window.location.href =
                        "{{ route('accounting.account_receivable_ageing_details') }}?location_id=" + $(this)
                        .val();
                } else {
                    window.location.href = "{{ route('accounting.account_receivable_ageing_details') }}";
                }
            });

            $(document).on('click', '.toggle-tr', function() {
                $(this).closest('tbody').toggleClass('collapsed');
                var html = $(this).closest('tbody').hasClass('collapsed') ?
                    '<i class="fas fa-arrow-circle-right"></i>' :
                    '<i class="fas fa-arrow-circle-down"></i>';
                $(this).find('.collapse-icon').html(html);
            });
        });
    </script>
@stop
