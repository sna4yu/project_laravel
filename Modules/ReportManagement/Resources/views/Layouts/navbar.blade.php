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
                <a class="navbar-brand" href="{{action([\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'index'])}}">
                    <i class="fas fa-chart-line" style="color: blue; font-size: 20px;"></i> {{__('Report Management')}}
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                    <!-- People -->
                    <li @if(request()->segment(2) == 'people') class="active" @endif>
                        <a  href="{{action([\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'people'])}}">
                            {{__('People')}}
                        </a>
                    </li>

                    <!-- Operation -->
                    <li @if(request()->segment(2) == 'operation') class="active" @endif>
                        <a  href="{{action([\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'operation'])}}">
                            {{__('Operation')}}
                        </a>
                    </li>

                    <!-- Financial -->
                    <li @if(request()->segment(2) == 'financial') class="active" @endif>
                        <a  href="{{action([\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'financial'])}}">
                            {{__('Financial')}}
                        </a>
                    </li>

                    <!-- Others -->
                    <li @if(request()->segment(2) == 'other') class="active" @endif>
                        <a  href="{{action([\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'other'])}}">
                            {{__('Others')}}
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>


