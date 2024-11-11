@extends('layouts.app')
@section('title', __('businessbackup::lang.businessbackup'))
@section('content')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
	<style>
		.jstree-default a { 
			white-space:normal !important; height: auto; 
		}
		.jstree-anchor {
			height: auto !important;
		}
		.jstree-default li > ins { 
			vertical-align:top; 
		}
		.jstree-leaf {
			height: auto;
		}
		.jstree-leaf a{
			height: auto !important;
		}
		.sheet-info {
			margin-left: 38px;
			margin-top: -8px;
		}
	</style>
@endsection
@include('businessbackup::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1>
    	@lang('businessbackup::lang.businessbackup')
    </h1>
</section>
<!-- Main content -->
<section class="content no-print">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">@lang('businessbackup::lang.my_businessbackups')</h3>
					<div class="box-tools pull-right">
						@can('create.businessbackup')
							<button type="button" class="btn btn-primary add_folder_btn btn-sm">
								<i class="fas fa-folder-plus"></i>
								@lang('businessbackup::lang.add_folder')
							</button>
						@endcan
					</div>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-4 mb-12 col-md-offset-4">
							<div class="input-group">
								<input type="input" class="form-control" id="spread_sheet_tree_search">
								<span class="input-group-addon">
									<i class="fas fa-search"></i>
								</span>
							</div>
						</div>
						<div class="col-md-4">
							<button class="btn btn-primary btn-sm" id="expand_all">@lang('accounting::lang.expand_all')</button>
							<button class="btn btn-primary btn-sm" id="collapse_all">@lang('accounting::lang.collapse_all')</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div id="businessbackups_tree">
								<ul>
									@foreach($folders as $folder)	
									<li>{{$folder->name}}
										@can('create.businessbackup')
										<span class="tree-actions">
											<a class="btn btn-xs btn-default add-sheet" 
												title="@lang('businessbackup::lang.create_businessbackup')"
												href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@create')}}?folder_id={{$folder->id}}">
												<i class="fas fa-plus text-success"></i></a>

												<a class="btn btn-xs btn-default edit_folder" 
												title="@lang('businessbackup::lang.edit_folder')"
												href="#" data-name="{{$folder->name}}" data-id="{{$folder->id}}">
												<i class="fas fa-edit text-primary"></i></a>
										</span>
										@endcan
										<ul>
											@foreach($businessbackups->where('folder_id', $folder->id) as $businessbackup)
												<li data-jstree='{ "icon" : "fas fa-file-excel" }'>
													{{$businessbackup->name}}
													<span class="tree-actions">
														<a class="btn btn-xs btn-default text-success view-sheet" 
															title="@lang('messages.view')"
															href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@show', [$businessbackup->id])}}" target="_blank">
															<i class="fas fa-eye text-primary"></i></a>
														@if(auth()->user()->id == $businessbackup->created_by)
															<a 
																class="btn btn-modal btn-xs btn-default delete-sheet" title="@lang('messages.delete')"
																data-href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@destroy', [$businessbackup->id])}}"
																href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@destroy', [$businessbackup->id])}}">
																<i class="fas fa-trash-alt text-danger"></i>
															</a>
															<a 
																data-href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@getShareBusinessBackup', ['id' => $businessbackup->id])}}" 
																title="@lang('businessbackup::lang.share')" 
																class="btn btn-default btn-xs share_excel">
																<i class="fa fa-share text-success"></i>
															</a>

															<a 
																href="#" 
																title="@lang('businessbackup::lang.move_to_another_folder')" 
																class="btn btn-default btn-xs move_to_another_folder"
																data-businessbackup_id="{{$businessbackup->id}}">
																<i class="fas fa-external-link-alt text-warning"></i>
															</a>
														@endif
													</span>
													<div class="sheet-info">
														<small class="text-muted"><strong><i class="fas fa-clock" title="@lang('lang_v1.updated_at')"></i></strong> 
															{{@format_datetime($businessbackup->updated_at)}}
															<strong><i class="fas fa-user" title="@lang('business.created_by')"></i></strong> {{$businessbackup->createdBy->user_full_name}}
														</small>
													</div>
													@if(count($businessbackup->shares) > 0)
														<div class="sheet-info">
															<small class="text-muted"><strong><i class="fas fa-share-alt" title="@lang('businessbackup::lang.shared_with')"></i></strong></small>
															@if(!empty($businessbackup->shered_users))
																<small class="text-muted"><strong>@lang('user.users')</strong> - {{implode(', ', $businessbackup->shered_users)}}</small>
															@endif
															@if(!empty($businessbackup->shared_roles))
																<small class="text-muted"><strong>@lang('user.roles')</strong> - {{implode(', ', $businessbackup->shared_roles)}}</small>
															@endif
															@if(!empty($businessbackup->shared_todos))
																<small class="text-muted"><strong>@lang('businessbackup::lang.todos')</strong> - {{implode(', ', $businessbackup->shared_todos)}}</small>
															@endif
														</div>
													@endif
												</li>
											@endforeach
										</ul>
									</li>									
									@endforeach
									<li>@lang('businessbackup::lang.untitled')
										<span class="tree-actions">
											<a class="btn btn-xs btn-default add-sheet" 
												title="@lang('businessbackup::lang.create_businessbackup')"
												href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@create')}}">
												<i class="fas fa-plus text-success"></i></a>
										</span>
										<ul>
											@foreach($businessbackups->where('folder_id', null) as $businessbackup)
												<li data-jstree='{ "icon" : "fas fa-file-excel" }'>
													{{$businessbackup->name}}
													<span class="tree-actions">
														<a class="btn btn-xs btn-default text-success view-sheet" 
															title="@lang('messages.view')"
															href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@show', [$businessbackup->id])}}" target="_blank">
															<i class="fas fa-eye text-primary"></i></a>
														@if(auth()->user()->id == $businessbackup->created_by)
															<a 
																class="btn btn-modal btn-xs btn-default delete-sheet" title="@lang('messages.delete')"
																data-href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@destroy', [$businessbackup->id])}}"
																href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@destroy', [$businessbackup->id])}}">
																<i class="fas fa-trash-alt text-danger"></i>
															</a>
															<a 
																data-href="{{action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@getShareBusinessBackup', ['id' => $businessbackup->id])}}" 
																title="@lang('businessbackup::lang.share')" 
																class="btn btn-default btn-xs share_excel">
																<i class="fa fa-share text-success"></i>
															</a>

															<a 
																href="#" 
																title="@lang('businessbackup::lang.move_to_another_folder')" 
																class="btn btn-default btn-xs move_to_another_folder"
																data-businessbackup_id="{{$businessbackup->id}}">
																<i class="fas fa-external-link-alt text-warning"></i>
															</a>
														@endif
													</span>
													<div class="sheet-info">
														<small class="text-muted"><strong><i class="fas fa-clock" title="@lang('lang_v1.updated_at')"></i></strong> 
															{{@format_datetime($businessbackup->updated_at)}}
															<strong><i class="fas fa-user" title="@lang('business.created_by')"></i></strong> {{$businessbackup->createdBy->user_full_name}}
														</small>
													</div>
													@if(count($businessbackup->shares) > 0)
														<div class="sheet-info">
															<small class="text-muted"><strong><i class="fas fa-share-alt" title="@lang('businessbackup::lang.shared_with')"></i></strong></small>
															@if(!empty($businessbackup->shered_users))
																<small class="text-muted"><strong>@lang('user.users')</strong> - {{implode(', ', $businessbackup->shered_users)}}</small>
															@endif
															@if(!empty($businessbackup->shared_roles))
																<small class="text-muted"><strong>@lang('user.roles')</strong> - {{implode(', ', $businessbackup->shared_roles)}}</small>
															@endif
															@if(!empty($businessbackup->shared_todos))
																<small class="text-muted"><strong>@lang('businessbackup::lang.todos')</strong> - {{implode(', ', $businessbackup->shared_todos)}}</small>
															@endif
														</div>
													@endif
												</li>
											@endforeach
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="share_excel_modal" tabindex="-1" role="dialog"></div>
	<div class="modal fade" id="add_folder_modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
  			<div class="modal-content">
    			{!! Form::open(['action' => '\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@addFolder', 'method' => 'post' ]) !!}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">@lang('businessbackup::lang.add_folder')</h4>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" id="folder_id" name="folder_id">
							{!! Form::label('folder_name', __('lang_v1.name') . ':*') !!}
							{!! Form::text('name', null, ['class' => 'form-control', 'required', 'id' => 'folder_name']); !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
					</div>

				{!! Form::close() !!}

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="move_to_folder_modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
  			<div class="modal-content">
    			{!! Form::open(['action' => '\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@moveToFolder',
					 'method' => 'post' ]) !!}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">@lang('businessbackup::lang.move_to')</h4>
					</div>

					<div class="modal-body">
						<input type="hidden" id="businessbackup_id" name="businessbackup_id">
						<div class="form-group">
							{!! Form::label('move_to_folder', __('businessbackup::lang.folder') . ':*') !!}
							{!! Form::select('move_to_folder', $folders->pluck('name', 'id'), null, 
								['class' => 'form-control', 'required', 'id' => 'move_to_folder', 
								'style' => 'width: 100%;', 'placeholder' => __('messages.please_select')]); !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">@lang( 'businessbackup::lang.move' )</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
					</div>

				{!! Form::close() !!}

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
		
</section>
@stop
@section('javascript')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
	<script type="text/javascript">
		$(document).ready( function(){
			$('#move_to_folder').select2({
				dropdownParent: $('#move_to_folder_modal')
			});
		});
		$(document).on('click', '.add_folder_btn', function(){
			$('#add_folder_modal').modal('show');
		})

		$(document).on('click', '.edit_folder', function(){
			$('#folder_id').val($(this).attr('data-id'));
			$('#folder_name').val($(this).attr('data-name'));
			$('#add_folder_modal').modal('show');
		})

		$(document).on('click', '.move_to_another_folder', function(){
			$('#businessbackup_id').val($(this).attr('data-businessbackup_id'));
			$('#move_to_folder_modal').modal('show');
		})

		$(document).on('hidden.bs.modal', '#add_folder_modal', function (e) {
			$('#folder_id').val('');
			$('#folder_name').val('');
		});
		$(function () {
			$.jstree.defaults.core.themes.variant = "large";
			$('#businessbackups_tree').jstree({
				"core" : {
					"themes" : {
						"responsive": true
					}
				},
				"types" : {
					"default" : {
						"icon" : "fa fa-folder"
					},
					"file" : {
						"icon" : "fa fa-file"
					},
				},
				"plugins": ["types", "search"]
			});
			$('#businessbackups_tree').jstree("open_all");

			var to = false;
			$('#spread_sheet_tree_search').keyup(function () {
				if(to) { clearTimeout(to); }
				to = setTimeout(function () {
				var v = $('#spread_sheet_tree_search').val();
				$('#businessbackups_tree').jstree(true).search(v);
				}, 250);
			});

			$(document).on('click', '#expand_all', function(e){
				$('#businessbackups_tree').jstree("open_all");
			})
			$(document).on('click', '#collapse_all', function(e){
				$('#businessbackups_tree').jstree("close_all");
			})

			$(document).on('click', '.delete-sheet', function (e) {
				e.preventDefault();
			    var url = $(this).data('href');
			    swal({
			      title: LANG.sure,
			      icon: "warning",
			      buttons: true,
			      dangerMode: true,
			    }).then((confirmed) => {
			        if (confirmed) {
			            $.ajax({
			                method:'DELETE',
			                dataType: 'json',
			                url: url,
			                success: function(result){
			                    if (result.success) {
			                        toastr.success(result.msg);
			                        location.reload();
			                    } else {
			                        toastr.error(result.msg);
			                    }
			                }
			            });
			        }
			    });
			});

			$(document).on('click', '.share_excel', function () {
				var url = $(this).data('href');
				$.ajax({
	                method:'GET',
	                dataType: 'html',
	                url: url,
	                success: function(result){
	                    $("#share_excel_modal").html(result).modal("show");
	                }
	            });
			});

			$(document).on('click', 'a.view-sheet', function(e) {
				window.open($(this).attr('href'));
			});

			$(document).on('click', 'a.add-sheet', function(e) {
				window.location.href = $(this).attr('href');
			});

			$('#share_excel_modal').on('shown.bs.modal', function (e) {
			    $(".select2").select2();
			    //form validation
			    $("form#share_businessbackup").validate();
			});

			$(document).on('submit', 'form#share_businessbackup', function(e){
			    e.preventDefault();
			    var url = $('form#share_businessbackup').attr('action');
			    var method = $('form#share_businessbackup').attr('method');
			    var data = $('form#share_businessbackup').serialize();
			    var ladda = Ladda.create(document.querySelector('.ladda-button'));
			    ladda.start();
			    $.ajax({
			        method: method,
			        dataType: "json",
			        url: url,
			        data:data,
			        success: function(result){
			            ladda.stop();
			            if (result.success) {
			                toastr.success(result.msg);
			                $('#share_excel_modal').modal("hide");
			                location.reload();
			            } else {
			                toastr.error(result.msg);
			            }
			        }
			    });
			});
		})
	</script>
@endsection