@extends('layouts.app')

@section('title', __('accounting::lang.account_payable_ageing_report'))

@section('content')  

<section class="content">
    <div class="box box-default">
        <div class="box box-default" style="background-color: #356bd7;">
            <div class="box-body" style="background-color: #F4F5F8;">

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
                    <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 20px;">Account Payable Ageing Summary Report</h3>

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
                            <h5 class="box-title"><b>Account Payable Ageing Summary</b></h5>
                            <p>{{ 'As of ' . \Carbon\Carbon::now()->format('F j, Y') }}</p>
                        </div>
                        <div class="box-body">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th>@lang( 'lang_v1.supplier_name')</th>
                                <th>@lang( 'lang_v1.current')</th>
                                <th>
                                    @lang( 'accounting::lang.1_30_days' )
                                </th>
                                <th>
                                    @lang( 'accounting::lang.31_60_days' )
                                </th>
                                <th>
                                    @lang( 'accounting::lang.61_90_days' )
                                </th>
                                <th>
                                    @lang( 'accounting::lang.91_and_over' )
                                </th>
                                <th>@lang('sale.total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_current = 0;
                                $total_1_30 = 0;
                                $total_31_60 = 0;
                                $total_61_90 = 0;
                                $total_greater_than_90 = 0;
                                $grand_total = 0;
                            @endphp
                            @foreach($report_details as $report)
                                <tr>
                                    @php
                                        $total_current += $report['<1'];
                                        $total_1_30 += $report['1_30'];
                                        $total_31_60 += $report['31_60'];
                                        $total_61_90 += $report['61_90'];
                                        $total_greater_than_90 += $report['>90'];
                                        $grand_total += $report['total_due'];
                                    @endphp
                                    <td>
                                        {{$report['name']}}
                                    </td>
                                    <td>
                                        @format_currency($report['<1'])
                                    </td>
                                    <td>
                                        @format_currency($report['1_30'])
                                    </td>
                                    <td>
                                        @format_currency($report['31_60'])
                                    </td>
                                    <td>
                                        @format_currency($report['61_90'])
                                    </td>
                                    <td>
                                        @format_currency($report['>90'])
                                    </td>
                                    <td>
                                        @format_currency($report['total_due'])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>
                                    @lang('sale.total')
                                </th>
                                <td>
                                    @format_currency($total_current)
                                </td>
                                <td>
                                    @format_currency($total_1_30)
                                </td>
                                <td>
                                    @format_currency($total_31_60)
                                </td>
                                <td>
                                    @format_currency($total_61_90)
                                </td>
                                <td>
                                    @format_currency($total_greater_than_90)
                                </td>
                                <td>@format_currency($grand_total)</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

@stop

@section('javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('#location_id').change( function(){
            if($(this).val()) {
                window.location.href = "{{route('accounting.account_payable_ageing_report')}}?location_id=" + $(this).val();
            } else {
                window.location.href = "{{route('accounting.account_payable_ageing_report')}}";
            }
            
        });
    });
</script>

@stop