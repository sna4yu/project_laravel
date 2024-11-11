@extends('layouts.app')

@section('title', __('Profit and Loss Comparison'))

@section('content')

<section class="content" style="background-color: #ffffff;">
    <div class="row" style="padding: 20px; background-color: #ffffff;">
        <div class="box-body" style="background-color: #F4F5F8;">
            <!-- Back to report list link -->
            <a href="http://127.0.0.1:8000/AccountingQuickbooks/resource/view" class="btn btn-link"
                style="display: inline-flex; align-items: center; text-decoration: none; color: #007bff; font-size: 14px; margin-bottom: 15px;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
                    <path fill-rule="evenodd"
                        d="M10.354 3.646a.5.5 0 0 1 0 .708L6.707 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0z" />
                </svg>
                @lang('Back to report list')
            </a>

            <!-- Title -->
            <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 12px;">Profit and Loss Comparison Report</h3>
            <h3 style="font-size: 12px; margin-bottom: 20px; padding-left: 12px;">Report period</h3>

            <!-- Form elements -->
            <form class="form-inline"
                style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between;">
                <!-- Top Row -->
                <div style="display: flex; gap: 15px; align-items: center;">
                    <!-- Report Period -->
                    <div class="form-group">
                        {!! Form::text('date_range_filter', null, [
                            'placeholder' => __('lang_v1.select_a_date_range'),
                            'class' => 'form-control',
                            'readonly',
                            'id' => 'date_range_filter',
                            'style' => 'border-radius: 10px; border: 1px solid #ccd1d9; padding: 8px 12px; background-color: #ffffff;',
                        ]) !!}
                    </div>

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

                        <!-- Compare another period -->
                        <div class="form-group">
                            {!! Form::label('show_rows', __('Compare another period'), [
                                'style' => 'display: block; font-size: 12px; color: #333;',
                            ]) !!}
                            <div class="dropdown" style="position: relative;">
                                <!-- Main dropdown button -->
                                <button class="form-control" id="dropdownMenuButton"
                                    style="font-size: 12px; width: 220px; cursor: pointer; text-align: left;"
                                    aria-haspopup="true" aria-expanded="false">
                                    Select per
                                </button>

                                <!-- Custom dropdown content -->
                                <div class="dropdown-content" id="customDropdownContent"
                                    style="padding: 10px; font-size: 12px; display: none; position: absolute; top: 100%; left: 0; width: 220px; border: 1px solid #ddd; border-radius: 4px; background-color: #fff; z-index: 1000;">
                                    <div style="padding: 5px 10px;">
                                        <!-- Options for Previous Period -->
                                        <label style="font-size: 12px; display: flex; align-items: center;"><input
                                                type="checkbox" name="compare_options" value="previous_period" checked
                                                style="margin-right: 5px;"> Previous period (PP)</label>
                                        <div style="margin-left: 20px;">
                                            <label style="font-size: 12px; display: inline-block;"><input
                                                    type="checkbox" name="pp_change" value="dollar_change"
                                                    style="margin-right: 5px;"> $ change</label>
                                            <label
                                                style="font-size: 12px; display: inline-block; margin-left: 20px;"><input
                                                    type="checkbox" name="pp_change" value="percent_change"
                                                    style="margin-right: 5px;"> % change</label>
                                        </div>

                                        <!-- Options for Previous Year -->
                                        <label
                                            style="font-size: 12px; display: flex; align-items: center; margin-top: 5px;"><input
                                                type="checkbox" name="compare_options" value="previous_year" checked
                                                style="margin-right: 5px;"> Previous year (PY)</label>
                                        <div style="margin-left: 20px;">
                                            <label style="font-size: 12px; display: inline-block;"><input
                                                    type="checkbox" name="py_change" value="dollar_change"
                                                    style="margin-right: 5px;"> $ change</label>
                                            <label
                                                style="font-size: 12px; display: inline-block; margin-left: 20px;"><input
                                                    type="checkbox" name="py_change" value="percent_change"
                                                    style="margin-right: 5px;"> % change</label>
                                        </div>

                                        <!-- Percentage Options -->
                                        <label
                                            style="font-size: 12px; display: flex; align-items: center; margin-top: 5px;"><input
                                                type="checkbox" name="percent_options" value="percent_row"
                                                style="margin-right: 5px;"> % of Row</label>
                                        <label style="font-size: 12px; display: flex; align-items: center;"><input
                                                type="checkbox" name="percent_options" value="percent_column"
                                                style="margin-right: 5px;"> % of Column</label>

                                        <!-- Link to Reorder Columns -->
                                        <a href="#"
                                            style="font-size: 12px; color: #007bff; text-decoration: none; margin-top: 5px; display: block;">Reorder
                                            columns</a>
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

    <div class="col-md-10 col-md-offset-1" style="background-color: #ffffff;">
        <div class="box" style="background-color: #ffffff;">
            <div class="box-header with-border text-center">
                <h4 class="box-title" style="font-size: 24px;">{{ Session::get('business.name') }}</h4><br><br>
                <h5 class="box-title"><b>Profit and Loss Comparison Report</b></h5>
                <p>As of {{ @format_date($start_date) }} ~ {{ @format_date($end_date) }}</p>
            </div>

            <div>
                <table class="table table-striped table-bordered"
                    style="min-height: 300px; width: 100%; border-collapse: collapse; background-color: #ffffff;">
                    <thead style="background-color: #ffffff;">
                        <tr>
                            <th style="width: 60%; border-top: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; text-align:left;"></th>
                            <th colspan="2" style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align:center;">TOTAL</th>
                        </tr>
                        <tr>
                            <th style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align:left;"></th>
                            
                            <!-- Current Period -->
                            <th style="width: 20%; border-bottom: 1px solid #000; text-align:right;">
                                {{ strtoupper(\Carbon\Carbon::parse($start_date)->format('j M')) }} - {{ strtoupper(\Carbon\Carbon::parse($end_date)->format('j M, Y')) }}
                            </th>
                            
                            <th style="width: 20%; border-left: 2px solid #000; border-bottom: 1px solid #000; text-align:right;">
                                {{ strtoupper(\Carbon\Carbon::parse($start_date)->subYear()->format('j M')) }} - {{ strtoupper(\Carbon\Carbon::parse($end_date)->subYear()->format('j M, Y')) }} (PY)
                            </th>
                            
                        </tr>
                        
                    </thead>

                    <tbody id="balance-sheet-body" style="background-color: #ffffff;">
                        @foreach ($filtered_account_types as $type => $details)
                        @php
                        $primary_type_total_balance = $accounts
                        ->whereIn(
                            'account_sub_type_id',
                            $account_sub_types->where('account_primary_type', $type)->pluck('id'),
                        )
                        ->sum('balance');
                        @endphp
                        <tr style="background-color: #ffffff;">
                            <td colspan="3">
                                <button onclick="toggleDropdown(this)"
                                    style="cursor: pointer; padding: 10px; text-align: left; border: none; outline: none; width: 100%; font-weight: bold; background-color: #ffffff;">
                                    &#9660; {{ $details['label'] }}
                                </button>
                                <table class="table">
                                    @foreach ($account_sub_types->where('account_primary_type', $type)->all() as $sub_type)
                                    <tr style="background-color: #ffffff;">
                                        <td colspan="3">
                                            <button onclick="toggleDropdown(this)"
                                                style="cursor: pointer; padding: 10px; text-align: left; border: none; outline: none; width: 100%; font-weight: bold; background-color: #ffffff;">
                                                &#9660; {{ $sub_type->account_type_name }}
                                            </button>
                                            <table class="table" style="display: none;">
                                                @php
                                                $subtype_accounts = $accounts
                                                ->where('account_sub_type_id', $sub_type->id)
                                                ->sortBy('name');
                                                $total_balance = $subtype_accounts->sum('balance');
                                                @endphp
                                                @foreach ($subtype_accounts as $account)
                                                <tr class="account-row" data-balance="{{ $account->balance }}"
                                                    style="background-color: #ffffff;">
                                                    <td style="padding-left: 20px;">
                                                        <a href="{{ route('accounting.ledger', $account->id) }}"
                                                            style="text-decoration: none; color: inherit; width: 60%;">
                                                            {{ $account->name }}
                                                        </a>
                                                    </td>
                                                    <!-- Current period balance -->
                                                    <td style="text-align: right; width: 20%">
                                                        @format_currency($account->balance)
                                                    </td>
                                                    <!-- Previous period balance -->
                                                    <td style="text-align: right; width: 20%">
                                                        @if (isset($account->previous_balance))
                                                        @format_currency($account->previous_balance)
                                                        @else
                                                        @format_currency(0)
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr style="border-top: 1px solid #000; font-weight: bold; background-color: #ffffff;">
                                                    <td style="width: 60%;">Total for {{ $sub_type->account_type_name }}</td>
                                                    <td style="text-align: right; width:20%;">@format_currency($total_balance)</td>
                                                    <td style="text-align: right; width:20%;">@format_currency($previous_total)</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                <tr style="border-top: 1px solid #000; font-weight: bold; background-color: #ffffff;">
                                    <td style="width: 60%;">Total for {{ $details['label'] }}</td>
                                    <td style="text-align: right; width: 20%;">@format_currency($primary_type_total_balance)</td>
                                    <td style="text-align: right; width: 20%;">@format_currency($primary_type_total_balance)</td>
                                </tr>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div
                style="border-top: 1px solid #000; padding-left: 10px; font-weight: bold; display: flex; justify-content: space-between; background-color: #ffffff;">
                <span>NET EARNINGS</span>
                <span>@format_currency($net_earnings)</span>
                <span>@format_currency($net_earnings_previous)</span>
            </div>
            <br><br>
            <div style="text-align: center; color: gray;">
                {{ \Carbon\Carbon::now()->format('l, F j, Y g:i A T') }}
            </div>

        </div>
    </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function () {
        dateRangeSettings.startDate = moment('{{ $start_date }}');
        dateRangeSettings.endDate = moment('{{ $end_date }}');

        $('#date_range_filter').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $('#date_range_filter').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                apply_filter();
            }
        );
        $('#date_range_filter').on('cancel.daterangepicker', function (ev, picker) {
            $('#date_range_filter').val('');
            apply_filter();
        });

        function apply_filter() {
            var start = '';
            var end = '';

            if ($('#date_range_filter').val()) {
                start = $('input#date_range_filter')
                    .data('daterangepicker')
                    .startDate.format('YYYY-MM-DD');
                end = $('input#date_range_filter')
                    .data('daterangepicker')
                    .endDate.format('YYYY-MM-DD');
            }

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('start_date', start);
            urlParams.set('end_date', end);
            window.location.search = urlParams;
        }
    });

   // Toggle dropdown for nested rows
function toggleDropdown(button) {
    const dropdownContainer = $(button).closest('td').find('table').first();
    const arrow = $(button).html().trim().charAt(0);

    // Change arrow to down if the dropdown is visible
    if (dropdownContainer.is(':visible')) {
        $(button).html($(button).html().replace(arrow, '&#9654;')); // Change arrow to right
        dropdownContainer.hide();
    } else {
        $(button).html($(button).html().replace(arrow, '&#9660;')); // Change arrow to down
        dropdownContainer.show();
    }
}

// Ensure all dropdowns are expanded on page load
$(document).ready(function () {
    $('table.table').show(); // Show all nested tables
    $('button').each(function () {
        $(this).html($(this).html().replace('&#9654;', '&#9660;')); // Set all arrows down by default
    });
});

</script>
@endsection
