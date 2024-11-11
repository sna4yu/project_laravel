<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu')->group(function () {
    Route::prefix('invetorymangament')->group(function() {
        Route::get('/', 'InvetoryMangamentController@index');

        Route::get('/install', [Modules\InvetoryMangament\Http\Controllers\InstallController::class , 'index']);
        Route::post('/install', [Modules\InvetoryMangament\Http\Controllers\InstallController::class , 'install']);
        Route::get('/install/uninstall', [Modules\InvetoryMangament\Http\Controllers\InstallController::class , 'uninstall']);
        Route::get('/install/update', [Modules\InvetoryMangament\Http\Controllers\InstallController::class , 'update']);
        
        Route::get('/', [Modules\InvetoryMangament\Http\Controllers\InvetoryMangamentController::class , 'index']);

        Route::post("createNewInventory" , [Modules\InvetoryMangament\Http\Controllers\InvetoryMangamentController::class , 'createNewInventory']);
        Route::get("showInventoryList" , "InvetoryMangamentController@showInventoryList")->name("showInventoryList");
        Route::get("makeInventory/{id}" , "InvetoryMangamentController@makeInevtory");
        Route::get("getProductData" , "InvetoryMangamentController@getProductData");
        Route::get("inventory/get_products/{id}" , "InvetoryMangamentController@getProducts");
        Route::post("inventory/get_purchase_entry_row" , "InvetoryMangamentController@getPurchaseEntryRow");
        Route::post("updateProductQuantity" , "InvetoryMangamentController@updateProductQuantity");
        Route::post("saveInventoryProducts" , "InvetoryMangamentController@saveInventoryProducts");
        Route::put("update/status/{id}" , "InvetoryMangamentController@updateStatus");
        Route::get("showInventoryReports/{id}/{branch_id}" , "InvetoryMangamentController@showInventoryReports");
        Route::get("inventoryIncreaseReports/{inventory_id}/{branch_id}" , "InvetoryMangamentController@inventoryIncreaseReports");
        Route::get("inventoryDisabilityReports/{inventory_id}/{branch_id}" , "InvetoryMangamentController@inventoryDisabilityReports");

//     });

    });

});


