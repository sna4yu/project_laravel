@extends('layouts.app')

@section('title', ('Income Report'))

@section('content')

@include('accounting::layouts.nav')

<!-- Content Header (Page header) -->
<style>
    .GFG {
    background-color: white;
    border: 1px solid black;
    color: rgb(0, 0, 0);
    padding: 10px;
    border-radius: 30%;
    cursor: pointer;
    width: 80px;
    height: 40px;
    transition: background-color 0.3s, border-color 0.3s; /* adds transition effect */
    }

    .GFG:hover {
    background-color: #7793f0; /* changes background color on hover */
    border-color: #4b90ff; /* changes border color on hover */
    }

    .GFG:active {
    transform: scale(0.9); /* scales the button down on click */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* adds a box shadow on click */
    }
</style>

<section class="content-header">
    <h1>@lang( 'Income Report' )</h1>
</section>

<section class="content">

    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('date_range_filter', __('report.date_range') . ':') !!}
            {!! Form::text('date_range_filter', null, 
                ['placeholder' => __('lang_v1.select_a_date_range'), 
                'class' => 'form-control', 'id' => 'date_range_filter']) !!}
        </div>
    </div>

    <button onclick="window.location.href='{{ route('reportmanagement.index') }}'" class="GFG">ទំព័រដើម</button>
    <button onclick="window.open('https://www.google.com/', '_blank')" class="GFG">ជំនួយ</button>

    <div class="col-md-10 col-md-offset-1">
        <div class="box box-warning">
            <div class="box-header with-border text-center">
                <h2 class="box-title">@lang( 'របាយការណ៍ប្រកាសពន្ធលើចំណូលប្រចាំខែ' )</h2>
                <p id="date-range-display"></p>
            </div>

            <div class="box-body">
                <table id="data-table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>លរ</th>
                            <th>ថ្ងៃខែលក់</th>
                            <th>លេខវិក័យប័ត្រ</th>
                            <th>ឈ្មោះអតិថិជន</th>
                            <th>ទឹកប្រាក់សរុបដុល្លារ</th>
                            <th>ទឹកប្រាក់សរុបលុយរៀល</th>
                            <th>ទឹកប្រាក់សរុបមិនគិតថ្លៃពន្ធ</th>
                            <th>ពន្ធដា</th>
                            <th>អត្រាប្តូរប្រាក់</th>
                            <th>កំណត់ចំណាំ</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-data">
                        @foreach($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaction->transaction_date }}</td>
                                <td>{{ $transaction->invoice_no }}</td>
                                <td>{{ $transaction->customer->name }}</td>
                                <td>{{ $transaction->total_quantity }}</td>
                                <td>{{ $transaction->total_discount }}</td>
                                <td>{{ $transaction->total_excluding_tax }}</td>
                                <td>{{ $transaction->total_including_tax }}</td>
                                <td>{{ $transaction->transaction_note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        let date_range = '{{ !empty($date_range) ? $date_range : date("Y-m-d") . " - " . date("Y-m-d") }}';
        $('#date_range_filter').val(date_range);
        $('#date-range-display').text(date_range);

        $('#date_range_filter').daterangepicker({
            "ranges": {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Apply",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Su",
                    "Mo",
                    "Tu",
                    "We",
                    "Th",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December"
                ],
                "firstDay": 1
            },
            "startDate": "{{ date('Y-m-d') }}",
            "endDate": "{{ date('Y-m-d') }}",
            "opens": "left"
        }, function(start, end, label) {
            $('#date_range_filter').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            $('#date-range-display').text(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));

            let url = "{{ action('IncomeReportController@index') }}";
            let params = {
                'date_range': start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD')
            };
            loadIncomeReport(url, params);
        });

        function loadIncomeReport(url, params) {
            $.get(url, params, function(data) {
                $('#transaction-data').html(data);
            });
        }
    });
</script>
