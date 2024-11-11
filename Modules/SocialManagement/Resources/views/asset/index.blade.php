@extends('layouts.app')
@section('title', __('socialmanagement::lang.assets'))
@section('content')
    @includeIf('socialmanagement::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <h1>
            @lang('socialmanagement::lang.assets')
        </h1>
    </section>
    <!-- Main content -->
    <section class="content no-print">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h5 class="box-title">
                    @lang('socialmanagement::lang.all_assets')
                </h5>
                @can('asset.create')
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-sm btn-primary btn-modal" data-href="{{ route('social.create') }}"
                            data-container=".asset_modal">
                            <i class="fa fa-plus"></i>
                            @lang('messages.add')
                        </button>
                    </div>
                @endcan
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="assets_table">
                        <thead>
                            <tr>
                            
                               <th>@lang('socialmanagement::lang.assign_to')</th>
                                <th>@lang('socialmanagement::lang.name')</th>
                                 <th>@lang('socialmanagement::lang.category_id')</th>
                                <th>@lang('socialmanagement::lang.link')</th>
                                <th>@lang('socialmanagement::lang.email')</th>
                                <th>@lang('socialmanagement::lang.asset_id')</th>
                                <th>@lang('socialmanagement::lang.password')</th>
                                <th>@lang('socialmanagement::lang.description')</th>
                                <th>@lang('socialmanagement::lang.create_by')</th>
                                <th>@lang('messages.action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade asset_modal" tabindex="-1" role="dialog" aria-labelledby="createAssetModalLabel"
        aria-hidden="true"></div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#assets_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ action([\Modules\SocialManagement\Http\Controllers\SocialManagementController::class, 'index']) }}",
                },
                columns: [
                    {
                     data: 'assign_to',
                        name: 'assign_to'
                    },
                    {
                   
                        data: 'name',
                        name: 'name'
                    },
                    {
                    
                         data: 'category_id',
                        name: 'category_id'
                    },
                    {
                   
                        data: 'link',
                        name: 'link'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                           data: 'asset_id',
                        name: 'asset_id'
                    },
                    {
                    
                        data: 'password',
                        name: 'password'
                    },
                    {
                 
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'create_by',
                        name: 'create_by'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            $(document).on('click', '.btn-modal', function(e) {
                e.preventDefault();
                var container = $(this).data('container');
                $.ajax({
                    url: $(this).data('href'),
                    dataType: 'html',
                    success: function(result) {
                        $(container).html(result).modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to load the form:', error);
                    }
                });
            });

            $(document).on('submit', '#add_asset_form, #edit_asset_form', function(e) {
                e.preventDefault();

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(result) {
                        if (result.success) {
                            $('.asset_modal').modal('hide');
                            table.ajax.reload();
                            toastr.success(result.msg);
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to save asset:', error);
                        toastr.error('Failed to save asset');
                    }
                });
            });

            $(document).on('click', '.delete-asset', function(e) {
                e.preventDefault();
                var url = $(this).data('href');
                if (confirm('Are you sure you want to delete this asset?')) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        dataType: 'json',
                        success: function(result) {
                            if (result.success) {
                                table.ajax.reload();
                                toastr.success(result.msg);
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Failed to delete asset:', error);
                            toastr.error('Failed to delete asset');
                        }
                    });
                }
            });
        });
    </script>
@endsection