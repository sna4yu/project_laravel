@extends('layouts.app')

@section('title', __('Account List'))

@section('content')

    @include('test::Layouts.navbar')
    <div style="background-color: #ffffff;">
        <section class="content-header" style="background-color: #ffffff;">
            <h1>Account List</h1>
            <p><a href="http://127.0.0.1:8000/test/report_management">Back to report list</a></p>
        </section>
        <hr>
        <section class="content" style="background-color: #ffffff;">
            <div class="row" style="padding: 20px; background-color: #ffffff;">
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('date_range_filter', __('report.date_range') . ':') !!}
                        {!! Form::text('date_range_filter', "{$start_date} ~ {$end_date}", [
                            'placeholder' => __('lang_v1.select_a_date_range'),
                            'class' => 'form-control',
                            'readonly',
                            'id' => 'date_range_filter',
                            'style' => 'border-radius: 10px; border: 1px solid #ccd1d9; padding: 8px 12px; background-color: #ffffff;',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('accounting_method', __('Accounting method')) !!}
                        {!! Form::select('accounting_method', ['Accrual' => 'Accrual', 'Cash' => 'Cash'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('item', __('Item')) !!}
                        {!! Form::select('item', ['None selected' => 'None selected'], null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block" onclick="apply_filter()">Filter</button>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-print"></i>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="window.print()">Export to PDF</a>
                            <a class="dropdown-item" href="#">Export to Excel</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-10 col-md-offset-1" style="background-color: #ffffff;">
                <div class="box" style="background-color: #ffffff;">
                    <div class="box-header with-border text-center" style="background-color: #ffffff;">
                        <br>
                        <h4 class="box-title no-margin-top-20 no-margin-left-24">ឌឹ ហ្វក់សេស​ អាត​ ខូអិល ធីឌី</h4><br>
                        <h4 class="box-title no-margin-top-20 no-margin-left-24">Account List</h4>
                        <p>as of {{ @format_date($start_date) }} ~ {{ @format_date($end_date) }}</p>
                    </div>

                    <div>
                        <table class="table table-borderless"
                            style="min-height: 300px; width: 100%; border-collapse: collapse; background-color: #ffffff;">
                            <thead style="background-color: #ffffff;">
                                <tr>
                                    <th style="width: 30%; text-align:left; font-weight: bold; border-bottom: 2px solid #000;">
                                        Account Name
                                    </th>
                                    <th style="width: 10%; text-align:left; font-weight: bold; border-bottom: 2px solid #000;">
                                        Type
                                    </th>
                                    <th style="width: 20%; text-align:left; font-weight: bold; border-bottom: 2px solid #000;">
                                        Detail Type
                                    </th>
                                    <th style="width: 20%; text-align:right; font-weight: bold; border-bottom: 2px solid #000;">
                                        Description
                                    </th>
                                    <th style="width: 20%; text-align:right; font-weight: bold; border-bottom: 2px solid #000;">
                                        Amount
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="balance-sheet-body" style="background-color: #ffffff;">
                                @foreach ($account_types as $type => $details)
                                    @php
                                        $primary_type_total_balance = $accounts
                                            ->whereIn(
                                                'account_sub_type_id',
                                                $account_sub_types->where('account_primary_type', $type)->pluck('id'),
                                            )
                                            ->sum('balance');
                                    @endphp
                                    <tr style="background-color: #ffffff;">
                                        <td colspan="5" style="font-weight: bold; cursor: pointer;" data-toggle="collapse" data-target="#collapse_{{ $type }}">
                                            {{ $details['label'] }} <i class="fa fa-caret-up"></i>
                                        </td>
                                    </tr>
                                    <tr id="collapse_{{ $type }}">
                                        <td colspan="5">
                                            <table class="table">
                                                @foreach ($account_sub_types->where('account_primary_type', $type)->all() as $sub_type)
                                                    @php
                                                        $subtype_accounts = $accounts
                                                            ->where('account_sub_type_id', $sub_type->id)
                                                            ->sortBy('name');
                                                        $total_balance = $subtype_accounts->sum('balance');
                                                    @endphp
                                                    @foreach ($subtype_accounts as $account)
                                                        <tr>
                                                            <td style="padding-left: 20px;">{{ $account->name }}</td>
                                                            <td>{{ $sub_type->account_type_name }}</td>
                                                            <td>{{ $account->detail_type->name }}</td>
                                                            <td>{{ $account->description }}</td>
                                                            <td style="text-align: right;">@format_currency($account->balance)</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
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

        $('.collapse').on('show.bs.collapse', function() {
            $(this).prev('tr').find('.fa').removeClass('fa-caret-down').addClass('fa-caret-up');
        }).on('hide.bs.collapse', function() {
            $(this).prev('tr').find('.fa').removeClass('fa-caret-up').addClass('fa-caret-down');
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
