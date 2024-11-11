@extends('layouts.app')

@section('title', __('accounting::lang.budget_for_fy', ['fy' => $fy_year]))

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

            <h3 style="font-size: 18px; font-weight: bold; margin-bottom: 20px; padding-left: 12px;">Budget Overview: Budget_FY24_P&L - FY24 P&L Report</h3>
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
                        {!! Form::label('display_columns', __('Budget'), [
                            'style' => 'display: block; font-size: 12px; color: #333;',
                        ]) !!}
                        {!! Form::select(
                            'display_columns',
                            [
                                'Budget_FY24_P&L - FY24 P&L' => 'Budget_FY24_P&L - FY24 P&L',
                                
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
	@component('components.widget', ['class' => 'box-solid'])
    {!! Form::open(['url' => action([\Modules\Accounting\Http\Controllers\BudgetController::class, 'store']), 
            'method' => 'post', 'id' => 'add_budget_form' ]) !!}
        <input type="hidden" name="financial_year" value="{{$fy_year}}">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="active">
                            <a href="#monthly_tab" data-toggle="tab" 
                            aria-expanded="true">@lang('accounting::lang.monthly')</a>
                        </li>
                        <li>
                            <a href="#quarterly_tab" data-toggle="tab" 
                            aria-expanded="true">@lang('accounting::lang.quarterly')</a>
                        </li>
                        <li>
                            <a href="#yearly_tab" data-toggle="tab" 
                            aria-expanded="true">@lang('accounting::lang.yearly')</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="monthly_tab">
                            <div class="table-responsive" style="height: 500px;">
                                <table class="table table-striped">
                                    <tr>
                                        <th>
                                            @lang('account.account')
                                        </th>
                                        @foreach($months as $k => $m)
                                            <th>{{Carbon::createFromFormat('m', $k)->format('M')}}</th>
                                        @endforeach
                                    </tr>
                                    @foreach($accounts as $account)
                                        <tr>
                                            <th>{{$account->name}}</th>
                                            @foreach($months as $k => $m)
                                                @php
                                                    $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                                    $value = !is_null($account_budget) && !is_null($account_budget->$m) 
                                                    ? $account_budget->$m : null;
                                                @endphp
                                                <td>
                                                    <input type="text" class="form-control input_number" 
                                                    name="budget[{{$account->id}}][{{$m}}]" @if(!is_null($value))
                                                    value="{{@num_format($value)}}" @endif>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="quarterly_tab">
                            <div class="table-responsive" style="height: 500px;">
                                <table class="table table-striped">
                                    <tr>
                                        <th>
                                            @lang('account.account')
                                        </th>
                                        <th>
                                            @lang('accounting::lang.1st_quarter')
                                        </th>
                                        <th>
                                            @lang('accounting::lang.2nd_quarter')
                                        </th>
                                        <th>
                                            @lang('accounting::lang.3rd_quarter')
                                        </th>
                                        <th>
                                            @lang('accounting::lang.4th_quarter')
                                        </th>
                                    </tr>
                                    @foreach($accounts as $account)
                                            @php
                                                $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                            @endphp
                                        <tr>
                                            <th>{{$account->name}}</th>
                                            <td>
                                                <input type="text" class="form-control input_number" 
                                                name="budget[{{$account->id}}][quarter_1]"
                                                @if(!is_null($account_budget) && !is_null($account_budget->quarter_1)) 
                                                value="{{@num_format($account_budget->quarter_1)}}" @endif >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input_number" 
                                                name="budget[{{$account->id}}][quarter_2]"
                                                @if(!is_null($account_budget) && !is_null($account_budget->quarter_2)) 
                                                value="{{@num_format($account_budget->quarter_2)}}" @endif
                                                >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input_number" 
                                                name="budget[{{$account->id}}][quarter_3]"
                                                @if(!is_null($account_budget) && !is_null($account_budget->quarter_3)) 
                                                value="{{@num_format($account_budget->quarter_3)}}" @endif
                                                >
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input_number" 
                                                name="budget[{{$account->id}}][quarter_4]"
                                                @if(!is_null($account_budget) && !is_null($account_budget->quarter_4)) 
                                                value="{{@num_format($account_budget->quarter_4)}}" @endif
                                                >
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="yearly_tab">
                            <div class="table-responsive" style="height: 500px;">
                                <table class="table table-striped">
                                    <tr>
                                        <th>
                                            @lang('account.account')
                                        </th>
                                        <th class="text-center">
                                        {{$fy_year}}
                                        </th>
                                    </tr>
                                    @foreach($accounts as $account)
                                        @php
                                            $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                        @endphp
                                        <tr>
                                            <th>{{$account->name}}</th>
                                            <td>
                                                <input type="text" class="form-control input_number" 
                                                name="budget[{{$account->id}}][yearly]"
                                                @if(!is_null($account_budget) && !is_null($account_budget->yearly)) 
                                                value="{{@num_format($account_budget->yearly)}}" @endif
                                                >
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">@lang('messages.submit')</button>
            </div>
        </div>
    {!! Form::close() !!}
    @endcomponent
</section>
@stop
@section('javascript')
<script type="text/javascript">
	$(document).ready( function(){
	});
</script>
@endsection