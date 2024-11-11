<div class="box-header text-center" style="background-color: #ffffff;">
    <h4 class="box-title" style="font-size: 24px;">{{ Session::get('business.name') }}</h4><br><br>
    <p class="box-title"><b>Budget Overview: Budget_FY24_P&L - FY24 P&L</b></p>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="tab-pane active" id="monthly_tab">
                    <div class="text-right mb-12">
                        <a class="btn btn-sm btn-default" href="{{route('budget.index')}}?financial_year={{$fy_year}}&format=pdf&view_type=monthly">
                            <i class="fas fa-file-pdf"></i> @lang('accounting::lang.export_to_pdf')
                        </a>
                        <a class="btn btn-sm btn-default" href="{{route('budget.index')}}?financial_year={{$fy_year}}&format=csv&view_type=monthly">
                            <i class="fas fa-file-csv"></i> @lang('accounting::lang.export_to_csv')
                        </a>
                        <a class="btn btn-sm btn-default" href="{{route('budget.index')}}?financial_year={{$fy_year}}&format=excel&view_type=monthly">
                            <i class="fas fa-file-excel"></i> @lang('accounting::lang.export_to_excel')
                        </a>
                    </div>

                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr style="border-bottom: 2px solid #000000;">
                                    <th>Account</th>
                                    @foreach($months as $k => $m)
                                    <th colspan="4" class="text-center">{{ ucfirst($m) }} {{ $fy_year }}</th>
                                    @endforeach
                                    <th colspan="4">Total</th>
                                </tr>
                                <tr style="border-bottom: 2px solid #000000;">
                                    <th></th>
                                    @foreach($months as $k => $m)
                                    <th>Actual</th>
                                    <th>Budget</th>
                                    <th>Over Budget</th>
                                    <th>% of Budget</th>
                                    @endforeach
                                    <th>Actual</th>
                                    <th>Budget</th>
                                    <th>Over Budget</th>
                                    <th>% of Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($account_types as $account_type => $account_type_detail)
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
                                    $actual = $budget->whereIn('accounting_account_id', $account_ids)->sum($m);
                                    $budget_value = 10000; // Replace with dynamic value
                                    $over_budget = $actual - $budget_value;
                                    $percent_budget = $budget_value != 0 ? ($actual / $budget_value) * 100 : 0;
                                    $total_by_month[$m] = $actual;
                                    $total_sum += $actual;
                                    @endphp
                                    <td class="font-weight-bold text-black">{{ @num_format($actual) }}</td>
                                    <td class="text-black">{{ @num_format($budget_value) }}</td>
                                    <td class="text-black">{{ @num_format($over_budget) }}</td>
                                    <td class="text-black">{{ @num_format($percent_budget) }}%</td>
                                    @endforeach
                                    <td class="font-weight-bold text-black">{{ @num_format($total_sum) }}</td>
                                </tr>

                                @foreach($accounts->where('account_primary_type', $account_type)->sortBy('name')->all() as $account)
                                <tr class="collapse-tr account-type-{{$account_type}}" style="display: none; border-bottom: 1px solid #ADD8E6;">
                                    <th>{{ $account->name }}</th>
                                    @foreach($months as $k => $m)
                                    @php
                                    $account_budget = $budget->where('accounting_account_id', $account->id)->first();
                                    $actual = $account_budget ? $account_budget->$m : null;
                                    $budget_value = 10000; // Replace with actual value
                                    $over_budget = $actual - $budget_value;
                                    $percent_budget = $budget_value != 0 ? ($actual / $budget_value) * 100 : 0;
                                    @endphp
                                    <td>{{ @num_format($actual) }}</td>
                                    <td>{{ @num_format($budget_value) }}</td>
                                    <td>{{ @num_format($over_budget) }}</td>
                                    <td>{{ @num_format($percent_budget) }}%</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
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
                                    <td class="font-weight-bold text-black">{{ @num_format($monthly_total) }}</td>
                                    @endforeach
                                    <td class="font-weight-bold text-black">{{ @num_format($overall_grand_total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
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
            $(this).find(".collapse-icon i").toggleClass("fa-arrow-circle-right fa-arrow-circle-down");
        });
    });
</script>
