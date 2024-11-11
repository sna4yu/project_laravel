<?php

namespace Modules\KPI\Http\Controllers;

use App\System;
use Composer\Semver\Comparator;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->module_name = 'kpi';
        $this->appVersion = config('kpi.module_version');
        $this->module_display_name = "KPI";
    }

    /**
     * Install
     *
     * @return Response
     */
    public function index()
    {
        if (! auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->installSettings();

        //Check if installed or not.
        $is_installed = System::getProperty($this->module_name.'_version');
        if (! empty($is_installed)) {
            abort(404);
        }

        $action_url = action([\Modules\KPI\Http\Controllers\InstallController::class, 'install']);

        $intruction_type = 'uf';
        $action_type = 'install';
        $module_display_name = $this->module_display_name;
        return view('install.install-module')
            ->with(compact('action_url', 'intruction_type', 'action_type', 'module_display_name'));

    }
    // public function index()
    // {
    //     if (!auth()->user()->can('superadmin')) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     ini_set('max_execution_time', 0);
    //     ini_set('memory_limit', '512M');

    //     $this->installSettings();

    //     // Check if installed or not
    //     $is_installed = System::getProperty($this->module_name . '_version');
    //     if (empty($is_installed)) {
    //         DB::statement('SET default_storage_engine=INNODB;');
    //         Artisan::call('module:migrate', ['module' => 'Kpi', '--force' => true]);
    //         System::addProperty($this->module_name . '_version', $this->appVersion);
    //     }

    //     $output = [
    //         'success' => 1,
    //         'msg' => 'KPI module installed successfully',
    //     ];

    //     return redirect()
    //         ->action([\App\Http\Controllers\HomeController::class, 'index'])
    //         ->with('status', $output);
    // }

    /**
     * Initialize all install functions
     */
    private function installSettings()
    {
        config(['app.debug' => true]);
        Artisan::call('config:clear');
    }
    // public function install()
    // {
    //     try {
    //         DB::beginTransaction();
    //         $is_installed = System::getProperty($this->module_name.'_version');
    //         if (! empty($is_installed)) {
    //             abort(404);
    //         }

    //         DB::statement('SET default_storage_engine=INNODB;');
    //         Artisan::call('module:migrate', ['module' => 'KPI', '--force' => true]);
    //         Artisan::call('module:publish', ['module' => 'KPI']);
    //         System::addProperty($this->module_name.'_version', $this->appVersion);

    //         DB::commit();

    //         $output = ['success' => 1,
    //             'msg' => 'KPI module installed succesfully',
    //         ];
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

    //         $output = [
    //             'success' => false,
    //             'msg' => $e->getMessage(),
    //         ];
    //     }

    //     return redirect()
    //             ->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
    //             ->with('status', $output);
    // }
    public function install()
    {
        try {
            // Check if the module is already installed
            $is_installed = System::getProperty($this->module_name.'_version');
            if (!empty($is_installed)) {
                abort(404, 'Module already installed'); // Prevents reinstallation if already installed
            }

            // Optionally set the database engine, if needed (usually not necessary as InnoDB is default)
            DB::statement('SET default_storage_engine=INNODB;');

            // Conditionally reset and re-run migrations if tables are not present
            if ($this->shouldResetMigrations()) {
                Artisan::call('migrate:reset', [
                    '--path' => 'Modules/KPI/Database/Migrations',
                    '--force' => true
                ]);
            }

            // Always run migrations to ensure tables are up to date
            Artisan::call('migrate', [
                '--path' => 'Modules/KPI/Database/Migrations',
                '--force' => true
            ]);

            // Publish module assets or configurations
            Artisan::call('module:publish', ['module' => 'KPI']);

            // Update system property to reflect the new version
            System::addProperty($this->module_name.'_version', $this->appVersion);

            // Optimize the application clearing cache
            Artisan::call('optimize:clear');

            $output = ['success' => 1, 'msg' => 'KPI module installed successfully'];
        } catch (\Exception $e) {
            \Log::emergency('Installation failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            $output = ['success' => false, 'msg' => $e->getMessage()];
        }

        return redirect()
            ->action([\App\Http\Controllers\Install\ModulesController::class, 'index'])
            ->with('status', $output);
    }

    private function shouldResetMigrations()
    {
        $tables = ['kpi_indicators', 'kpi_competencies', 'kpi_appraisals', 'kpi_appraisal_scores'];
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                return true;
            }
        }
        return false;
    }



    /**
     * Update module
     *
     * @return Response
     */
    public function update()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');

            $kpi_version = System::getProperty($this->module_name . '_version');

            if (Comparator::greaterThan($this->appVersion, $kpi_version)) {
                $this->installSettings();

                DB::statement('SET default_storage_engine=INNODB;');
                Artisan::call('module:migrate', ['module' => 'KPI', '--force' => true]);

                System::setProperty($this->module_name . '_version', $this->appVersion);
            } else {
                abort(404);
            }

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => 'KPI module updated successfully to version ' . $this->appVersion . ' !!',
            ];

            return redirect()
                ->action([\App\Http\Controllers\HomeController::class, 'index'])
                ->with('status', $output);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];

            return redirect()->back()->with(['status' => $output]);
        }
    }

    /**
     * Uninstall
     *
     * @return Response
     */
    public function uninstall()
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            System::removeProperty($this->module_name . '_version');

            $output = [
                'success' => true,
                'msg' => __('lang_v1.success'),
            ];
        } catch (\Exception $e) {
            $output = [
                'success' => false,
                'msg' => $e->getMessage(),
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }
}
