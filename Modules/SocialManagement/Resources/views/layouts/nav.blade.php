<section class="no-print">
    <nav class="navbar navbar-default bg-white m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{action([\Modules\SocialManagement\Http\Controllers\SocialManagementController::class, 'dashboard'])}}">
                		<i class="fas fa fa-boxes"></i>
                	{{__('socialmanagement::lang.asset_management')}}
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li @if(request()->segment(2) == 'assets') class="active" @endif>
                        <a href="{{action([\Modules\SocialManagement\Http\Controllers\SocialManagementController::class, 'index'])}}">
                            @lang('socialmanagement::lang.assets')
                        </a>
                    </li>
                    <li @if(request()->segment(2) == 'social-categories') class="active" @endif>
                    	<a href="{{action([\Modules\SocialManagement\Http\Controllers\SocialManagementController::class, 'getCategories'])}}">
                    		@lang('socialmanagement::lang.asset_categories')
                    	</a>
                   	</li>
                    @if(auth()->user()->can('asset.asset_audit'))
                        <li @if(request()->segment(2) == 'asset_audit') class="active" @endif>
                            <a href="{{action([\Modules\SocialManagement\Http\Controllers\SocialAuditController::class, 'index'])}}">
                                @lang('socialmanagement::lang.social_audit')
                            </a>
                        </li>
                        <li @if(request()->segment(2) == 'asset_audit_create') class="active" @endif>
                            <a href="{{action([\Modules\SocialManagement\Http\Controllers\SocialAuditController::class, 'create'])}}">
                                @lang('socialmanagement::lang.social_audit_create')
                            </a>
                        </li>
                    @endif
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>