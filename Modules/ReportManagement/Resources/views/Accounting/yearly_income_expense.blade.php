@extends('layouts.app')

@section('title', __('Yearly Income & Expense'))

@section('content')
    @include('reportmanagement::Layouts.navbar')
    {{-- @include('accounting::layouts.nav') --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <section class="content-header">
        <h1>Yearly Income and Expense 2024</h1>
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
        @endcomponent

        @component('components.widget', ['class' => 'box-warning'])
            <div class="box-header with-border text-center">
                <h1 class="box-title"><b>Yearly Income and Expense Report</b></h1>
            </div>
                <table class="table table-bordered table-striped ajax_view" id="sell_table">
                    <thead class="bg-yellow-400">
                        <tr>
                            <th class="center-text">ID</th>
                            <th class="center-text">Name</th>
                            <th class="center-text">January</th>
                            <th class="center-text">February</th>
                            <th class="center-text">March</th>
                            <th class="center-text">April</th>
                            <th class="center-text">May</th>
                            <th class="center-text">June</th>
                            <th class="center-text">July</th>
                            <th class="center-text">August</th>
                            <th class="center-text">September</th>
                            <th class="center-text">October</th>
                            <th class="center-text">November</th>
                            <th class="center-text">December</th>
                            <th class="center-text">Total</th>
                        </tr>
                    </thead>
                </table>
        @endcomponent
    </section>
@endsection

@section('javascript')
    <script type="text/javascript">
    $('#account_type_filter').change(function() {
                sell_table.draw();
            });
            
            // Handle name filter input change
            $('#filterInput').on('keyup', function() {
                sell_table.search(this.value).draw();
            });
        $(document).ready(function() {
            sell_table = $('#sell_table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    url: '{{ action([\Modules\ReportManagement\Http\Controllers\YearlyIncomeExpenseController::class, 'index']) }}',
                    data: function(d) {
                        d.account_type_filter = $('#account_type_filter').val(); // Add this line
                        d.name_filter = $('#filterInput').val(); // Add name filter
                    }
                },
                "ordering": false,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'Jan',
                        name: 'Jan',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Feb',
                        name: 'Feb',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Mar',
                        name: 'Mar',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Apr',
                        name: 'Apr',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'May',
                        name: 'May',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Jun',
                        name: 'Jun',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Jul',
                        name: 'Jul',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Aug',
                        name: 'Aug',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Sep',
                        name: 'Sep',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Oct',
                        name: 'Oct',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Nov',
                        name: 'Nov',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'Decem',
                        name: 'Decem',
                        orderable: false,
                        "searchable": false
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount',
                        orderable: false,
                        "searchable": false
                    }
                ]

            });
            
        });
    </script>
    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection
