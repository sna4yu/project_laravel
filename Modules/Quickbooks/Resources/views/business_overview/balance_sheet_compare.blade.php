@extends('layouts.app')

@section('title', __('Balance Sheet Comparison'))

@section('content')

    <section class="content" style="background-color: #ffffff;">
        <div class="row" style="padding: 20px; background-color: #ffffff;">
                
                <div class="box-body" style="background-color: #F4F5F8;">
                    <!-- Back to report list link -->
                    <a href="http://127.0.0.1:8000/AccountingQuickbooks/resource/view" class="btn btn-link"
                        style="display: inline-flex; align-items: center; text-decoration: none; color: #007bff; font-size: 14px; margin-bottom: 15px;">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px;">
                            <path fill-rule="evenodd"
                                d="M10.354 3.646a.5.5 0 0 1 0 .708L6.707 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0z" />
                        </svg>
                        @lang('Back to report list')
                    </a>

                    <!-- Title -->

                    <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 12px;">Balance Sheet
                        Comparison Report</h3>
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
        </div>

        <div class="col-md-10 col-md-offset-1" style="background-color: #ffffff;">
            <div class="box" style="background-color: #ffffff;">

                <div class="box-header text-center" style="background-color: #ffffff;">
                    <h4 class="box-title" style="font-size: 24px;">{{ Session::get('business.name') }}</h4><br><br>
                    <h4 class="box-title">Balance Sheet Comparison</h4>
                    <p>as of {{ @format_date($start_date) }} ~ {{ @format_date($end_date) }}</p>
                </div>

                <div>
                    <table class="table table-striped table-bordered"
                        style="min-height: 300px; width: 100%; border-collapse: collapse; background-color: #ffffff;">
                        <thead style="background-color: #ffffff;">
                            <tr>
                                <th rowspan="2"
                                    style="width: 50%; border-top: 1px solid #000; border-right: 1px solid #000; border-bottom: 1px solid #000; text-align:center;">
                                    Account Name
                                </th>
                                <th colspan="2"
                                    style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">
                                    Total
                                </th>
                            </tr>
                            <tr>
                                <th
                                    style="width: 25%; border-right: 1px solid #000; border-bottom: 1px solid #000; text-align:right;">
                                    Balance as of {{ @format_date($start_date) }} ~ {{ @format_date($end_date) }}
                                </th>
                                <th style="width: 25%; border-bottom: 1px solid #000; text-align:right;">
                                    Balance as of {{ @format_date($start_date_2023) }} ~ {{ @format_date($end_date_2023) }}
                                </th>
                            </tr>
                        </thead>



                        <tbody id="balance-sheet-body" style="background-color: #ffffff;">
                            @foreach ($account_types as $type => $details)
                                @php
                                    $primary_type_total_balance_2024 = $accounts['2024']
                                        ->whereIn(
                                            'account_sub_type_id',
                                            $account_sub_types->where('account_primary_type', $type)->pluck('id'),
                                        )
                                        ->sum('balance');

                                    $primary_type_total_balance_2023 = $accounts['2023']
                                        ->whereIn(
                                            'account_sub_type_id',
                                            $account_sub_types->where('account_primary_type', $type)->pluck('id'),
                                        )
                                        ->sum('balance');
                                @endphp
                                <tr style="background-color: #ffffff;">
                                    <td colspan="3">
                                        <button onclick="toggleDropdown(this)"
                                            style="cursor: pointer; padding: 10px; text-align: left; border: none; outline: none; width: 100%;  background-color: #ffffff;">
                                            &#9660; {{ $details['label'] }}
                                        </button>
                                        <div class="dropdown-content" style="display: block;">
                                            @foreach ($account_sub_types->where('account_primary_type', $type)->all() as $sub_type)
                                                <div style="padding-left: 20px; background-color: #ffffff;">
                                                    <button onclick="toggleDropdown(this)"
                                                        style="cursor: pointer; padding: 10px; text-align: left; border: none; outline: none; width: 100%;  background-color: #ffffff;">
                                                        &#9660; {{ $sub_type->account_type_name }}
                                                    </button>
                                                    <div class="dropdown-content" style="display: block;">
                                                        @php
                                                            $subtype_accounts_2024 = $accounts['2024']
                                                                ->where('account_sub_type_id', $sub_type->id)
                                                                ->sortBy('name');
                                                            $total_balance_2024 = $subtype_accounts_2024->sum(
                                                                'balance',
                                                            );

                                                            $subtype_accounts_2023 = $accounts['2023']
                                                                ->where('account_sub_type_id', $sub_type->id)
                                                                ->sortBy('name');
                                                            $total_balance_2023 = $subtype_accounts_2023->sum(
                                                                'balance',
                                                            );
                                                        @endphp
                                                        @foreach ($subtype_accounts_2024 as $account)
                                                            @php
                                                                $account_2023 = $subtype_accounts_2023
                                                                    ->where('id', $account->id)
                                                                    ->first();
                                                            @endphp
                                                            <div class="account-row"
                                                                data-balance="{{ $account->balance }}"
                                                                style="padding-left: 20px; display: flex; justify-content: space-between; background-color: #ffffff;">
                                                                <a href="{{ route('accounting.ledger', $account->id) }}"
                                                                    style="text-decoration: none; color: inherit;">
                                                                </a>
                                                                <span
                                                                    style="text-align: left; width: 50%; color: gray;">{{ $account->name }}</span>
                                                                <span
                                                                    style="text-align: right; width: 25%; color: gray;">@format_currency($account->balance)</span>
                                                                <span
                                                                    style="text-align: right; width: 25%; color: gray;">@format_currency($account_2023->balance ?? 0)</span>
                                                            </div>
                                                        @endforeach
                                                        <div
                                                            style="border-top: 1px solid #ddd; padding-left: 10px; font-weight: bold; display: flex; justify-content: flex-end; background-color: #ffffff; width: 95%; margin: 0 auto;">
                                                            <span style="text-align: left; width: 50%;">Total for
                                                                {{ $sub_type->account_type_name }}</span>
                                                            <span
                                                                style="text-align: right; width: 25%;">@format_currency($total_balance_2024)</span>
                                                            <span
                                                                style="text-align: right; width: 25%;">@format_currency($total_balance_2023)</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                        <div
                                            style="border-top: 1px solid #000; border-bottom: 3px double #000; padding-left: 10px; font-weight: bold; display: flex; justify-content: space-between; background-color: #ffffff;">
                                            <span style="text-align: left; width: 50%;">Total for
                                                {{ $details['label'] }}</span>
                                            <span style="text-align: right; width: 25%;">@format_currency($primary_type_total_balance_2024)</span>
                                            <span style="text-align: right; width: 25%;">@format_currency($primary_type_total_balance_2023)</span>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="text-align: center; color: gray;">
                        {{ \Carbon\Carbon::now()->format('l, F j, Y g:i A T') }}
                    </div>

                </div>
    </section>
    </div>
@endsection

@section('javascript')

    <script type="text/javascript">
        $(document).ready(function() {
            dateRangeSettings.startDate = moment('{{ $start_date }}');
            dateRangeSettings.endDate = moment('{{ $end_date }}');

            $('#date_range_filter').daterangepicker(
                dateRangeSettings,
                function(start, end) {
                    $('#date_range_filter').val(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'));
                    apply_filter();
                }
            );

            $('#date_range_filter').on('cancel.daterangepicker', function(ev, picker) {
                $('#date_range_filter').val('');
                apply_filter();
            });
        });

        function apply_filter() {
            var start = '';
            var end = '';

            if ($('#date_range_filter').val()) {
                start = $('#date_range_filter').data('daterangepicker').startDate.format('YYYY-MM-DD');
                end = $('#date_range_filter').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('start_date', start);
            urlParams.set('end_date', end);
            window.location.search = urlParams.toString();
        }

        function toggleDropdown(button) {
            const dropdownContainer = button.nextElementSibling;
            const arrow = button.innerHTML.trim().charAt(0);
            if (dropdownContainer.style.display === "none" || dropdownContainer.style.display === "") {
                dropdownContainer.style.display = "block";
                button.innerHTML = button.innerHTML.replace(arrow, '&#9660;'); // Change arrow down
            } else {
                dropdownContainer.style.display = "none";
                button.innerHTML = button.innerHTML.replace(arrow, '&#9654;'); // Change arrow right
            }
        }
    </script>

@endsection