<div class="box-header text-center" style="background-color: #ffffff;">
    <h4 class="box-title" style="font-size: 24px;">{{ Session::get('business.name') }}</h4><br><br>
    <p class="box-title"><b>Budget Overview: Budget_FY24_P&L - FY24 P&L </b></p>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="tab-pane active" id="monthly_tab">
                    <div class="text-right mb-12">
                        <a class="btn btn-sm btn-default" 
                        href="{{route('budget.index')}}?financial_year={{$fy_year}}&format=pdf&view_type=monthly"><i class="fas fa-file-pdf"></i> 
                            @lang('accounting::lang.export_to_pdf')</a>
                        <a class="btn btn-sm btn-default" 
                        href="{{route('budget.index')}}?financial_year={{$fy_year}}&format=csv&view_type=monthly"><i class="fas fa-file-csv"></i> 
                            @lang('accounting::lang.export_to_csv')</a>
                        <a class="btn btn-sm btn-default" 
                        href="{{route('budget.index')}}?financial_year={{$fy_year}}&format=excel&view_type=monthly"><i class="fas fa-file-excel"></i> 
                            @lang('accounting::lang.export_to_excel')</a>
                    </div>
                    <div style="height: 500px;">
                        <table class="table table-striped table-sticky">
                            <thead>
                                <tr style="border-bottom: 2px solid #000000;"> <!-- Light blue color -->
                                    <th>@lang('account.account')</th>
                                    @foreach($months as $k => $m)
                                        <th>{{ Carbon::createFromFormat('m', $k)->format('M') }}</th>
                                    @endforeach
                                    <th>@lang('sale.total')</th>
                                </tr>
                            </thead>
                            @foreach($account_types as $account_type => $account_type_detail)
                                <tbody>
                                    <!-- Main Account Row with Total -->
                                    <tr class="toggle-tr bg-light-gray" data-target="account-type-{{$account_type}}" style="cursor: pointer; border-bottom: 2px solid #ADD8E6;">
                                        <th>
                                            <span class="collapse-icon">
                                                <i class="fas fa-arrow-circle-right"></i>
                                            </span>
                                            {{$account_type_detail['label']}}
                                        </th>
                                        @php
                                            $account_ids = $accounts->where('account_primary_type', $account_type)->pluck('id');
                                            $total_by_month = [];
                                            $total_sum = 0;
                                        @endphp
                                        @foreach($months as $k => $m)
                                            @php
                                                $monthly_total = $budget->whereIn('accounting_account_id', $account_ids)->sum($m);
                                                $total_by_month[$m] = $monthly_total;
                                                $total_sum += $monthly_total;
                                            @endphp
                                            <td style="color: rgb(0, 0, 0); font-weight: bold;">{{ @num_format($monthly_total) }}</td>
                                        @endforeach
                                        <td style="color: black; font-weight:bold;">{{ @num_format($total_sum) }}</td>
                                    </tr>
                                    <!-- Collapsible Account Rows -->
                                    @foreach($accounts->where('account_primary_type', $account_type)->sortBy('name')->all() as $account)
                                        <tr class="collapse-tr account-type-{{$account_type}}" style="display: none; border-bottom: 1px solid #ADD8E6;">
                                            @php
                                                $total = 0;
                                            @endphp
                                            <th>{{ $account->name }}</th>
                                            @foreach($months as $k => $m)
                                                @php
                                                    $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                                    $value = !is_null($account_budget) && !is_null($account_budget->$m) ? $account_budget->$m : null;
                                                @endphp
                                                <td>
                                                    @if(!is_null($value))
                                                        {{ @num_format($value) }}
                                                        @php
                                                            $total += $value;
                                                        @endphp
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td style="color: black; font-weight: bold;">{{ @num_format($total) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="collapse-tr account-type-{{$account_type}} bg-gray" style="display: none; border-bottom: 2px solid #ADD8E6;">
                                        <th>@lang('sale.total')  for {{$account_type_detail['label']}}</th>
                                        @foreach($months as $k => $m)
                                            <td style="color: rgb(0, 0, 0); font-weight: bold;">{{ @num_format($budget->whereIn('accounting_account_id', $account_ids)->sum($m)) }}</td>
                                        @endforeach
                                        <td></td>
                                    </tr>
                                </tbody>
                            @endforeach
                            <tfoot>
                                <tr class="table-footer" style="border-bottom: 3px double #000000;">
                                    <th>@lang('Net Income')</th>
                                    @php
                                        $overall_grand_total = 0;
                                    @endphp
                                    @foreach($months as $m)
                                        @php
                                            $monthly_total = $budget->sum($m);
                                            $overall_grand_total += $monthly_total;
                                        @endphp
                                        <td style="color: black; font-weight: bold;">{{ @num_format($monthly_total) }}</td>
                                    @endforeach
                                    <td style="color: black; font-weight: bold;">{{ @num_format($overall_grand_total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Quarterly and Yearly tabs remain unchanged -->
            </div>
        </div>
    </div>
</div>

<!-- jQuery Script to toggle expand/collapse -->
<script>
    $(document).ready(function() {
        $(".toggle-tr").on("click", function() {
            var targetClass = $(this).data("target");
            $("." + targetClass).toggle();
            // Toggle icon from right arrow to down arrow and vice versa
            $(this).find(".collapse-icon i").toggleClass("fa-arrow-circle-right fa-arrow-circle-down");
        });
    });
</script>
