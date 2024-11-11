<?php

namespace Modules\InvetoryMangament\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Utils\ModuleUtil;
use Menu;

class DataController extends Controller
{    
    public function superadmin_package()
    {
        return [
            [
                'name' => 'invetorymangament_module',
                'label' => __('invetorymangament::inventory.stock_inventory'),
                'default' => false
            ]
        ];
    }

    /**
      * Defines user permissions for the module.
      * @return array
      */
    public function user_permissions()
    {
        return [
            [
                'value' => 'invetorymangament.view',
                'label' => __('invetorymangament::app.view'),
                'default' => false
            ],
            [
                'value' => 'invetorymangament.empty',
                'label' => __('invetorymangament::app.remove_inv'),
                'default' => false
            ],
      
        ];
    }

    /**
    * Function to add module taxonomies
    * @return array
    */
    public function addTaxonomies()
    {
        $business_id = request()->session()->get('user.business_id');

        $module_util = new ModuleUtil();
        if (!(auth()->user()->can('superadmin') || $module_util->hasThePermissionInSubscription($business_id, 'invetorymangament_module'))) {
            return ['inventory' => []];
        }
        
        return [
            'inventory' => [
                'taxonomy_label' =>  __('invetorymangament::inventory.stock_inventory'),
                'heading' => __('invetorymangament::inventory.stock_inventory'),
                'sub_heading' => __('invetorymangament::inventory.stock_inventory'),
                'enable_taxonomy_code' => false,
                'enable_sub_taxonomy' => false,
                'navbar' => 'invetorymangament::layouts.nav'
            ]
        ];
    }

    /**
     * Adds Repair menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $is_invetorymangament_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'invetorymangament_module');

        $background_color = '';
        if (config('app.env') == 'demo') {$background_color = '#2e97bf !important';}


        if ($is_invetorymangament_enabled && (auth()->user()->can('superadmin') || auth()->user()->can('invetorymangament.view'))) {
            $menuparent = Menu::instance('admin-sidebar-menu');
            $menuparent->dropdown (__('invetorymangament::inventory.inventory'), 

                            function ($sub) use ($background_color){

                                $sub->url(action('\Modules\InvetoryMangament\Http\Controllers\InvetoryMangamentController@showInventoryList'),
                                __('invetorymangament::inventory.stock_inventory'),
                                [
                                'active' =>  request()->segment(2) == 'showInventoryList'  ,
                                 'style' => "background-color:$background_color"]);
                         

                                $sub->url(action('\Modules\InvetoryMangament\Http\Controllers\InvetoryMangamentController@index'),
                                __('invetorymangament::inventory.create_new_inventory'),
                                ['active' => request()->segment(2) == 'createNewInventory','style' => "background-color:$background_color"]);
                            },
            
            ['icon' => 'fas fa fa-boxes']
            )->order(89);


            // Menu::modify('admin-sidebar-menu', function ($menu) use ($background_color) {
            //     $menu->url(
            //                 action('\Modules\InvetoryMangament\Http\Controllers\InvetoryMangamentController@index'),
            //                 __('invetorymangament::inventory.stock_inventory'),
            //                 ['icon' => 'fas fa fa-boxes', 'active' => request()->segment(1) == 'invetorymangament', 'style' => 'background-color:'.$background_color]
            //             )
            //     ->order(89);
            // });
        }
    }


}
