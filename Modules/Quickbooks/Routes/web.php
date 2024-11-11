<?php

use App\Http\Controllers\ProfitLossComparisonController;
use Modules\Quickbooks\Http\Controllers\{
    InstallController,
    QuickbooksController,
    ReportController
};
use Modules\Crm\Http\Controllers\ReportController as CrmReportController;
use Modules\Essentials\Http\Controllers\AttendanceController;
use Modules\Quickbooks\Http\Controllers\BudgetActualController;


// Route::get('/budget-index', [\Modules\Quickbooks\Http\Controllers\BudgetController::class, 'index'])->name('budget_index');
Route::middleware(['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'])
    ->prefix('quickbooks')
    ->group(function () {
        // Route::get(uri: '/Test', action: [TestController::class, 'index']);

        Route::resource('budget_report', \Modules\Quickbooks\Http\Controllers\BudgetController::class)->except(['show', 'edit', 'update', 'destroy']);
        Route::resource('budget-actual', BudgetActualController::class)->except(['show', 'edit', 'update', 'destroy']);
        Route::post('/toggle-favorite', [ReportController::class, 'toggleFavorite'])->name('toggle.favorite');
        // Installation routes
        Route::get('/install', [Modules\Quickbooks\Http\Controllers\InstallController::class, 'index']);
        Route::post('/install', [Modules\Quickbooks\Http\Controllers\InstallController::class, 'install']);
        Route::get('/install/uninstall', [Modules\Quickbooks\Http\Controllers\InstallController::class, 'uninstall']);
        Route::get('/install/update', [Modules\Quickbooks\Http\Controllers\InstallController::class, 'update']);

        // Quickbooks routes
        Route::get('/quickbooks', [QuickbooksController::class, 'index'])->name('quickbooks.index');
        Route::get('/income', [QuickbooksController::class, 'getData'])->name('quickbooks.income');

        // Report routes
        Route::prefix('reports')->group(function () {
            Route::get('/Form', action: [\Modules\Quickbooks\Http\Controllers\FormController::class, 'index'])->name('Form_index');
            Route::get('/trial-balance', [QuickbooksController::class, 'trialBalance'])->name('trialBalance_quickbooks');
            Route::get('/ledger/{id}', [QuickbooksController::class, 'ledger'])->name('ledger_report');
            Route::get('/balance-sheet', [QuickbooksController::class, 'balanceSheet'])->name('balanceSheet_quickbooks');
            Route::get('/balance-sheet-compare', [QuickbooksController::class, 'balanceSheetCompare'])->name('balanceSheet_compare_report');
            Route::get('/balance-sheet-detail', [QuickbooksController::class, 'balanceSheetDetail'])->name('report_balance_sheet_detail');
            Route::get('/balance-sheet-summary', [QuickbooksController::class, 'balanceSheetSummary'])->name('report_balance_sheet_summary');
            Route::get('/account-receivable-ageing-report', [QuickbooksController::class, 'accountReceivableAgeingReport'])->name('account_receivable_ageing');
            Route::get('/account-receivable-ageing-details', [QuickbooksController::class, 'accountReceivableAgeingDetails'])->name('account_receivable_ageing_details_quickbooks');
            Route::get('/account-payable-ageing-report', [QuickbooksController::class, 'accountPayableAgeingReport'])->name('account_payable_ageing_quickbooks');
            Route::get('/account-payable-ageing-details', [QuickbooksController::class, 'accountPayableAgeingDetails'])->name('account_payable_ageing_details_quickbooks');
            Route::get('/account-list', [QuickbooksController::class, 'accountList'])->name('account_list');
            Route::get('/journal-report', [QuickbooksController::class, 'journal'])->name('journal_report');
        });

        //Elegant route
        Route::get('/Elegant-Form', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ElegantForm'])->name('Elegant_Form');
        Route::get('/Elegant-people', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ElegantPeople'])->name('Elegant_People');
        Route::get('/Elegant-operations', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ElegantOperations'])->name('Elegant_Operations');
        Route::get('/Elegant-financial', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ElegantFinancial'])->name('Elegant_Financial');
        Route::get('/Elegant-other', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ElegantOther'])->name('Elegant_Other');

        //Modien route
        Route::get('/Modien-Form', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ModienForm'])->name('Modien_Form');
        Route::get('/Modien-people', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ModienPeople'])->name('Modien_People');
        Route::get('/Modien-operations', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ModienOperations'])->name('Modien_Operations');
        Route::get('/Modien-financial', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ModienFinancial'])->name('Modien_Financial');
        Route::get('/Modien-other', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'ModienOther'])->name('Modien_Other');
        //Tax route
        Route::get('/Tax-Form', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'TaxForm'])->name('Tax_Form');
        Route::get('/Tax-people', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'TaxPeople'])->name('Tax_People');
        Route::get('/Tax-operations', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'TaxOperations'])->name('Tax_Operations');
        Route::get('/Tax-financial', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'TaxFinancial'])->name('Tax_Financial');
        Route::get('/Tax-other', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'TaxOther'])->name('Tax_Other');

        //Mony Route
        Route::get('/Mony-Form', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'MonyForm'])->name('Mony_Form');
        Route::get('/Mony-people', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'MonyPeople'])->name('Mony_People');
        Route::get('/Mony-operations', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'MonyOperations'])->name('Mony_Operations');
        Route::get('/Mony-financial', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'MonyFinancial'])->name('Mony_Financial');
        Route::get('/Mony-other', [\Modules\Quickbooks\Http\Controllers\FormController::class, 'MonyOther'])->name('Mony_Other');
        // Additional reports
        Route::get('/stock-adjustment-report', [ReportController::class, 'getStockAdjustmentReport'])->name('stock_adjustment');
        Route::get('/stock-expiry', [ReportController::class, 'getStockExpiryReport'])->name('stock_expiry');
        Route::get('/get-stock-value', [ReportController::class, 'getStockValue']);
        ;
        // Route::get('reports/crm', [CrmReportController::class, 'index'])->name('crm_report');
        // Route::get('reports/crm', [\Modules\Quickbooks\Http\Controllers\ReportCrmController ::class, 'index'])->name('crm_report');
        // Route::get('reports/attendance', [\Modules\Quickbooks\Http\Controllers\HrmAttendanceController::class, 'index'])->name('attendance_report');
        // Route::get('reports/leave', [\Modules\Quickbooks\Http\Controllers\HrmLeaveController::class, 'index'])->name('leave_report');
        // Route::get('reports', [QuickbooksController::class, 'index'])->name('accounting_report');
        // Route::get('/account-expense', [\Modules\Quickbooks\Http\Controllers\AccountExpenseController::class, 'index'])->name('expense_report');
        // Route::get('/account-expense-assets', [\Modules\Quickbooks\Http\Controllers\AccountExpenseAssetsController::class, 'index'])->name('expense_assets_report');
        // Route::get('/commercial-invoice', [\Modules\Quickbooks\Http\Controllers\CommercialReportController::class, 'index'])->name('commercial_invoice_report');
        // Route::get('/purchase-inventory', [\Modules\Quickbooks\Http\Controllers\PurchaseInventoryController::class, 'index'])->name('purchase_inventory');
        // Route::get('/account-income', [\Modules\Quickbooks\Http\Controllers\IncomeReportController::class, 'index'])->name('income_report');
        Route::get('/report_management', [\Modules\Quickbooks\Http\Controllers\ReportManagementController::class, 'index'])->name('quickbooks_report_management');
        Route::get('/people', [\Modules\Quickbooks\Http\Controllers\ReportManagementController::class, 'people'])->name('people');
        Route::get('/operation', [\Modules\Quickbooks\Http\Controllers\ReportManagementController::class, 'operation'])->name('operation');
        Route::get('/financial', [\Modules\Quickbooks\Http\Controllers\ReportManagementController::class, 'financial'])->name('financial');
        Route::get('/other', [\Modules\Quickbooks\Http\Controllers\ReportManagementController::class, 'other'])->name('other');
        Route::get('/profit-loss', [ReportController::class, 'getProfitLoss'])->name('profit_loss');
        Route::get('/profit-loss-comparison', [ReportController::class, 'getProfitLossComparison'])->name('profit_loss_comparison');
        Route::get('/profit-loss-comparison-ytd', [ReportController::class, 'getProfitLossComparisonYtd'])->name('profit_loss_comparison_ytd');
        Route::get('/quarterly-profit-loss-summary', [ReportController::class, 'getQuarterlyProfitLossSummary'])->name('quarterly_profit_loss_summary');
        Route::get('/profit-loss-by-month', [ReportController::class, 'getProfitLossByMonth'])->name('profit_loss_by_month');
        Route::get('/profit-loss-percentage', [ReportController::class, 'getProfitLossPercentage'])->name('report_profit_loss_percentage');
        Route::get('/profit-loss-detail', [ReportController::class, 'getProfitLossDetail'])->name('report_profit_loss_detail');
        Route::get('/purchase-sell', [ReportController::class, 'getPurchaseSell'])->name('report_purchase_sell');
        Route::get('/tax-report', [ReportController::class, 'getTaxReport'])->name('tax_report');
        Route::get('/customer-supplier', [ReportController::class, 'getCustomerSuppliers'])->name('customer_supplier_report');
        Route::get('/customer-group', [ReportController::class, 'getCustomerGroup'])->name('customer_group_report');
        Route::get('/stock-report/', [ReportController::class, 'getStockReport'])->name('stock_report');
        Route::get('/trending-products', [ReportController::class, 'getTrendingProducts'])->name('trending_product');
        Route::get('/items-report', [ReportController::class, 'itemsReport'])->name('items_report');
        Route::get('/product-purchase-report', [ReportController::class, 'getproductPurchaseReport'])->name('product_purchase');
        Route::get('/product-sell-report', [ReportController::class, 'getproductSellReport'])->name('product_sell_report');
        Route::get('/purchase-payment-report', [ReportController::class, 'purchasePaymentReport'])->name('purchase_payment');
        Route::get('/sell-payment-report', [ReportController::class, 'sellPaymentReport'])->name('sell_payment_report');
        Route::get('/register-report', [ReportController::class, 'getRegisterReport'])->name('register_report');
        Route::get('/sales-representative-report', [ReportController::class, 'getSalesRepresentativeReport'])->name('sales_representative_report');
        Route::get('/table-report', [ReportController::class, 'getTableReport'])->name('table_report');
        Route::get('/service-staff-report', [ReportController::class, 'getServiceStaffReport'])->name('service_staff_report');
        Route::get('/activity-log', [ReportController::class, 'activityLog'])->name('activity_log_quickbooks');
        Route::get('/cash-flow', [QuickbooksController::class, 'cashFlow'])->name('cash_flow');
        // Route::get('/yearly-income-expense', [\Modules\Quickbooks\Http\Controllers\YearlyIncomeExpenseController::class, 'index'])->name('yearly_income_expense');
        // Route::get('/shipments', [\Modules\Quickbooks\Http\Controllers\DeliveryController::class, 'index'])->name('delivery_report');
        // Route::get('/delivery-report/shipment-counts', [\Modules\Quickbooks\Http\Controllers\DeliveryController::class, 'getShipmentCounts'])->name('shipment_counts');



        // Route::prefix('reports')->group(function () {
        //     Route::get('/location-employees', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'getEmployeesBasedOnLocation']);
        //     Route::get('/my-payrolls', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'getMyPayrolls']);
        //     Route::get('/get-allowance-deduction-row', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'getAllowanceAndDeductionRow']);
        //     Route::get('/payroll-group-datatable', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'payrollGroupDatatable']);
        //     Route::get('/view/{id}/payroll-group', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'viewPayrollGroup']);
        //     Route::get('/edit/{id}/payroll-group', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'getEditPayrollGroup']);
        //     Route::post('/update-payroll-group', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'getUpdatePayrollGroup']);
        //     Route::get('/payroll-group/{id}/add-payment', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'addPayment']);
        //     Route::post('/post-payment-payroll-group', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'postAddPayment']);
        //     Route::resource('/payroll', 'Modules\Quickbooks\Http\Controllers\PayrollController');
        //     Route::get('/pay-salary-data', [\Modules\Quickbooks\Http\Controllers\PayrollController::class, 'payEmployee'])->name('pay_salary.index');
        //     Route::get('withholding-tax', [\Modules\Quickbooks\Http\Controllers\WithholdingTaxController::class, 'getTaxReport'])->name('withholding_tax');
        // });
        //     Route::prefix('crm')->group(function () {
        //     Route::get('reports', [\Modules\Quickbooks\Http\Controllers\ReportCrmController::class, 'index']);
        //     Route::get('follow-ups-by-user', [\Modules\Quickbooks\Http\Controllers\ReportCrmController::class, 'followUpsByUser']);
        //     Route::get('follow-ups-by-contact', [\Modules\Quickbooks\Http\Controllers\ReportCrmController::class, 'followUpsContact']);
        //     Route::get('lead-to-customer-report', [\Modules\Quickbooks\Http\Controllers\ReportCrmController::class, 'leadToCustomerConversion']);
        //     Route::get('lead-to-customer-details/{user_id}', [\Modules\Quickbooks\Http\Controllers\ReportCrmController::class, 'showLeadToCustomerConversionDetails']);
        // });

    });
