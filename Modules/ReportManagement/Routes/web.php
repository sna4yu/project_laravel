<?php

use Illuminate\Support\Facades\Route;
use Modules\ReportManagement\Http\Controllers\{
    InstallController,
    ReportManagementController,
    StockAdjustmentController,
    AccountingReportController
};
use Modules\Crm\Http\Controllers\ReportController as CrmReportController;
use Modules\Essentials\Http\Controllers\AttendanceController;

Route::middleware(['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'])
    ->prefix('report')
    ->group(function () {

       // Installation routes
       Route::get('install', [InstallController::class, 'index']);
       Route::post('install', [InstallController::class, 'install']);

       // ReportManagement routes
       Route::get('/ReportManagement', [ReportManagementController::class, 'index'])->name('ReportManagement.index');
       Route::get('/income', [ReportManagementController::class, 'getData'])->name('ReportManagement.income');

       // Report routes
       Route::prefix('reports')->group(function () {
           Route::get('/Form', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'index'])->name('Form_index');
           Route::get('/trial-balance', [AccountingReportController::class, 'trialBalance'])->name('trialBalance_report');
           Route::get('/ledger/{id}', [AccountingReportController::class, 'ledger'])->name('ledger_report');
           Route::get('/balance-sheet', [AccountingReportController::class, 'balanceSheet'])->name('balanceSheet_report');
           Route::get('/account-receivable-ageing-report', [AccountingReportController::class, 'accountReceivableAgeingReport'])->name('account_receivable_ageing_report');
           Route::get('/account-receivable-ageing-details', [AccountingReportController::class, 'accountReceivableAgeingDetails'])->name('account_receivable_ageing_details');
           Route::get('/account-payable-ageing-report', [AccountingReportController::class, 'accountPayableAgeingReport'])->name('account_payable_ageing_report');
           Route::get('/account-payable-ageing-details', [AccountingReportController::class, 'accountPayableAgeingDetails'])->name('account_payable_ageing_details');
       });

       //Elegant route
       Route::get('/Elegant-Form', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ElegantForm'])->name('Elegant_Form');
       Route::get('/Elegant-people', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ElegantPeople'])->name('Elegant_People');
       Route::get('/Elegant-operations', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ElegantOperations'])->name('Elegant_Operations');
       Route::get('/Elegant-financial', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ElegantFinancial'])->name('Elegant_Financial');
       Route::get('/Elegant-other', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ElegantOther'])->name('Elegant_Other');

       //Modien route
       Route::get('/Modien-Form', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienForm'])->name('Modien_Form');
       Route::get('/Modien-people', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienPeople'])->name('Modien_People');
       Route::get('/Modien-operations', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienOperations'])->name('Modien_Operations');
       Route::get('/Modien-financial', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienFinancial'])->name('Modien_Financial');
       Route::get('/Modien-other', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'ModienOther'])->name('Modien_Other');
       //Tax route
       Route::get('/Tax-Form', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'TaxForm'])->name('Tax_Form');
       Route::get('/Tax-people', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'TaxPeople'])->name('Tax_People');
       Route::get('/Tax-operations', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'TaxOperations'])->name('Tax_Operations');
       Route::get('/Tax-financial', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'TaxFinancial'])->name('Tax_Financial');
       Route::get('/Tax-other', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'TaxOther'])->name('Tax_Other');

       //Mony Route
       Route::get('/Mony-Form', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'MonyForm'])->name('Mony_Form');
       Route::get('/Mony-people', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'MonyPeople'])->name('Mony_People');
       Route::get('/Mony-operations', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'MonyOperations'])->name('Mony_Operations');
       Route::get('/Mony-financial', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'MonyFinancial'])->name('Mony_Financial');
       Route::get('/Mony-other', [\Modules\ReportManagement\Http\Controllers\FormController::class, 'MonyOther'])->name('Mony_Other');
       // Additional reports
       Route::get('/stock-adjustment-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getStockAdjustmentReport'])->name('stock_adjustment');
       Route::get('/stock-expiry', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getStockExpiryReport'])->name('stock_expiry');
       Route::get('/get-stock-value', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getStockValue']);
       ;
       Route::get('reports/crm', [CrmReportController::class, 'index'])->name('crm_report');
       Route::get('reports/attendance', [AttendanceController::class, 'index'])->name('attendance_report');
       Route::get('reports', [AccountingReportController::class, 'index'])->name('accounting_report');
       Route::get('/account-expense', [\Modules\ReportManagement\Http\Controllers\AccountExpenseController::class, 'index'])->name('expense_report');
       Route::get('/report_management', [\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'index'])->name('report_management');
       Route::get('/people', [\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'people'])->name('people');
       Route::get('/operation', [\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'operation'])->name('operation');
       Route::get('/financial', [\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'financial'])->name('financial');
       Route::get('/other', [\Modules\ReportManagement\Http\Controllers\ReportManagementController::class, 'other'])->name('other');
       Route::get('/profit-loss', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getProfitLoss'])->name('report_profit_loss');
       Route::get('/purchase-sell', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getPurchaseSell'])->name('report_purchase_sell');
       Route::get('/tax-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getTaxReport'])->name('tax_report');
       Route::get('/customer-supplier', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getCustomerSuppliers'])->name('customer_supplier_report');
       Route::get('/customer-group', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getCustomerGroup'])->name('customer_group_report');
       Route::get('/stock-report/', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getStockReport'])->name('stock_report');
       Route::get('/trending-products', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getTrendingProducts'])->name('trending_product');
       Route::get('/items-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'itemsReport'])->name('items_report');
       Route::get('/product-purchase-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getproductPurchaseReport'])->name('product_purchase');
       Route::get('/product-sell-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getproductSellReport'])->name('product_sell_report');
       Route::get('/purchase-payment-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'purchasePaymentReport'])->name('purchase_payment');
       Route::get('/sell-payment-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'sellPaymentReport'])->name('sell_payment_report');
       Route::get('/expense-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getExpenseReport'])->name('expense_report');
       Route::get('/register-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getRegisterReport'])->name('register_report');
       Route::get('/sales-representative-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getSalesRepresentativeReport'])->name('sales_representative_report');
       Route::get('/table-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getTableReport'])->name('table_report');
       Route::get('/service-staff-report', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'getServiceStaffReport'])->name('service_staff_report');
       Route::get('/activity-log', [\Modules\ReportManagement\Http\Controllers\ReportController::class, 'activityLog'])->name('activity_log');
       Route::get('/yearly-income-expense', [\Modules\ReportManagement\Http\Controllers\YearlyIncomeExpenseController::class, 'index'])->name('yearly_income_expense');
       Route::get('/shipments', [\Modules\ReportManagement\Http\Controllers\DeliveryController::class, 'index'])->name('delivery_report');
       Route::get('/delivery-report/shipment-counts', [\Modules\ReportManagement\Http\Controllers\DeliveryController::class, 'getShipmentCounts'])->name('shipment_counts');



       Route::prefix('reports')->group(function () {
           Route::get('/location-employees', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'getEmployeesBasedOnLocation']);
           Route::get('/my-payrolls', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'getMyPayrolls']);
           Route::get('/get-allowance-deduction-row', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'getAllowanceAndDeductionRow']);
           Route::get('/payroll-group-datatable', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'payrollGroupDatatable']);
           Route::get('/view/{id}/payroll-group', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'viewPayrollGroup']);
           Route::get('/edit/{id}/payroll-group', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'getEditPayrollGroup']);
           Route::post('/update-payroll-group', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'getUpdatePayrollGroup']);
           Route::get('/payroll-group/{id}/add-payment', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'addPayment']);
           Route::post('/post-payment-payroll-group', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'postAddPayment']);
           Route::resource('/payroll', 'Modules\ReportManagement\Http\Controllers\PayrollController');
           Route::get('/pay-salary-data', [\Modules\ReportManagement\Http\Controllers\PayrollController::class, 'payEmployee'])->name('pay_salary.index');
       });
           Route::prefix('crm')->group(function () {
           Route::get('crm/reports', [\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'index']);
           Route::get('follow-ups-by-user', [\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'followUpsByUser']);
           Route::get('follow-ups-by-contact', [\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'followUpsContact']);
           Route::get('lead-to-customer-report', [\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'leadToCustomerConversion']);
           Route::get('lead-to-customer-details/{user_id}', [\Modules\ReportManagement\Http\Controllers\ReportCrmController::class, 'showLeadToCustomerConversionDetails']);
       });

   });
