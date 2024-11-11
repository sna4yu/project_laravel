<?php

namespace Modules\Quickbooks\Http\Controllers;

use App\Utils\ModuleUtil;
use App\Utils\Util;
use Illuminate\Routing\Controller;
use Menu;

class DataController extends Controller
{
    /**
     * Adds Quickbooks menu to the sidebar.
     *
     * @return void
     */
    // public function modifyAdminMenu()
    // {
    //     Menu::modify('admin-sidebar-menu', function ($menu) {
    //         $menu->url(
    //             action([\Modules\Quickbooks\Http\Controllers\FormController::class, 'index']),
    //             __('Quickbooks'),
    //             ['icon' => 'fas fa-chart-line']
    //         )->order(100);
    //     });
    // }
    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $commonUtil = new Util();
        $is_admin = $commonUtil->is_admin(auth()->user(), $business_id);

        $is_quickbooks_enabled = (bool) $module_util->hasThePermissionInSubscription($business_id, 'quickbooks_module');

        if ($is_quickbooks_enabled) {
            Menu::modify(
                'admin-sidebar-menu',
                function ($menu) {
                    $menu->url(
                        action([\Modules\Quickbooks\Http\Controllers\FormController::class, 'index']) . '?quickbooks_view=list_view',
                        __('quickbooks::lang.quickbooks'),
                        ['icon' => 'fas fa-chart-line', 'active' => request()->segment(1) == 'quickbooks' || request()->get('type') == 'quickbooks', 'style' => config('app.env') == 'demo' ? 'background-color: #e4186d !important;color:white' : '']
                    )
                        ->order(202);
                }
            );
        }
    }

    /**
     * get gross quickbooks from
     * quickbooks
     *
     * @param $business_id, $start_date, $end_date,
     *  $location_id
     * @return decimal
     */
    // public function grossProfit($params)
    // {
    //     $transaction = quickbooksTransaction::where('business_id', $params['business_id'])
    //         ->where('type', 'sell')
    //         ->where('sub_type', 'quickbooks_invoice')
    //         ->where('status', 'final');

    //     if (!empty($params['start_date']) && !empty($params['end_date'])) {
    //         if ($params['start_date'] == $params['end_date']) {
    //             $transaction->whereDate('transaction_date', $params['end_date']);
    //         } else {
    //             $transaction->whereBetween(DB::raw('transaction_date'), [$params['start_date'], $params['end_date']]);
    //         }
    //     }

    //     $transaction = $transaction->select(DB::raw('SUM(final_total) as gross_profit'))
    //         ->first();

    //     $data = [
    //         'value' => $transaction->gross_profit,
    //         'label' => __('quickbooks::lang.quickbooks_invoice'),
    //     ];

    //     return $data;
    // }

    /**
     * Defines user permissions for the module.
     *
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'quickbooks.create_quickbooks',
                'label' => __('quickbooks::lang.create_quickbooks'),
                'default' => false,
            ],
            [
                'value' => 'quickbooks.edit_quickbooks',
                'label' => __('quickbooks::lang.edit_quickbooks'),
                'default' => false,
            ],
            [
                'value' => 'quickbooks.delete_quickbooks',
                'label' => __('quickbooks::lang.delete_quickbooks'),
                'default' => false,
            ],
        ];
    }

    /**
     * Superadmin package permissions
     *
     * @return array
     */
    public function superadmin_package()
    {
        return [
            [
                'name' => 'quickbooks_module',
                'label' => __('quickbooks::lang.quickbooks_module'),
                'default' => false,
            ],
        ];
    }
    
}
