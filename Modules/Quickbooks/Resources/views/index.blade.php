@extends('layouts.app')

@section('title', __('test::lang.report_management'))

@section('content')

    <section class="content-header">
        <h1 class="title">Reports</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="position-relative search-container">
                    <input type="text" id="filterInput" class="form-control search-input" placeholder="Find report by name"
                        oninput="filterReports(this.value)" aria-label="Find report by name" style="border-radius: 10px;">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <!-- Tabs for Report Categories -->
        <ul class="nav nav-tabs custom-tabs" id="reportTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="standard-tab" data-toggle="tab" href="#standard" role="tab"
                   aria-controls="standard" aria-selected="true">Standard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tab" data-toggle="tab" href="#custom" role="tab"
                   aria-controls="custom" aria-selected="false">Custom reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="management-tab" data-toggle="tab" href="#management" role="tab"
                   aria-controls="management" aria-selected="false">Management reports</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- Standard Tab -->
            <div class="tab-pane fade show active" id="standard" role="tabpanel" aria-labelledby="standard-tab">
                <!-- Favourites Section -->
                <div class="menu-card position-relative">
                    <div class="section-header" onclick="toggleSection('favoritesSection')">
                        <i class="fas fa-chevron-down"></i> Favourites
                    </div>

                    <div class="row report-container" id="favoritesSection">
                        <div class="col-md-6 report-item" data-title="Accounts receivable ageing summary" >
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Accounts receivable ageing summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 report-item" data-title="Balance Sheet">
                            <div class="report-box">
                                <a href="{{ route('balanceSheet_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Balance Sheet</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-star  text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>


                <!-- Business Overview Section -->
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('businessOverviewSection')">
                        <i class="fas fa-chevron-down"></i> Business Overview
                    </div>
                    <div class="row report-container" id="businessOverviewSection">
                        <div class="col-md-6 report-item" data-title="Audit Log">
                            <div class="report-box">
                                <a href="{{ route('activity_log_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                <span>Audit Log</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Balance Sheet">
                            <div class="report-box">
                                <a href="{{ route('balanceSheet_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Balance Sheet</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Balance Sheet Comparison">
                            <div class="report-box">
                                <a href="{{ route('balanceSheet_compare_report') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Balance Sheet Comparison</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Balance Sheet Detail">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_detail') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Balance Sheet Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Balance Sheet Summary">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Balance Sheet Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Budget Overview">
                            <div class="report-box">
                                <a href="{{ route('budget_report.index') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Budget Overview</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Budget vs. Actuals">
                            <div class="report-box">
                                <a href="{{ route('budget-actual.index') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Budget vs. Actuals</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-error" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Statement of Cash Flows">
                            <div class="report-box">
                                <a href="{{ route('cash_flow') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Statement of Cash Flows</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Business Snapshot">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Business Snapshot</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Custom Summary Report">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Custom Summary Report</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Statement of Changes in Equity">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Statement of Changes in Equity</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss by Customer">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss by Customer</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss by Class">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss by Class</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss by Month">
                            <div class="report-box">
                                <a href="{{ route('profit_loss_by_month') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss by Month</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-error" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss Comparison">
                            <div class="report-box">
                                <a href="{{ route('profit_loss_comparison') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss Comparison</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss Detail">
                            <div class="report-box">
                                <a href="{{ route('report_profit_loss_detail') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss as % of total income">
                            <div class="report-box">
                                <a href="{{ route('report_profit_loss_percentage') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss as % of total income</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss year-to-date comparison">
                            <div class="report-box">
                                <a href="{{ route('profit_loss_comparison_ytd') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss year-to-date comparison</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Quarterly Profit and Loss Summary">
                            <div class="report-box">
                                <a href="{{ route('quarterly_profit_loss_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Quarterly Profit and Loss Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-briefcase text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- Who owes you --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('whoOwesyouSection')">
                        <i class="fas fa-chevron-down"></i> Who owes you
                    </div>
                    <div class="row report-container" id="whoOwesyouSection">
                        <div class="col-md-6 report-item" data-title="Accounts receivable ageing summary">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Accounts receivable ageing summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Accounts receivable ageing detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Accounts receivable ageing detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Collections Report">
                            <div class="report-box">
                                <a href="{{ route('balanceSheet_compare_report') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Collections Report</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Customer Balance Summary">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_detail') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Customer Balance Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Customer Balance Detail">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Customer Balance Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Invoice List">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Invoice List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Open Invoices">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Open Invoices</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Statement List">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Statement List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Terms List">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Terms List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Unbilled charges">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Unbilled charges</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Unbilled time">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Unbilled time</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-hand-holding-usd text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- Sales and customers --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('salesAndCustomersSection')">
                        <i class="fas fa-chevron-down"></i> Sales and customers
                    </div>
                    <div class="row report-container" id="salesAndCustomersSection">
                        <div class="col-md-6 report-item" data-title="Customer Contact List">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Customer Contact List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Income by Customer Summary">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Income by Customer Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Sales by Customer Summary">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Sales by Customer Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Sales by Customer Detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Sales by Customer Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Deposit Detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Deposit Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Estimates by Customer">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Estimates by Customer</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Inventory Valuation Detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Inventory Valuation Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Inventory Valuation Summary">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Inventory Valuation Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Product/Service List">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Product/Service List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Sales by Product/Service Summary">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Sales by Product/Service Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Sales by Product/Service Detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Sales by Product/Service Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Sales by Class Summary">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Sales by Class Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Sales by Class Detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Sales by Class Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Payment Method List">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Payment Method List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Stock Take Worksheet">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Stock Take Worksheet</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Time Activities by Customer Detail">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Time Activities by Customer Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Transaction List by Customer">
                            <div class="report-box">
                                <a href="{{ route('account_receivable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Transaction List by Customer</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-tags text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- What you owe --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('whatYouOwnSection')">
                        <i class="fas fa-chevron-down"></i> What you owe
                    </div>
                    <div class="row report-container" id="whatYouOwnSection">
                        <div class="col-md-6 report-item" data-title="Accounts payable ageing summary">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Accounts payable ageing summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Accounts payable ageing detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_details_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Accounts payable ageing detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Bill Payment List">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Bill Payment List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Unpaid Bills">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Unpaid Bills</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Supplier Balance Summary">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Supplier Balance Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Supplier Balance Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Supplier Balance Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Trophy Icon -->
                    <br><br>
                    <i class="fas fa-file-invoice-dollar text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- Expenses and suppliers --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('expensesAndSuppliersSection')">
                        <i class="fas fa-chevron-down"></i> Expenses and suppliers
                    </div>
                    <div class="row report-container" id="expensesAndSuppliersSection">
                        <div class="col-md-6 report-item" data-title="Cheque Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Cheque Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Purchases by Product/Service Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Purchases by Product/Service Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Purchases by Class Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Purchases by Class Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Open Purchase Order Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Open Purchase Order Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Open Purchase Order List">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Open Purchase Order List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Transaction List by Supplier">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Transaction List by Supplier</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Purchases by Supplier Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Purchases by Supplier Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Supplier Contact List">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Supplier Contact List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Expenses by Supplier Summary">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Expenses by Supplier Summary</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-money-bill-wave text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- Employees --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('employeesSection')">
                        <i class="fas fa-chevron-down"></i> Employees
                    </div>
                    <div class="row report-container" id="employeesSection">
                        <div class="col-md-6 report-item" data-title="Employee Contact List">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Employee Contact List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Recent/Edited Time Activities">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Recent/Edited Time Activities</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Time Activities by Employee Detail">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Time Activities by Employee Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-user-tie text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- For my accountant --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('forMyAccountSection')">
                        <i class="fas fa-chevron-down"></i> For my accountant
                    </div>
                    <div class="row report-container" id="forMyAccountSection">
                        <div class="col-md-6 report-item" data-title="Balance Sheet">
                            <div class="report-box">
                                
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Balance Sheet Comparison">
                            <div class="report-box">
                                <a href="{{ route('balanceSheet_compare_report') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Balance Sheet Comparison</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Statement of Cash Flows">
                            <div class="report-box">
                                <a href="{{ route('balanceSheet_compare_report') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Statement of Cash Flows</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="General Ledger">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_detail') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>General Ledger</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Journal">
                            <div class="report-box">
                                <a href="{{ route('journal_report') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Journal</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Class List">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Class List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Recurring Template List">
                            <div class="report-box">
                                <a href="{{ route('account_payable_ageing_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Recurring Template List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Profit and Loss Comparison">
                            <div class="report-box">
                                <a href="{{ route('report_balance_sheet_summary') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Profit and Loss Comparison</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Recent Transactions">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Recent Transactions</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Reconciliation Reports">
                            <div class="report-box">
                                <a href="{{ route('profit_loss') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Reconciliation Reports</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Trial Balance">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Trial Balance</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-success" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Transaction Detail by Account">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Transaction Detail by Account</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Transaction List by Date">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Transaction List by Date</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Recurring Template List">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Recurring Template List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Transaction List with Splits">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Transaction List with Splits</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-file-invoice text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>

                {{-- Payroll --}}
                <div class="menu-card">
                    <div class="section-header" onclick="toggleSection('payrollSection')">
                        <i class="fas fa-chevron-down"></i> Payroll
                    </div>
                    <div class="row report-container" id="payrollSection">
                        <div class="col-md-6 report-item" data-title="Employee Contact List">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Employee Contact List</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Recent/Edited Time Activities">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Recent/Edited Time Activities</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 report-item" data-title="Time Activities by Employee Detail">
                            <div class="report-box">
                                <a href="{{ route('trialBalance_quickbooks') }}" class="report-link"
                                    style="text-decoration: none;">
                                    <span>Time Activities by Employee Detail</span>
                                </a>
                                <div class="icons">
                                    <i class="fas fa-star favorite-icon text-muted" onclick="toggleFavorite(this)"></i>
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <!-- Trophy Icon -->
                    <i class="fas fa-money-check text-success"
                        style="font-size: 40px; position: absolute; bottom: 10px; right: 10px;"></i>
                </div>
            </div>
             <!-- Custom Reports Tab -->
             <div class="tab-pane fade show active" id="custom" role="tabpanel" aria-labelledby="custom-tab">
                <br>
                <table class="custom-reports-table">
                    <thead>
                        <tr>
                            <th>Report name</th>
                            <th>Created by</th>
                            <th>Date range</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <tr>
                            <td colspan="5" class="empty-message">
                               
                            </td>
                        </tr>
                    </tbody> --}}
                </table>
                <br><br>
                <p style="text-align: center; color:black"> Reports that you customise and then save will be listed here. Click 'Save Customisations' at the top of the report.</p>

                <div style="text-align: right">
                    <span>First</span>
                    <span>Previous</span>
                    <span>0 - 0</span>
                    <span>Next</span>
                    <span>Last</span>
                </div>
            </div>            

            <!-- Management Reports Tab -->
            <div class="tab-pane fade" id="management" role="tabpanel" aria-labelledby="management-tab">
                <h3>Management Reports</h3>
                <p>Coming soon</p> <!-- Content to display -->
            </div>
        </div>
    </section>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    // Activate the Standard tab on page load
    $('#reportTabs a[href="#standard"]').tab('show');

    // Tab click event to show and hide content
    $('#reportTabs a').on('click', function(e) {
      e.preventDefault();
      $(this).tab('show');
      // Hide all tab contents
      $('.tab-pane').removeClass('show active');
      // Show the selected tab content
      $($(this).attr('href')).addClass('show active');
    });

    // Filter function for reports
    function filterReports(val) {
      val = val.toUpperCase();
      let reportItems = document.getElementsByClassName('report-item');
      Array.prototype.forEach.call(reportItems, item => {
        let title = item.getAttribute('data-title').toUpperCase();
        item.style.display = title.includes(val) ? "block" : "none";
      });
    }

    // Toggle function to expand or collapse sections
    function toggleSection(sectionId) {
      const section = document.getElementById(sectionId);
      section.style.display = section.style.display === "none" ? "block" : "none";
    }

    // Function to toggle favorite icon
    function toggleFavorite(element) {
      if (element.classList.contains('text-success')) {
        element.classList.remove('text-success');
        element.classList.add('text-muted');
      } else {
        element.classList.remove('text-muted');
        element.classList.add('text-success');
      }
    }

    // Attach the filter function to the window object
    window.filterReports = filterReports;
    window.toggleSection = toggleSection;
    window.toggleFavorite = toggleFavorite;
  });
</script>

<style>
    .title {
        font-size: 1.8em;
        font-weight: bold;
        margin-bottom: 20px;
        color: black;
    }

    .search-container {
        position: relative;
        width: 300px;
        float: right;
    }

    .search-input {
        padding-right: 35px;
        border-radius: 20px;
        border: 2px solid #e0e0e0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease;
        color: black;
    }

    .search-input:hover {
        border-color: #28a745;
    }

    .search-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .custom-tabs .nav-link.active {
        font-weight: bold;
        border-bottom: 3px solid #28a745;
        color: black;
    }

    .section-header {
        cursor: pointer;
        padding: 10px 0;
        font-size: 1.2em;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        border-bottom: 1px solid #ddd;
        margin-bottom: 10px;
        transition: background 0.2s ease;
        color: black;
    }

    .section-header i {
        margin-right: 8px;
    }

    .section-header:hover {
        background: #f8f9fa;
    }

    .report-box {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.2s ease;
        color: black;
    }

    .report-box:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .icons i {
        margin-left: 10px;
        cursor: pointer;
        color: black;
    }

    .text-success {
        color: #28a745 !important;
    }
    .text-error {
        color: #ff0000 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .report-container {
        margin-top: 15px;
    }

    body,
    .nav-link,
    .nav-tabs .nav-item .nav-link,
    .section-header,
    .report-item span,
    .report-link {
        color: black;
    }

    a,
    .report-link {
        color: black;
        text-decoration: none;
    }

    a:hover,
    .report-link:hover {
        color: blue;
        text-decoration: underline;
    }

    .menu-card {
        border: 1px solid #ddd;
        padding: 15px;
        background-color: #fff;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
    }
    .custom-reports-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    background-color: white; /* Set table background to white */
    color: black; /* Set text color to black */
}

.custom-reports-table th, .custom-reports-table td {
    border-bottom: 1px solid #ddd;
    text-align: left;
    padding: 8px;
    color: black; /* Set table header and cell text color to black */
}

.custom-reports-table thead th {
    background-color: #ffffff;
    font-weight: bold;
}

.empty-message {
    text-align: center;
    color: black; /* Set empty message text color to black */
    padding: 20px 0;
}

.pagination {
    display: flex;
    justify-content: flex-end; /* Aligns the items to the right */
    margin-top: 10px;
    font-size: 12px;
    color: black; /* Set pagination text color to black */
}

.pagination span {
    margin-left: 10px; /* Adds some space between the pagination items */
    cursor: pointer;
}

</style>
