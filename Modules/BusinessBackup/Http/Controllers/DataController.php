<?php

namespace Modules\BusinessBackup\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Utils\ModuleUtil;
use Menu;
use Modules\BusinessBackup\Entities\BusinessBackup;
use Modules\BusinessBackup\Entities\BusinessBackupShare;

class DataController extends Controller
{   
    public function superadmin_package()
    {
        return [
            [
                'name' => 'businessbackup_module',
                'label' => __('businessbackup::lang.businessbackup_module'),
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
        $permissions = [
            [
                'value' => 'access.businessbackup',
                'label' => __('businessbackup::lang.access_businessbackup'),
                'default' => false
            ],
            [
                'value' => 'create.businessbackup',
                'label' => __('businessbackup::lang.create_businessbackup'),
                'default' => false
            ]
        ];

        return $permissions;
    }
    
    /**
     * Adds BusinessBackup menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        $business_id = session()->get('user.business_id');
        $module_util = new ModuleUtil();
        $is_businessbackup_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'businessbackup_module');

        $background_color = '';
        if (config('app.env') == 'demo') {
            $background_color = '#0086f9 !important';
        }

        // if ($is_businessbackup_enabled && auth()->user()->can('access.businessbackup')) {
            Menu::modify('admin-sidebar-menu', function ($menu) use ($background_color) {
                $menu->url(
                    action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@index'),
                    __('businessbackup::lang.businessbackup'),
                    ['icon' => 'fa fas fa-hdd', 'active' => request()->segment(1) == 'businessbackup', 'style' => 'background-color:'.$background_color]
                        )
                ->order(90);
            });
        // }
    }

    /**
     * Parses notification message from database.
     * @return array
     */
    public function parse_notification($notification)
    {   
        $notification_datas = [];
        if ($notification->type == 'Modules\BusinessBackup\Notifications\BusinessBackupShared') {
            $data = $notification->data;
            $businessbackup = BusinessBackup::with('createdBy')->find($data['sheet_id']);
            if (!empty($businessbackup)) {
                $msg = __(
                    'businessbackup::lang.businessbackup_shared_notif_text',
                    [
                    'shared_by' => $businessbackup->createdBy->user_full_name,
                    'name' => $businessbackup->name,
                    ]
                );
                $notification_datas = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa fa-file-excel bg-green',
                    'read_at' => $notification->read_at,
                    'link' => action('\Modules\BusinessBackup\Http\Controllers\BusinessBackupController@show', [$businessbackup->id]),
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        }

        return $notification_datas;
    }

    public function getSharedBusinessBackupForGivenData($params)
    {   
        $business_id =  $params['business_id'];
        $shared_with = $params['shared_with'];
        $shared_id = $params['shared_id'];

        $sheets = BusinessBackupShare::where('shared_with', $shared_with)
                    ->where('shared_id', $shared_id)
                    ->join('sheet_businessbackups as ss', 'sheet_businessbackup_shares.sheet_businessbackup_id', '=', 'ss.id')
                    ->where('ss.business_id', $business_id)
                    ->select('name as sheet_name', 'sheet_businessbackup_id as sheet_id')
                    ->get();

        return $sheets;
    }
}
