@extends('layouts.app')
@section('title', __('socialmanagement::lang.social_audit'))

@section('content')
    @includeIf('socialmanagement::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>
            @lang('socialmanagement::lang.social_audit')
        </h1>
    </section>
    <!-- Main content -->
    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('asset_list_filter_location_id', __('purchase.business_location') . ':') !!}
                    {!! Form::select('asset_list_filter_location_id', $business_locations, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('socialmanagement::lang.all'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('user_filter', __('socialmanagement::lang.user'). ':') !!}
                    {!! Form::select('user_filter', $users, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('sell_list_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('sell_list_filter_date_range', null, [
                        'placeholder' => __('lang_v1.select_a_date_range'),
                        'class' => 'form-control',
                        'readonly',
                    ]) !!}
                </div>
            </div>
             @can('asset.create')
                    <div class="box-tools pull-right">
                        <a class="btn btn-block btn-primary" href="{{ route('social_audits.create') }}">
                    <i class="fa fa-plus"></i> @lang('messages.add')</a>
                    </div>
                @endcan
        @endcomponent
    
        <div class="box box-solid">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="social_audits_table">
                        <thead>
                            <tr>
                                <th>@lang('socialmanagement::lang.date')</th>
                                <th>@lang('socialmanagement::lang.user')</th>
                                <th>@lang('socialmanagement::lang.social_count')</th>
                                <th>@lang('socialmanagement::lang.morning_audit_done_count')</th>
                                <th>@lang('socialmanagement::lang.morning_audit_pending_count')</th>
                                 <th>@lang('socialmanagement::lang.posted_morning_count')</th>
                                <th>@lang('socialmanagement::lang.not_posted_morning_count')</th>
                                <th>@lang('socialmanagement::lang.afternoon_audit_done_count')</th>
                                <th>@lang('socialmanagement::lang.afternoon_audit_pending_count')</th>
                               
                                <th>@lang('socialmanagement::lang.posted_afternoon_count')</th>
                                <th>@lang('socialmanagement::lang.not_posted_afternoon_count')</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sell_list_filter_date_range').daterangepicker(
                dateRangeSettings,
                function(start, end) {
                    $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(
                        moment_date_format));
                    social_audits_table.ajax.reload();
                }
            );
            $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#sell_list_filter_date_range').val('');
                social_audits_table.ajax.reload();
            });

            var social_audits_table = $('#social_audits_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('social_audits.index') }}",
                    type: 'GET',
                    data: function(d) {
                        d.user_id = $('#user_filter').val();
                        d.location_id = $('#asset_list_filter_location_id').val();
                        if ($('#sell_list_filter_date_range').data('daterangepicker')) {
                            d.start_date = $('#sell_list_filter_date_range').data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            d.end_date = $('#sell_list_filter_date_range').data('daterangepicker').endDate
                                .format('YYYY-MM-DD');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                },
                columns: [{
                        data: 'social_date',
                        name: 'social_date'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                    },
                    {
                        data: 'social_count',
                        name: 'social_count'
                    },
                    {
                        data: 'morning_audit_done_count',
                        name: 'morning_audit_done_count'
                    },
                    {
                               data: 'posted_morning_count',
                        name: 'posted_morning_count'
                    },
                    {
                        data: 'not_posted_morning_count',
                        name: 'not_posted_morning_count'
                    },
                    {
                        data: 'morning_audit_pending_count',
                        name: 'morning_audit_pending_count'
                    },
                    {
                        data: 'afternoon_audit_done_count',
                        name: 'afternoon_audit_done_count'
                    },
                    {
                        data: 'afternoon_audit_pending_count',
                        name: 'afternoon_audit_pending_count'
                    },
                    {
             
                        data: 'posted_afternoon_count',
                        name: 'posted_afternoon_count'
                    },
                    {
                        data: 'not_posted_afternoon_count',
                        name: 'not_posted_afternoon_count'
                    }
                ]
            });

            $('#user_filter, #asset_list_filter_location_id, #sell_list_filter_date_range').change(function() {
                social_audits_table.ajax.reload();
            });
        });
    </script>
@endsection