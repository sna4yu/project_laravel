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
    
  @if (session('notification') || !empty($notification))
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                @if(!empty($notification['msg']))
                    {{$notification['msg']}}
                @elseif(session('notification.msg'))
                    {{ session('notification.msg') }}
                @endif
              </div>
          </div>  
      </div>     
  @endif

  <div class="row">
    <div class="col-sm-12">
      @component('components.widget', ['class' => 'box-primary'])
        @slot('tool')
          <div class="box-tools">
            <a id="create-new-backup-button" href="{{ url('businessbackup/backup/create') }}" class="btn btn-primary pull-right"
                     style="margin-bottom:2em;"><i
                          class="fa fa-plus"></i> @lang('lang_v1.create_new_backup')
            </a>
          </div>
        @endslot
        @if (count($backups))
                <table class="table table-striped table-bordered">
                  <thead>
                  <tr>
                      <th>@lang('lang_v1.file')</th>
                      <th>@lang('lang_v1.size')</th>
                      <th>@lang('lang_v1.date')</th>
                      <th>@lang('lang_v1.age')</th>
                      <th>@lang('messages.actions')</th>
                  </tr>
                  </thead>
                    <tbody>
                    @foreach($backups as $backup)
                        <tr>
                            <td>{{ $backup['file_name'] }}</td>
                            <td>{{ humanFilesize($backup['file_size']) }}</td>
                            <td>
                                {{ Carbon::createFromTimestamp($backup['last_modified'])->toDateTimeString() }}
                            </td>
                            <td>
                                {{ Carbon::createFromTimestamp($backup['last_modified'])->diffForHumans(Carbon::now()) }}
                            </td>
                            <td>
                              <a class="btn btn-xs btn-success"
                                   href="{{route('businessbackup.download', [$backup['file_name']])}}"><i
                                        class="fa fa-cloud-download"></i> @lang('lang_v1.download')</a>
                                <a class="btn btn-xs btn-danger link_confirmation" data-button-type="delete"
                                   href="{{route('businessbackup.delete', [$backup['file_name']])}}"><i class="fa fa-trash-o"></i>
                                    @lang('messages.delete')</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
              </table>
            @else
                <div class="well">
                    <h4>There are no backups</h4>
                </div>
            @endif
            
      @endcomponent
    </div>
  </div>
</section>
@endsection
