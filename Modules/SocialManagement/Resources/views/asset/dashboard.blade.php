@extends('layouts.app')
@section('title', __('socialmanagement::lang.assets'))
@section('content')
    @includeIf('socialmanagement::layouts.nav')
    <!-- Main content -->
    <section class="content no-print">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box info-box-new-style">
                    <span class="info-box-icon bg-aqua"><i class="fas fa-boxes"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('socialmanagement::lang.total_social_accounts')</span>
                        <span class="info-box-number">{{ @num_format($total_social_accounts) }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box info-box-new-style">
                    <span class="info-box-icon bg-aqua"><i class="fas fa-boxes"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('socialmanagement::lang.total_social_categories')</span>
                        <span class="info-box-number">{{ @num_format($total_social_category) }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box info-box-new-style">
                    <span class="info-box-icon bg-aqua"><i class="fas fa-boxes"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">@lang('socialmanagement::lang.social_accounts_assigned_to_you')</span>
                        <span class="info-box-number">{{ @num_format($assigned_social_accounts->count()) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title">@lang('socialmanagement::lang.social_accounts_by_category')</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>@lang('product.category')</th>
                                    <th>@lang('socialmanagement::lang.total_social_accounts')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($social_by_category as $social)
                                    <tr>
                                        <td>{{ $social->category }}</td>
                                        <td>{{ @num_format($social->total) }}</td>
                                    </tr>
                                @endforeach

                                @if(count($social_by_category) == 0)
                                    <tr>
                                        <td colspan="2" class="text-center">@lang('lang_v1.no_data')</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header">
                        <h3 class="box-title">@lang('socialmanagement::lang.social_accounts_assigned_to_you')</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>@lang('socialmanagement::lang.social_account')</th>
                                    <th>@lang('product.category')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assigned_social_accounts as $social)
                                    <tr>
                                        <td>{{ $social->social_account }}</td>
                                        <td>{{ $social->category }}</td>
                                    </tr>
                                @endforeach

                                @if(count($assigned_social_accounts) == 0)
                                    <tr>
                                        <td colspan="2" class="text-center">@lang('lang_v1.no_data')</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($is_admin)
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-aqua"><i class="fas fa-boxes"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@lang('socialmanagement::lang.total_assets')</span>
                            <span class="info-box-number">{{ @num_format($total_assets) }}</span>
                        </div>
                    </div>

                    <div class="info-box info-box-new-style">
                        <span class="info-box-icon bg-aqua"><i class="fas fa-boxes"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">@lang('socialmanagement::lang.total_assets_allocated')</span>
                            <span class="info-box-number">{{ @num_format($total_assets_allocated_for_all_users) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-solid">
                        <div class="box-header">
                            <h3 class="box-title">@lang('socialmanagement::lang.assets_by_category')</h3>
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>@lang('product.category')</th>
                                        <th>@lang('socialmanagement::lang.total_assets')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assets_by_category as $asset)
                                        <tr>
                                            <td>{{ $asset->category }}</td>
                                            <td>{{ @num_format($asset->total_quantity) }}</td>
                                        </tr>
                                    @endforeach

                                    @if(count($assets_by_category) == 0)
                                        <tr>
                                            <td colspan="2" class="text-center">@lang('lang_v1.no_data')</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-solid">
                        <div class="box-header">
                            <h3 class="box-title">@lang('socialmanagement::lang.expired_or_expiring_in_one_month')</h3>
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>@lang('socialmanagement::lang.assets')</th>
                                        <th>@lang('socialmanagement::lang.warranty_status')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiring_assets as $asset)
                                        <tr>
                                            <td>{{ $asset->name }} - {{ $asset->asset_code }}</td>
                                            <td>
                                                @if(empty($asset->max_end_date))
                                                    <span class="label bg-red">@lang('socialmanagement::lang.expired')</span>
                                                @else
                                                    @if(\Carbon\Carbon::parse($asset->max_end_date)->lessThan(\Carbon\Carbon::today()))
                                                        <span class="label bg-red">@lang('socialmanagement::lang.expired'): {{ @format_date($asset->max_end_date) }}</span>
                                                    @else
                                                        <span class="label bg-yellow">@lang('socialmanagement::lang.expiring_on'): {{ @format_date($asset->max_end_date) }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if(count($expiring_assets) == 0)
                                        <tr>
                                            <td colspan="2" class="text-center">@lang('lang_v1.no_data')</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
@endsection
