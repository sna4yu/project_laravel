@extends('layouts.app')
@section('title', __('businessbackup::lang.businessbackup'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('businessbackup::lang.businessbackup')
    </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-solid">
        <div class="box-body">
            {{-- @can('superadmin') --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="superadmin_business_table">
                        <thead>
                            <tr>
                                <th>
                                    @lang('superadmin::lang.registered_on')
                                </th>
                                <th>@lang( 'superadmin::lang.business_name' )</th>
                                <th>@lang('business.owner')</th>
                                <th>@lang('business.email')</th>
                                <th>@lang( 'superadmin::lang.business_contact_number' )</th>
                                <th>@lang( 'superadmin::lang.action' )</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            {{-- @endcan --}}
        </div>
    </div>
<input type="text" style="display:none" name="business_id" id="business_id" value="{{$business_id}}" />
</section>
<!-- /.content -->

@endsection

@section('javascript')

<script type="text/javascript">
    $(document).ready( function(){
        superadmin_business_table = $('#superadmin_business_table').DataTable({
            processing: true,
            serverSide: true,
            buttons: [],
            ajax: {
                url: "{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@index')}}",
                data: function(d) {
                    d.business_id = $('#business_id').val();
                },
            },
            aaSorting: [[0, 'desc']],
            columns: [
                { data: 'created_at', name: 'business.created_at' },
                { data: 'name', name: 'business.name' },
                { data: 'owner_name', name: 'owner_name', searchable: false},
                { data: 'owner_email', name: 'u.email' },
                { data: 'business_contact_number', name: 'business_contact_number' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

       
    });
    
</script>

@endsection