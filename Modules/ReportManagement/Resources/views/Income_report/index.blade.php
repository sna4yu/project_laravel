@extends('layouts.app')
@section('title', ('Income Report'))
@section('content')
@include('accounting::layouts.nav')

<!-- Content Header (Page header) -->

{{-- Don't Touch the code below --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Khmer&family=Noto+Serif+Khmer:wght@100..900&display=swap" rel="stylesheet">

{{-- CSS Section --}}
<style>
    /* form-group Button */
    .form-group {
        font-family: "Noto Serif Khmer", serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "wdth"100;

        background-color: white;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
        /* adds transition effect */

    }

    /* Use to set a khmer + english beutiful font for Table title*/
    .table {
        font-family: "Noto Serif Khmer", serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "wdth"100;
    }

    /* Use to set a khmer + english beutiful font for Div*/
    div {
        font-family: "Noto Serif Khmer", serif;
        font-optical-sizing: auto;
        font-weight: <weight>;
        font-style: normal;
        font-variation-settings:
            "wdth"100;
    }

</style>

<section class="content-header">
    <h1 style="font-family: Noto Serif Khmer, serif;">@lang('របាយការណ៍ប្រកាសពន្ធលើចំណូលប្រចាំខែ')</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">

            @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('location_id', __('កំណត់ទីតាំង') . ':') !!}
                    {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('expense_date_range', __('កំណត់ពេលវេលា') . ':') !!}
                    {!! Form::text('date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'id' => 'expense_date_range', 'readonly']); !!}
                </div>
            </div>
            @endcomponent

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('Income Report')])
            @can('expense.add')
            @slot('tool')
            @endslot
            @endcan
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="income_report">
                    <thead>
                        <tr>
                            <th>@lang('លរ')</th>
                            <th>@lang('ថ្ងៃខែលក់')</th>
                            <th>@lang('លេខវិក័យបត្រ')</th>
                            <th>@lang('ឈ្មោះអតិថិជន')</th>
                            <th>@lang('ទឹកប្រាក់សរុបដុល្លារ')</th>
                            <th>@lang('ទឹកប្រាក់សរុបរៀល')</th>
                            <th>@lang('ទឹកប្រាក់មិនគិតថ្លៃពន្ធ')</th>
                            <th>@lang('ពន្ធដា')</th>
                            <th>@lang('អត្រាប្តូរប្រាក់')</th>
                            <th>@lang('កំណត់សម្គាល់')</th>
                        </tr>
                    </thead>

                </table>
            </div>
            @endcomponent
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        contract_table = $('#income_report').DataTable({
            processing: true
            , serverSide: true
            , ajax: {
                "url": "{{ action([\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'getData']) }}"
                , "data": function(d) {
                    if ($('#user_id_filter').length) {
                        d.user_id = $('#user_id_filter').val();
                    }
                    if ($('#leave_filter_date_range').val()) {
                        var start = $('#leave_filter_date_range').data('daterangepicker').startDate
                            .format('YYYY-MM-DD');
                        var end = $('#leave_filter_date_range').data('daterangepicker').endDate
                            .format('YYYY-MM-DD');
                        d.start_date = start;
                        d.end_date = end;
                    }
                }
            }
            , columns: [{
                    data: 'user_name'
                    , name: 'user_name'
                }
                , {
                    data: 'contract_id'
                    , name: 'contract_id'
                }
                , {
                    data: 'expires_id'
                    , name: 'expires_id'
                }
                , {
                    data: 'business_id'
                    , name: 'business_id'
                }
                , {
                    data: 'action'
                    , name: 'action'
                }
                , {
                    data: ''
                    , name: ''
                }
                , {
                    data: ''
                    , name: ''
                }
                , {
                    data: ''
                    , name: ''
                }
                , {
                    data: ''
                    , name: ''
                }
                , {
                    data: ''
                    , name: ''
                }
            ]
        , });

        $('#leave_filter_date_range').daterangepicker(
            dateRangeSettings
            , function(start, end) {
                $('#leave_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                    moment_date_format));
            }
        );
        $('#leave_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#leave_filter_date_range').val('');
            contract_table.ajax.reload();
        });

        $(document).on('change'
            , '#user_id_filter, #status_filter, #leave_filter_date_range, #leave_type_filter'
            , function() {
                contract_table.ajax.reload();
            });

        $('#add_leave_modal').on('shown.bs.modal', function(e) {
            $('#add_leave_modal .select2').select2();

            $('form#add_leave_form #start_date, form#add_leave_form #end_date').datepicker({
                autoclose: true
            , });
        });


    });

</script>
@endsection
