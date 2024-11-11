<?php
use Illuminate\Support\Facades\Route;
use Modules\SocialManagement\Http\Controllers\SocialManagementController;
use Modules\SocialManagement\Http\Controllers\SocialAuditController;

Route::middleware('web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu')->prefix('social')->group(function () {
    Route::get('install', [Modules\SocialManagement\Http\Controllers\InstallController::class, 'index']);
    Route::post('install', [Modules\SocialManagement\Http\Controllers\InstallController::class, 'install']);
    Route::get('/install/uninstall', [Modules\SocialManagement\Http\Controllers\InstallController::class, 'uninstall']);
   
    Route::get('social-dashboard', [SocialManagementController::class, 'dashboard'])->name('social.dashboard');
    Route::get('/social', [SocialManagementController::class, 'index'])->name('social.index');
    Route::post('/social', [SocialManagementController::class, 'store'])->name('social.store');
    Route::get('/social-create', [SocialManagementController::class, 'create'])->name('social.create');
    Route::get('/social-edit/{id}', [SocialManagementController::class, 'edit'])->name('social.edit');
    Route::put('/social/{id}', [SocialManagementController::class, 'update'])->name('social.update');
    Route::delete('/social/{id}', [SocialManagementController::class, 'destroy'])->name('social.destroy');
    Route::get('/social-categories', [SocialManagementController::class, 'getCategories'])->name('social.getCategories');
    Route::get('/social-categories/create', [SocialManagementController::class, 'createCategory'])->name('social-categories.create');
    Route::post('/social-categories', [SocialManagementController::class, 'storeCategory'])->name('social-categories.store');
    Route::get('/social-categories/edit/{id}', [SocialManagementController::class, 'editCategory'])->name('social-categories.edit');
    Route::put('/social-categories/{id}', [SocialManagementController::class, 'updateCategory'])->name('social-categories.update');
    Route::delete('/social-categories/{id}', [SocialManagementController::class, 'destroyCategory'])->name('social-categories.destroy');


    Route::get('social_audits', [SocialAuditController::class, 'index'])->name('social_audits.index');
    Route::get('social_audits/{user_id}/{date}', [SocialAuditController::class, 'show'])->name('social_audits.show');
    Route::get('social_audits/create', [SocialAuditController::class, 'create'])->name('social_audits.create');
    Route::post('social_audits', [SocialAuditController::class, 'store'])->name('social_audits.store');
    Route::put('social_audits', [SocialAuditController::class, 'update'])->name('social_audits.update');
});
