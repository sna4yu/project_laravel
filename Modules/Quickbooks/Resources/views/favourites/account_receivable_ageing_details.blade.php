@extends('layouts.app')

@section('title', __('accounting::lang.account_receivable_ageing_details'))

@section('css')
<style>
    .content {
        background-color: #f4f5f7;
        padding: 20px;
        border-radius: 5px;
    }

    .box {
        background-color: #F4F5F8;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
    }

    .box-header {
        background-color: #f4f5f7;
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
    }

    .box-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-inline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .form-inline .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        color: #333;
    }

    .form-control {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .btn-outline-secondary, .btn-success {
        font-size: 14px;
        border-radius: 20px;
        padding: 5px 15px;
        margin-right: 10px;
    }

    .btn-outline-secondary {
        border-color: gray;
        color: gray;
    }

    .btn-success {
        background-color: #2ca01c;
        color: #fff;
    }

    /* Custom table styling */
    .table {
        width: 100%;
        text-align: center;
        border: 1px solid #ddd;
        border-collapse: collapse;
    }

    .table th, .table td {
        font-size: 12px;
        padding: 10px;
        border: 1px solid #ddd;
    }

    .table tfoot th {
        font-weight: bold;
        background-color: #f9f9f9;
    }

    .text-center {
        text-align: center;
    }

    /* Custom toggle for table rows */
    .toggle-tr {
        cursor: pointer;
    }

    .collapsed .collapse-tr {
        display: none;
    }

    .collapse-icon {
        margin-right: 5px;
    }

    /* Style the back link */
    .btn-link {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #007bff;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .btn-link svg {
        margin-right: 5px;
    }
</style>
@endsection

@section('content')


<section class="content">
    <!-- Back to report list link -->
    <a href="http://127.0.0.1:8000/AccountingQuickbooks/resource/view" class="btn btn-link">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.354 3.646a.5.5 0 0 1 0 .708L6.707 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0z" />
        </svg>
        @lang('Back to report list')
    </a>

    <!-- Title -->
    <div class="box">
        <div class="box-header text-center">
            <h2 class="box-title">@lang('A/R Ageing Summary Report')</h2>
        </div>

        <!-- Form section -->
        <form class="form-inline">
            <div class="form-group">
                {!! Form::label('report_period', __('Report period')) !!}
                {!! Form::select('report_period', [
                    'Today' => 'Today',
                    'All Dates' => 'All Dates',
                    'Custom' => 'Custom',
                ], null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('as_of', __('As of')) !!}
                {!! Form::date('as_of', \Carbon\Carbon::now()->format('Y-m-d'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('show_rows', __('Show non-zero or active only')) !!}
                {!! Form::select('show_rows', [
                    'Active rows/active columns' => 'Active rows/active columns',
                ], null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('ageing_method', __('Ageing method')) !!}
                <div class="radio">
                    {!! Form::radio('ageing_method', 'current', false, ['id' => 'current']) !!}
                    {!! Form::label('current', __('Current')) !!}
                    {!! Form::radio('ageing_method', 'report_date', true, ['id' => 'report_date']) !!}
                    {!! Form::label('report_date', __('Report date')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('days_per_period', __('Days per ageing period')) !!}
                {!! Form::text('days_per_period', '30', ['class' => 'form-control', 'style' => 'width: 60px;']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('number_of_periods', __('Number of periods')) !!}
                {!! Form::text('number_of_periods', '4', ['class' => 'form-control', 'style' => 'width: 50px;']) !!}
            </div>

            <button type="button" class="btn btn-outline-secondary">@lang('Customise')</button>
            <button type="button" class="btn btn-success">@lang('Save customisation')</button>
        </form>

        <!-- Table section -->
        <div class="box-body text-center">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('sale.customer_name')</th>
                        <th>@lang('lang_v1.current')</th>
                        <th>@lang('accounting::lang.1_30_days')</th>
                        <th>@lang('accounting::lang.31_60_days')</th>
                        <th>@lang('accounting::lang.61_90_days')</th>
                        <th>@lang('accounting::lang.91_and_over')</th>
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
                    @foreach ($report_details as $report)
                        <tr>
                            @php
                                $total_current += $report['<1'];
                                $total_1_30 += $report['1_30'];
                                $total_31_60 += $report['31_60'];
                                $total_61_90 += $report['61_90'];
                                $total_greater_than_90 += $report['>90'];
                                $grand_total += $report['total_due'];
                            @endphp
                            <td>{{ $report['name'] }}</td>
                            <td>@format_currency($report['<1'])</td>
                            <td>@format_currency($report['1_30'])</td>
                            <td>@format_currency($report['31_60'])</td>
                            <td>@format_currency($report['61_90'])</td>
                            <td>@format_currency($report['>90'])</td>
                            <td>@format_currency($report['total_due'])</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>@lang('sale.total')</th>
                        <td>@format_currency($total_current)</td>
                        <td>@format_currency($total_1_30)</td>
                        <td>@format_currency($total_31_60)</td>
                        <td>@format_currency($total_61_90)</td>
                        <td>@format_currency($total_greater_than_90)</td>
                        <td>@format_currency($grand_total)</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center" style="color: gray;">
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
                window.location.href = "{{ route('favourites.account_receivable_ageing_details') }}?location_id=" + $(this).val();
            } else {
                window.location.href = "{{ route('favourites.account_receivable_ageing_details') }}";
            }
        });

        $('.toggle-tr').on('click', function() {
            $(this).closest('tbody').toggleClass('collapsed');
            var html = $(this).closest('tbody').hasClass('collapsed') ? '<i class="fas fa-arrow-circle-right"></i>' : '<i class="fas fa-arrow-circle-down"></i>';
            $(this).find('.collapse-icon').html(html);
        });
    });
</script>
@stop
