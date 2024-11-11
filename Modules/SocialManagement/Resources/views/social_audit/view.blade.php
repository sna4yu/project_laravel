@extends('layouts.app')
@section('title', __('socialmanagement::lang.asset_audit'))

@section('content')
    @includeIf('socialmanagement::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>
            @lang('socialmanagement::lang.asset_audit')
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
                        'placeholder' => __('All'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('audit_status_filter', __('Status') . ':') !!}
                    {!! Form::select('audit_status_filter', [1 => __('Posted'), 0 => __('Not Post')], null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'placeholder' => __('All'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('sell_list_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('sell_list_filter_date_range', null, [
                        'placeholder' => __('lang.select_a_date_range'),
                        'class' => 'form-control',
                        'readonly',
                    ]) !!}
                </div>
            </div>
        @endcomponent
        <div class="box box-solid">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="asset_audits_table">
                        <thead>
                            <tr>
                                <th>@lang('socialmanagement::lang.user')</th>
                                <th>@lang('socialmanagement::lang.social_name')</th>
                                <th>@lang('socialmanagement::lang.date')</th>
                                <th>@lang('socialmanagement::lang.morning_audit')</th>
                                <th>@lang('socialmanagement::lang.afternoon_audit')</th>
                                <th>@lang('socialmanagement::lang.morning_note')</th>
                                <th>@lang('socialmanagement::lang.afternoon_note')</th>
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
                    asset_audits_table.ajax.reload();
                }
            );
            $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#sell_list_filter_date_range').val('');
                asset_audits_table.ajax.reload();
            });

            var asset_audits_table = $('#asset_audits_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('social_audits.show', ['user_id' => $user_id, 'date' => $date]) }}",
                    type: 'GET',
                    data: function(d) {
                        d.audit_status = $('#audit_status_filter').val();
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
                columns: [
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'social_name',
                        name: 'social_name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format('YYYY-MM-DD'); // Format created_at date
                        }
                    },
                    {
                        data: 'morning_audit',
                        name: 'morning_audit',
                        render: function(data, type, row) {
                            if (row.morning_audit == 1) {
                                return '<span class="label bg-blue">@lang('socialmanagement::lang.done')</span>';
                            } else {
                                return '<span class="label bg-red">@lang('socialmanagement::lang.pending')</span>';
                            }
                        }
                    },
                    {
                        data: 'afternoon_audit',
                        name: 'afternoon_audit',
                        render: function(data, type, row) {
                            if (row.afternoon_audit == 1) {
                                return '<span class="label bg-blue">@lang('socialmanagement::lang.done')</span>';
                            } else {
                                return '<span class="label bg-red">@lang('socialmanagement::lang.pending')</span>';
                            }
                        }
                    },
                    {
                        data: 'morning_note',
                        name: 'morning_note'
                    },
                    {
                        data: 'afternoon_note',
                        name: 'afternoon_note'
                    }
                ]
            });

            $('#audit_status_filter, #asset_list_filter_location_id, #sell_list_filter_date_range').change(
            function() {
                asset_audits_table.ajax.reload();
            });
        });
    </script>
@endsection