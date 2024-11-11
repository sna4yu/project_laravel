@extends('layouts.app')

@section('title', __('Budget'))

{{-- @section('css')
<style>
.table-sticky thead,
.table-sticky tfoot {
  position: sticky;
}
.table-sticky thead {
  inset-block-start: 0; /* "top" */
}
.table-sticky tfoot {
  inset-block-end: 0; /* "bottom" */
}
.collapsed .collapse-tr {
    display: none;
}
</style>
@endsection --}}

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
        @slot('tool')
            <div class="box-tools">
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal"  
                    data-target="#add_budget_modal">
                    <i class="fas fa-plus"></i> Add</button>
            </div>
        @endslot
        <div class="card-body">
            <div class="row mb-10">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fiscal_year_picker">Financial year for the budget</label>
                        <input type="text" class="form-control" id="fiscal_year_picker" value="{{$fy_year}}" readonly>
                    </div>
                </div>
            </div>
            @if(count($budget)!=0)
                @include('quickbooks::business_overview.budget.budget_table
                ')
            @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4>Select a financial year to view the budget</h4>
                    </div>
                </div>
            @endif
        </div>
    @endcomponent
</section>
<div class="modal fade" id="add_budget_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        {!! Form::open(['url' => action([\Modules\Quickbooks\Http\Controllers\BudgetController::class, 'create']), 
            'method' => 'get', 'id' => 'add_budget_form' ]) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" 
                aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang( 'accounting::lang.financial_year_for_the_budget' )</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::number('financial_year', null, ['class' => 'form-control', 
                                'required', 'placeholder' => 
                                __( 'accounting::lang.financial_year_for_the_budget' ), 'id' => 'financial_year' ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang( 'accounting::lang.continue' )</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('javascript')
<script type="text/javascript">
	$(document).ready( function(){
        $('#fiscal_year_picker').datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        }).on('changeDate', function(e){
            window.location.href = 
            "{{action([\Modules\Quickbooks\Http\Controllers\BudgetController::class, 'index'])}}?financial_year=" + $('#fiscal_year_picker').val();
        });

        $('#financial_year').datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        })
	});
    $(document).on('click', '.toggle-tr', function(){
        $(this).closest('tbody').toggleClass('collapsed');
        var html = $(this).closest('tbody').hasClass('collapsed') ? 
        '<i class="fas fa-arrow-circle-right"></i>' : '<i class="fas fa-arrow-circle-down"></i>';
        $(this).find('.collapse-icon').html(html);
    })
</script>
@endsection