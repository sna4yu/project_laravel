@extends('layouts.app')

@section('title', __('test::lang.yearly_income_expense'))

@section('content')
    @include('test::Layouts.navbar')
    {{-- @include('accounting::layouts.nav') --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <section class="content-header">
        <h1>@lang('test::lang.yearly_income_expense')</h1>
    </section>

    <section class="content no-print">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('account_type_filter', __('accounting::lang.account_type') . ':') !!}
                    {!! Form::select('account_type_filter', $account_types, null, [
                        'class' => 'form-control select2',
                        'style' => 'width:100%',
                        'id' => 'account_type_filter',
                        'placeholder' => __('lang_v1.all'),
                    ]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('transaction_date_range', __('report.date_range') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        {!! Form::text('transaction_date_range', null, [
                            'class' => 'form-control',
                            'readonly',
                            'placeholder' => __('report.date_range'),
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <button id="print-btn" class="btn btn-primary" style="margin-top: 25px;"
                        onclick="printTable();">@lang('test::lang.print')</button>
                    <button id="excel-btn" class="btn btn-primary" style="margin-top: 25px; margin-left: 10px;"
                        onclick="exportToExcel();">@lang('test::lang.export_to_excel')</button>
                </div>
            </div>

            @if (!empty($sources))
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sell_list_filter_source', __('lang_v1.sources') . ':') !!}
                        {!! Form::select('sell_list_filter_source', $sources, null, [
                            'class' => 'form-control select2',
                            'style' => 'width:100%',
                            'placeholder' => __('lang_v1.all'),
                        ]) !!}
                    </div>
                </div>
            @endif
        @endcomponent

        <div class="box box-warning" id="sell_table">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr class="table-striped table-bordered text-center">
                            <td colspan="15" style="font-size: 20px;"><strong>The Foxest Arts Co.,Ltd</strong></td>
                        </tr>
                        <tr class="table-striped table-bordered text-center">
                            <td colspan="15" style="font-size: 20px;"><strong>របាយការណ៏ចំណូលចំណាយ ប្រចាំខែ
                                    ឆ្នាំ២០២៤</strong></td>
                        </tr>

                        <tr class="text-center">
                            <th style="background-color: #f0cc70;"></th>
                            <th style="background-color: #f0cc70;">គណនីលម្អិត</th>
                            <th style="background-color: #f0cc70;">មករា</th>
                            <th style="background-color: #f0cc70;">កុម្ភៈ</th>
                            <th style="background-color: #f0cc70;">មិនា</th>
                            <th style="background-color: #f0cc70;">មេសា</th>
                            <th style="background-color: #f0cc70;">ឧសភា</th>
                            <th style="background-color: #f0cc70;">មិថុនា</th>
                            <th style="background-color: #f0cc70;">កក្កដា</th>
                            <th style="background-color: #f0cc70;">សីហា</th>
                            <th style="background-color: #f0cc70;">កញ្ញា</th>
                            <th style="background-color: #f0cc70;">តុលា</th>
                            <th style="background-color: #f0cc70;">វិច្ចិកា</th>
                            <th style="background-color: #f0cc70;">ធ្នូ</th>
                            <th style="background-color: #f0cc70;"><strong>សរុប</strong></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="background-color: #bebdba;">ចំណូល (Revenue/Sales)</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jan">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Feb">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Mar">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Apr">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-May">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jun">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jul">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Aug">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Sep">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Oct">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Nov">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Decem">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-debit">-</td>
                        </tr>
                    </thead>
                    <tbody id="income_tbody"></tbody>
                    <thead>
                        <tr>
                            <td></td>
                            <td style="background-color: #bebdba;">ចំណាយថ្លៃដើម (Cost of Service)</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jan">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Feb">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Mar">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Apr">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-May">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jun">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jul">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Aug">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Sep">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Oct">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Nov">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Decem">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-debit">-</td>
                        </tr>
                    <tbody id="expenses_cos_tbody"></tbody>
                    </thead>
                    <thead>
                        <tr>
                            <td></td>
                            <td style="background-color: #bebdba;">ចំណាយថ្លៃដើមផលិតផល ( Cost of Goods )</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jan">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Feb">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Mar">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Apr">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-May">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jun">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jul">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Aug">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Sep">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Oct">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Nov">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Decem">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-debit">-</td>
                        </tr>
                    </thead>
                    <tbody id="expenses_cog_tbody"></tbody>
                    <thead>
                        <tr class="font-17 text-center">
                            <td style="background-color: #f0cc70;"></td>
                            <td style="background-color: #f0cc70; font-size: 14px"><strong>ចំណេញខាត (Net Profit)</strong>
                            </td>
                            <td style="background-color: #f0cc70;" class="footer-total-Jan">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Feb">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Mar">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Apr">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-May">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Jun">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Jul">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Aug">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Sep">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Oct">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Nov">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Decem">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-total">-</td>
                        </tr>

                        <tr>
                            <td></td>
                            <td style="background-color: #bebdba;">ចំណាយប្រតិបត្តិការ​</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jan">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Feb">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Mar">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Apr">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-May">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jun">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jul">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Aug">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Sep">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Oct">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Nov">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Decem">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-debit">-</td>
                        </tr>
                    <tbody id="expenses_operator_tbody"></tbody>
                    </thead>
                    <thead>
                        <tr>
                            <td></td>
                            <td style="background-color: #bebdba;">ចំណាយទិញទ្រព្យ</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jan">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Feb">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Mar">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Apr">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-May">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jun">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Jul">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Aug">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Sep">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Oct">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Nov">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-Decem">-</td>
                            <td style="background-color: #bebdba;" class="footer-total-debit">-</td>
                        </tr>
                    <tbody id="expenses_assets_tbody"></tbody>
                    </thead>
                    <thead>
                        <tr class="font-17 text-center">
                            <td style="background-color: #f0cc70;"></td>
                            <td style="background-color: #f0cc70; font-size: 14px"><strong>ចំណេញខាត (Net Profit)</strong>
                            </td>
                            <td style="background-color: #f0cc70;" class="footer-total-Jan">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Feb">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Mar">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Apr">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-May">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Jun">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Jul">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Aug">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Sep">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Oct">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Nov">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-Decem">-</td>
                            <td style="background-color: #f0cc70;" class="footer-total-total">-</td>
                        </tr>
                    </thead>

                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script type="text/javascript">
        var dateRangeSettings = {
            startDate: moment().startOf('year'),
            endDate: moment().endOf('year'),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        };

        $('#transaction_date_range').daterangepicker(
            dateRangeSettings,
            function(start, end) {
                $('#transaction_date_range').val(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'));
                loadData();
            }
        );

        $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#transaction_date_range').val('');
            loadData();
        });

        $(document).ready(function() {
            loadData();

            $('select#account_type_filter').on('change', function() {
                loadData();
            });

            $('#print-btn').on('click', function() {
                printTable();
            });

            $('#excel-btn').on('click', function() {
                exportToExcel();
            });
        });



        function loadData() {
            var start = '';
            var end = '';
            if ($('#transaction_date_range').val()) {
                start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
            var account_type_filter = $('select#account_type_filter').val();

            $.ajax({
    url: '{{ action([\Modules\Test\Http\Controllers\YearlyIncomeExpenseController::class, 'index']) }}',
    method: 'GET',
    data: {
        start_date: start,
        end_date: end,
        account_type_filter: account_type_filter
    },
    success: function(response) {
        populateTable(response.data, start, end);
    },
    error: function(xhr, status, error) {
        console.error('Error loading data:', error);
        // Optionally, display an error message to the user
    }
});
        }

        function populateTable(data, start, end) {
            var tableBody = $('#sell_table tbody');
            tableBody.empty();

            var totalDebit = 0;
            var totals = {
                Jan: 0,
                Feb: 0,
                Mar: 0,
                Apr: 0,
                May: 0,
                Jun: 0,
                Jul: 0,
                Aug: 0,
                Sep: 0,
                Oct: 0,
                Nov: 0,
                Decem: 0
            };

            data.forEach(function(row) {
                var cleanTotalAmount = row.total_amount.replace(/[^\d.-]/g,
                    ''); // Remove non-digit characters except '-' and '.'
                var debit = parseFloat(cleanTotalAmount);

                if (!isNaN(debit)) {
                    totalDebit += debit;

                    // Sum up the monthly totals
                    totals.Jan += parseFloat(row.Jan) || 0;
                    totals.Feb += parseFloat(row.Feb) || 0;
                    totals.Mar += parseFloat(row.Mar) || 0;
                    totals.Apr += parseFloat(row.Apr) || 0;
                    totals.May += parseFloat(row.May) || 0;
                    totals.Jun += parseFloat(row.Jun) || 0;
                    totals.Jul += parseFloat(row.Jul) || 0;
                    totals.Aug += parseFloat(row.Aug) || 0;
                    totals.Sep += parseFloat(row.Sep) || 0;
                    totals.Oct += parseFloat(row.Oct) || 0;
                    totals.Nov += parseFloat(row.Nov) || 0;
                    totals.Decem += parseFloat(row.Decem) || 0;

                    var newRow = `<tr>
                        <td>${row.id}</td>
                        <td>${row.name}</td>
                        <td>${row.Jan || '0'}</td>
                        <td>${row.Feb || '0'}</td>
                        <td>${row.Mar || '0'}</td>
                        <td>${row.Apr || '0'}</td>
                        <td>${row.May || '0'}</td>
                        <td>${row.Jun || '0'}</td>
                        <td>${row.Jul || '0'}</td>
                        <td>${row.Aug || '0'}</td>
                        <td>${row.Sep || '0'}</td>
                        <td>${row.Oct || '0'}</td>
                        <td>${row.Nov || '0'}</td>
                        <td>${row.Decem || '0'}</td>
                        <td>${new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(debit)}</td>
                    </tr>`;

                    tableBody.append(newRow);
                } else {
                    console.warn('Invalid total_amount found:', row.total_amount);
                }
            });

            // Create a formatter function
            const currencyFormatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            });

            // Update the totals with formatted values
            $('.footer-total-Jan').text(currencyFormatter.format(totals.Jan));
            $('.footer-total-Feb').text(currencyFormatter.format(totals.Feb));
            $('.footer-total-Mar').text(currencyFormatter.format(totals.Mar));
            $('.footer-total-Apr').text(currencyFormatter.format(totals.Apr));
            $('.footer-total-May').text(currencyFormatter.format(totals.May));
            $('.footer-total-Jun').text(currencyFormatter.format(totals.Jun));
            $('.footer-total-Jul').text(currencyFormatter.format(totals.Jul));
            $('.footer-total-Aug').text(currencyFormatter.format(totals.Aug));
            $('.footer-total-Sep').text(currencyFormatter.format(totals.Sep));
            $('.footer-total-Oct').text(currencyFormatter.format(totals.Oct));
            $('.footer-total-Nov').text(currencyFormatter.format(totals.Nov));
            $('.footer-total-Decem').text(currencyFormatter.format(totals.Decem));
            $('.footer-total-debit').text(currencyFormatter.format(totalDebit));

        }


        function printTable() {
            window.print();
        }

        function exportToExcel() {
            var wb = XLSX.utils.table_to_book(document.querySelector('#sell_table'));
            XLSX.writeFile(wb, 'YearlyIncomeExpense.xlsx');
        }
    </script>
@endsection
