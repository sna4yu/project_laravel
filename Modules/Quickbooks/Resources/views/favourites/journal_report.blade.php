@extends('layouts.app')

@section('title', __('Journal Report'))

@section('content')

    <section class="content" style="background-color: #f7f8fa;">
        <div class="row" style="padding: 20px; background-color: #f7f8fa;">
            <div class="box box-default" style="background-color: #356bd7;">
                <div class="box-body" style="background-color: #f1f1f1;">
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
                    <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 20px;">Balance Sheet Report</h3>
    
                    <!-- Form elements -->
                    <form class="form-inline"
style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between;">

<!-- Top Row -->
<div style="display: flex; gap: 15px; align-items: center;">
    <!-- Report Period -->
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
            ['class' => 'form-control', 'style' => 'font-size: 12px; width: 160px;'],
        ) !!}
    </div>

    <!-- As of Date -->
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
        style="font-size: 12px; border-radius: 20px; padding: 5px 15px;">@lang('Customise')</button>
    <button type="button" class="btn btn-success"
        style="font-size: 12px; border-radius: 20px; padding: 5px 15px; background-color: #28a745;">@lang('Save customisation')</button>
</div>

<!-- Bottom Row -->
<div style="display: flex; flex-wrap: wrap; gap: 15px; width: 100%; align-items: center; margin-top: 10px;">
    <!-- Display Columns By -->
    <div class="form-group">
        {!! Form::label('display_columns', __('Display columns by'), [
            'style' => 'display: block; font-size: 12px; color: #333;',
        ]) !!}
        {!! Form::select('display_columns', [
                'Total Only' => 'Total Only', 
                'Days' => 'Days', 
                'Weeks' => 'Weeks', 
                'Months' => 'Months', 
                'Quarters' => 'Quarters', 
                'Years' => 'Years', 
                'Customers' => 'Customers', 
                'Suppliers' => 'Suppliers', 
                'Classes' => 'Classes', 
                'Products/Services' => 'Products/Services'
            ], 
            null, [
                'class' => 'form-control',
                'style' => 'font-size: 12px; width: 160px; border-radius: 4px;',
            ]) 
        !!}
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
        style="font-size: 12px; width: 220px; cursor: pointer; text-align: left;" aria-haspopup="true"
        aria-expanded="false">
        Select per
    </button>

    <!-- Custom dropdown content -->
    <div class="dropdown-content" id="customDropdownContent"
        style="padding: 10px; font-size: 12px; display: none; position: absolute; top: 100%; left: 0; width: 220px; border: 1px solid #ddd; border-radius: 4px; background-color: #fff; z-index: 1000;">
        <div style="padding: 5px 10px;">
            <!-- Options for Previous Period -->
            <label style="font-size: 12px; display: flex; align-items: center;"><input type="checkbox" name="compare_options" value="previous_period" checked style="margin-right: 5px;"> Previous period (PP)</label>
            <div style="margin-left: 20px;">
                <label style="font-size: 12px; display: inline-block;"><input type="checkbox" name="pp_change" value="dollar_change" style="margin-right: 5px;"> $ change</label>
                <label style="font-size: 12px; display: inline-block; margin-left: 20px;"><input type="checkbox" name="pp_change" value="percent_change" style="margin-right: 5px;"> % change</label>
            </div>
            
            <!-- Options for Previous Year -->
            <label style="font-size: 12px; display: flex; align-items: center; margin-top: 5px;"><input type="checkbox" name="compare_options" value="previous_year" checked style="margin-right: 5px;"> Previous year (PY)</label>
            <div style="margin-left: 20px;">
                <label style="font-size: 12px; display: inline-block;"><input type="checkbox" name="py_change" value="dollar_change" style="margin-right: 5px;"> $ change</label>
                <label style="font-size: 12px; display: inline-block; margin-left: 20px;"><input type="checkbox" name="py_change" value="percent_change" style="margin-right: 5px;"> % change</label>
            </div>

            <!-- Percentage Options -->
            <label style="font-size: 12px; display: flex; align-items: center; margin-top: 5px;"><input type="checkbox" name="percent_options" value="percent_row" style="margin-right: 5px;"> % of Row</label>
            <label style="font-size: 12px; display: flex; align-items: center;"><input type="checkbox" name="percent_options" value="percent_column" style="margin-right: 5px;"> % of Column</label>

            <!-- Link to Reorder Columns -->
            <a href="#" style="font-size: 12px; color: #007bff; text-decoration: none; margin-top: 5px; display: block;">Reorder columns</a>
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
            {!! Form::radio('ageing_method', 'current', false, ['id' => 'current']) !!}
            {!! Form::label('current', __('Current'), ['style' => 'font-size: 12px; color: #333;']) !!}
        </div>
        <div class="radio" style="display: inline-block;">
            {!! Form::radio('ageing_method', 'report_date', true, ['id' => 'report_date']) !!}
            {!! Form::label('report_date', __('Report date'), ['style' => 'font-size: 12px; color: #333;']) !!}
        </div>
    </div>

    <!-- Days per Ageing Period -->
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
    </div>

    <!-- Run report Button -->
    <div class="form-group" style="margin-top: 10px;">
        <button type="button" class="btn btn-default"
            style="font-size: 12px; border-radius: 20px; padding: 5px 15px;">@lang('Run report')</button>
    </div>
</div>
</form>

    
                </div>
        </div>

        <!-- Journal Report Table -->
        <div class="col-md-12" style="background-color: #f7f8fa;">
            <div class="box" style="background-color: #f7f8fa;">
                <div class="box-header with-border text-center" style="background-color: #f7f8fa;">
                    <br>
                    <h4 class="box-title no-margin-top-20 no-margin-left-24">{{ Session::get('business.name') }}</h4><br>
                    <h4 class="box-title no-margin-top-20 no-margin-left-24">Journal</h4>
                    <p>{{ @format_date($start_date) }} - {{ @format_date($end_date) }}</p>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table table-bordered" style="width: 100%; border-collapse: collapse; background-color: #f7f8fa;">
                        <thead style="border-bottom: 2px solid #000;">
                            <tr>
                                <th style="width: 10%; text-align: left; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000; ">Date</th>
                                <th style="width: 15%; text-align: left; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">Transaction Type</th>
                                <th style="width: 10%; text-align: left; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">Number</th>
                                <th style="width: 20%; text-align: left; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">Description</th>
                                <th style="width: 20%; text-align: left; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">Account</th>
                                <th style="width: 10%; text-align: right; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">Debit</th>
                                <th style="width: 10%; text-align: right; padding: 8px; border-top: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($account_types as $type => $details)
                            @php
                                $primary_type_total_balance = $accounts
                                    ->whereIn(
                                        'account_sub_type_id',
                                        $account_sub_types->where('account_primary_type', $type)->pluck('id')
                                    )
                                    ->sum('balance');
                            @endphp
                            @foreach ($account_sub_types->where('account_primary_type', $type)->all() as $sub_type)
                            @php
                                $subtype_accounts = $accounts
                                    ->where('account_sub_type_id', $sub_type->id)
                                    ->sortBy('name');
                                $total_balance = $subtype_accounts->sum('balance');
                            @endphp
                            @foreach ($subtype_accounts as $account)
                            @php
                                $total_debit += $account->debit;
                                $total_credit += $account->credit;
                            @endphp
                            <tr style="background-color: #f7f8fa;">
                                <td style="padding: 8px;">{{ @format_date($account->created_at) }}</td>
                                <td style="padding: 8px;">{{ $account->detail_type->name }}</td>
                                <td style="padding: 8px;">{{ $account->ref_no }}</td>
                                <td style="padding: 8px;">{{ $account->description }}</td>
                                <td style="padding: 8px;">{{ $sub_type->account_type_name }}</td>
                                <td style="text-align: right; padding: 8px;">
                                    <a href="{{ route('accounting.ledger', $account->id) }}" style="text-decoration: none; color: inherit;">
                                        @format_currency($account->debit)
                                    </a>
                                </td>
                                <td style="text-align: right; padding: 8px;">
                                    <a href="{{ route('accounting.ledger', $account->id) }}" style="text-decoration: none; color: inherit;">
                                        @format_currency($account->credit)
                                    </a>
                                </td>
                                
                            </tr>
                            @endforeach
                            @endforeach
                            @endforeach
                            <tr style="font-weight: bold">
                                <td colspan="5" style="text_align: left; padding: 8px; border-top: 2px solid #000; ">Total</td>
                                <td style="text-align: right; padding: 8px; border-top: 2px solid #000;">@format_currency($total_debit)</td>
                                <td style="text-align: right; padding: 8px; border-top: 2px solid #000;">@format_currency($total_credit)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
                $('#date_range_filter').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                apply_filter();
            }
        );
        $('#date_range_filter').on('cancel.daterangepicker', function(ev, picker) {
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
</script>

@endsection
