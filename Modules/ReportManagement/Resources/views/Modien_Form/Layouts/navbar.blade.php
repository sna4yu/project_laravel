<section class="no-print ">
    <nav class="navbar navbar-default box box-primary m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header ">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{action([\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienForm'])}}"><i class="fas fa-chart-line text-primary" ></i> {{__('Report Management')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    @if(auth()->user()->can('accounting.manage_accounts'))
                    <li @if(request()->segment(2) == 'Modien-people') class="active b" @endif><a href="{{action([\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienPeople'])}}">People</a></li>
                    @endif

                    @if(auth()->user()->can('accounting.view_journal'))
                    <li @if(request()->segment(2) == 'Modien-operations') class="active" @endif><a href="{{action([\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienOperations'])}}">Operations</a></li>
                    @endif
                    @if(auth()->user()->can('accounting.view_reports'))
                    <li @if(request()->segment(2) == 'Modien-financial') class="active" @endif><a href="{{action([\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienFinancial'])}}">Financial</a></li>
                    @endif

                    <li @if(request()->segment(2) == 'Modien-other') class="active" @endif><a href="{{action([\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienOther'])}}">Other</a></li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>