@extends('layouts.app')

@section('title', ('Home'))

@section('content')

@include('reportmanagement::layouts.navbar')

<section class="content-header">
    <h1>@lang('essentials::lang.payroll')
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#payroll_tab" data-toggle="tab" aria-expanded="true">
                            <i class="fas fa-coins" aria-hidden="true"></i>
                            @lang('essentials::lang.all_payrolls')
                        </a>
                    </li>
                    @can('essentials.view_all_payroll')
                        <li>
                            <a href="#payroll_group_tab" data-toggle="tab" aria-expanded="true">
                                <i class="fas fa-layer-group" aria-hidden="true"></i>
                                @lang('essentials::lang.all_payroll_groups')
                            </a>
                        </li>
                    @endcan
                    @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                        <li>
                            <a href="#pay_component_tab" data-toggle="tab" aria-expanded="true">
                                <i class="fab fa-gg-circle" aria-hidden="true"></i>
                                @lang( 'essentials::lang.pay_components' )
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->can('essentials.pay_salary'))
                        <li>
                            <a href="#pay_salary_tab" data-toggle="tab" aria-expanded="true">
                                <i class="fas fa-money-check-alt" aria-hidden="true"></i>
                                @lang( 'essentials::lang.pay_salary' )
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="payroll_tab">
                        <div class="row">
                            <div class="col-md-12">
                                @component('components.filters', ['title' => __('report.filters'), 'class' => 'box-solid', 'closed' => true])
                                    @can('essentials.view_all_payroll')
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('user_id_filter', __('essentials::lang.employee') . ':') !!}
                                                {!! Form::select('user_id_filter', $employees, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('location_id_filter',  __('purchase.business_location') . ':') !!}

                                                {!! Form::select('location_id_filter', $locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('department_id', __('essentials::lang.department') . ':') !!}
                                                {!! Form::select('department_id', $departments, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                {!! Form::label('designation_id', __('essentials::lang.designation') . ':') !!}
                                                {!! Form::select('designation_id', $designations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('month_year_filter', __( 'essentials::lang.month_year' ) . ':') !!}
                                            <div class="input-group">
                                                {!! Form::text('month_year_filter', null, ['class' => 'form-control', 'placeholder' => __( 'essentials::lang.month_year' ) ]); !!}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                @endcomponent
                            </div>
                        </div>
                        <div class="row">
                            @can('essentials.create_payroll')
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#payroll_modal">
                                        <i class="fa fa-plus"></i>
                                        @lang( 'messages.add' )
                                    </button>
                                </div>
                                <br><br><br>
                            @endcan
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="payrolls_table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>@lang( 'essentials::lang.employee' )</th>
                                                <th>@lang( 'essentials::lang.department' )</th>
                                                <th>@lang( 'essentials::lang.designation' )</th>
                                                <th>@lang( 'essentials::lang.month_year' )</th>
                                                <th>@lang( 'purchase.ref_no' )</th>
                                                <th>@lang( 'sale.total_amount' )</th>
                                                <th>@lang( 'sale.payment_status' )</th>
                                                <th>@lang( 'messages.action' )</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    @can('essentials.view_all_payroll')
                        <div class="tab-pane" id="payroll_group_tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="payroll_group_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang('essentials::lang.name')</th>
                                                    <th>@lang('sale.status')</th>
                                                    <th>@lang( 'sale.payment_status' )</th>
                                                    <th>@lang('essentials::lang.total_gross_amount')</th>
                                                    <th>@lang('lang_v1.added_by')</th>
                                                    <th>@lang('business.location')</th>
                                                    <th>@lang('lang_v1.created_at')</th>
                                                    <th>@lang( 'messages.action' )</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                        <div class="tab-pane" id="pay_component_tab">
                            <div class="row">
                                @can('essentials.add_allowance_and_deduction')
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-modal pull-right" data-href="{{action([\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController::class, 'create'])}}" data-container="#add_allowance_deduction_modal">
                                                <i class="fa fa-plus"></i> @lang( 'messages.add' )
                                        </button>
                                    </div><br><br><br>
                                @endcan
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="ad_pc_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang( 'lang_v1.description' )</th>
                                                    <th>@lang( 'lang_v1.type' )</th>
                                                    <th>@lang( 'sale.amount' )</th>
                                                    <th>@lang( 'essentials::lang.applicable_date' )</th>
                                                    <th>@lang( 'essentials::lang.employee' )</th>
                                                    <th>@lang( 'messages.action' )</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="user_leave_summary"></div>
                        </div>
                    @endif
                    @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                        <div class="tab-pane" id="pay_salary_tab">
                            <!-- Toggle Filters Button -->
                            <div class="row ">
                                <div class="col-md-12">
                                    <button id="toggle-filters" class="btn btn-outline-light btn-lg btn-block text-left " style="background-color: white; color: #429ed1; text-align: left; ">
                                    <i class="fas fa-filter"></i>@lang( 'essentials::lang.Filters' )
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Filters Section -->
                            <div id="filters" style="display: none; margin-top: 20px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('month_year_filters', __( 'essentials::lang.month_year' ) . ':') !!}
                                        <div class="input-group">
                                            {!! Form::text('month_year_filters', null, ['class' => 'form-control', 'placeholder' => __( 'essentials::lang.month_year' ) ]); !!}
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>

                                @can('essentials.view_all_payroll')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('location_id_filters',  __('purchase.business_location') . ':') !!}
                                            {!! Form::select('location_id_filters', $locations, null, ['class' => 'form-control select2', 'id' => 'location_id_filters', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
                                        </div>
                                    </div>
                                @endcan
                            </div> <br> <br>
                            <div class="row">
                                @can('essentials.add_allowance_and_deduction')
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary btn-modal pull-right" data-href="{{action([\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController::class, 'create'])}}" data-container="#add_pay_salary">
                                                <i class="fa fa-plus"></i> @lang( 'messages.add' )
                                        </button>
                                    </div>
                                @endcan
                                <br><br><br>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="paysalary_table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>@lang( 'essentials::lang.id_s' )</th>
                                                    <th>@lang( 'essentials::lang.id_card' )</th>
                                                    <th>@lang( 'essentials::lang.employee_name' )</th>
                                                    <th>@lang( 'essentials::lang.position' )</th>
                                                    <th>@lang( 'essentials::lang.salary_dolla' )</th>
                                                    <th>@lang( 'essentials::lang.salary_kh' )</th>
                                                    <th>@lang( 'essentials::lang.savings_2_employee' )</th>
                                                    <th>@lang( 'essentials::lang.net_salarry' )</th>
                                                    <th>@lang( 'essentials::lang.confederation' )</th>
                                                    <th>@lang( 'essentials::lang.child_allowance' )</th>
                                                    <th>@lang( 'essentials::lang.taxable_salary' )</th>
                                                    <th>@lang( 'essentials::lang.rat' )</th>
                                                    <th>@lang( 'essentials::lang.salary_tax' )</th>
                                                    <th>@lang( 'essentials::lang.salary_em' )​​</th>
                                                    <th>@lang( 'essentials::lang.hk_contribution' )​</th>
                                                    <th>@lang( 'essentials::lang.sp_contribution' )</th>
                                                    <th>@lang( 'essentials::lang.savings_2_employee' )</th>
                                                    <th>@lang( 'essentials::lang.savings_2_company' )</th>
                                                    <th>@lang( 'essentials::lang.total_contribution' )</th>
                                                    <th>@lang( 'essentials::lang.savings_2_from_em' )</th>
                                                    <th>@lang( 'messages.action' )</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr class="bg-gray font-17 footer-total text-center">
                                                    <td colspan="4"><strong>@lang('sale.total'):</strong></td>
                                                    <td class="footer_total_salary_dolla"></td>
                                                    <td class="footer_total_salary_kh"></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @can('essentials.create_payroll')
        @includeIf('essentials::payroll.payroll_modal')
    @endcan
    <div class="modal fade" id="add_allowance_deduction_modal" tabindex="-1" role="dialog"
 aria-labelledby="gridSystemModalLabel"></div>
</section>
<!-- /.content -->
<!-- /.content -->
<div class="modal fade payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

<div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready( function(){
            payrolls_table = $('#payrolls_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'index'])}}",
                    data: function (d) {
                        if ($('#user_id_filter').length) {
                            d.user_id = $('#user_id_filter').val();
                        }
                        if ($('#location_id_filter').length) {
                            d.location_id = $('#location_id_filter').val();
                        }
                        d.month_year = $('#month_year_filter').val();
                        if ($('#department_id').length) {
                            d.department_id = $('#department_id').val();
                        }
                        if ($('#designation_id').length) {
                            d.designation_id = $('#designation_id').val();
                        }
                    },
                },
                columnDefs: [
                    {
                        targets: 7,
                        orderable: false,
                        searchable: false,
                    },
                ],
                aaSorting: [[4, 'desc']],
                columns: [
                    { data: 'user', name: 'user' },
                    { data: 'department', name: 'dept.name' },
                    { data: 'designation', name: 'dsgn.name' },
                    { data: 'transaction_date', name: 'transaction_date'},
                    { data: 'ref_no', name: 'ref_no'},
                    { data: 'final_total', name: 'final_total'},
                    { data: 'payment_status', name: 'payment_status'},
                    { data: 'action', name: 'action' },
                ],
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#payrolls_table'));
                },
            });

            $(document).on('change', '#user_id_filter, #month_year_filter, #department_id, #designation_id, #location_id_filter', function() {
                payrolls_table.ajax.reload();
            });

            if ($('#add_payroll_step1').length) {
                $('#add_payroll_step1').validate();
                $('#employee_id').select2({
                    dropdownParent: $('#payroll_modal')
                });
            }

            $('div.view_modal').on('shown.bs.modal', function(e) {
                __currency_convert_recursively($('.view_modal'));
            });

            $('#month_year, #month_year_filter').datepicker({
                autoclose: true,
                format: 'mm/yyyy',
                minViewMode: "months"
            });

            //pay components
            @if(auth()->user()->can('essentials.view_allowance_and_deduction') || auth()->user()->can('essentials.add_allowance_and_deduction'))
                $('#add_allowance_deduction_modal').on('shown.bs.modal', function(e) {
                    var $p = $(this);
                    $('#add_allowance_deduction_modal .select2').select2({dropdownParent:$p});
                    $('#add_allowance_deduction_modal #applicable_date').datepicker();
                    
                });

                $(document).on('submit', 'form#add_allowance_form', function(e) {
                    e.preventDefault();
                    $(this).find('button[type="submit"]').attr('disabled', true);
                    var data = $(this).serialize();

                    $.ajax({
                        method: $(this).attr('method'),
                        url: $(this).attr('action'),
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            if (result.success == true) {
                                $('div#add_allowance_deduction_modal').modal('hide');
                                toastr.success(result.msg);
                                ad_pc_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                });
                
                ad_pc_table = $('#ad_pc_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{action([\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController::class, 'index'])}}",
                    columns: [
                        { data: 'description', name: 'description' },
                        { data: 'type', name: 'type' },
                        { data: 'amount', name: 'amount' },
                        { data: 'applicable_date', name: 'applicable_date' },
                        { data: 'employees', searchable: false, orderable: false },
                        { data: 'action', name: 'action' }
                    ],
                    fnDrawCallback: function(oSettings) {
                        __currency_convert_recursively($('#ad_pc_table'));
                    },
                });

                $(document).on('click', '.delete-allowance', function(e) {
                    e.preventDefault();
                    swal({
                        title: LANG.sure,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then(willDelete => {
                        if (willDelete) {
                            var href = $(this).data('href');
                            var data = $(this).serialize();

                            $.ajax({
                                method: 'DELETE',
                                url: href,
                                dataType: 'json',
                                data: data,
                                success: function(result) {
                                    if (result.success == true) {
                                        toastr.success(result.msg);
                                        ad_pc_table.ajax.reload();
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                },
                            });
                        }
                    });
                });
            @endif
            //payroll groups
            @can('essentials.view_all_payroll')
                payroll_group_table = $('#payroll_group_table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'payrollGroupDatatable'])}}",
                        aaSorting: [[6, 'desc']],
                        columns: [
                            { data: 'name', name: 'essentials_payroll_groups.name' },
                            { data: 'status', name: 'essentials_payroll_groups.status' },
                            { data: 'payment_status', name: 'essentials_payroll_groups.payment_status' },
                            { data: 'gross_total', name: 'essentials_payroll_groups.gross_total' },
                            { data: 'added_by', name: 'added_by' },
                            { data: 'location_name', name: 'BL.name' },
                            { data: 'created_at', name: 'essentials_payroll_groups.created_at', searchable: false},
                            { data: 'action', name: 'action', searchable: false, orderable: false}
                        ]
                    });
            @endcan
            @can('essentials.delete_payroll')
                $(document).on('click', '.delete-payroll', function(e) {
                    e.preventDefault();
                    swal({
                        title: LANG.sure,
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then(willDelete => {
                        if (willDelete) {
                            var href = $(this).attr('href');
                            var data = $(this).serialize();

                            $.ajax({
                                method: 'DELETE',
                                url: href,
                                dataType: 'json',
                                data: data,
                                success: function(result) {
                                    if (result.success == true) {
                                        toastr.success(result.msg);
                                        payroll_group_table.ajax.reload();
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                },
                            });
                        }
                    });
                });
            @endcan

            $(document).on('change', '#primary_work_location', function () {
                let location_id = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'getEmployeesBasedOnLocation'])}}",
                    dataType: 'json',
                    data: {
                        'location_id' : location_id
                    },
                    success: function(result) {
                        if (result.success == true) {
                            $('select#employee_ids').html('');
                            $('select#employee_ids').html(result.employees_html);
                        }
                    }
                });
            });
        });
        $(document).ready(function() {
            // Toggle Filters Visibility
            $('#toggle-filters').click(function() {
                $('#filters').toggle();
            });

            // Initialize DataTable
            var paysalary_table = $('#paysalary_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{action([\Modules\Essentials\Http\Controllers\PayrollController::class, 'payEmployee'])}}",
                    data: function (d) {
                        d.location_id_filter = $('#location_id_filters').val();
                        d.month_year_filter = $('#month_year_filters').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'id_proof_number', name: 'id_proof_number' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'user_type', name: 'user_type' },
                    { data: 'salary_dolla', name: 'salary_dolla' },
                    { data: 'essentials_salary', name: 'essentials_salary' },
                    { data: 'id', name: 'id' },
                    { data: 'essentials_salary', name: 'essentials_salary' },
                    { data: 'id', name: 'id' },
                    { data: 'family_number', name: 'family_number' },
                    { data: 'essentials_salary', name: 'essentials_salary' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'essentials_salary', name: 'essentials_salary' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                    { data: 'id', name: 'id' },
                ],
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#paysalary_table'));
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var intVal = function(i) {
                        return typeof i === 'string' ? i.replace(/[^\d.-]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };

                    // Total over this page
                    var totalSalaryDolla = api.column(4, { page: 'current' }).data().reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    var totalSalaryKh = api.column(5, { page: 'current' }).data().reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer with totals
                    $(api.column(4).footer()).html(`$ ${totalSalaryDolla.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`);
                    $(api.column(5).footer()).html(`${totalSalaryKh.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}៛`);

                    // Update footer text
                    $('.footer_total_salary_dolla').html(`$${totalSalaryDolla.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`);
                    $('.footer_total_salary_kh').html(`${totalSalaryKh.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}៛`);
                }
            });

            // Reload DataTable on filter change
            $('#location_id_filters, #month_year_filters').change(function() {
                paysalary_table.ajax.reload();
            });

            // Initialize Datepicker
            $('#month_year, #month_year_filters').datepicker({
                autoclose: true,
                format: 'mm/yyyy',
                minViewMode: "months"
            });
        });



</script>
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
@endsection
