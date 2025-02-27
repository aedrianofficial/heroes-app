<?php

use App\Http\Controllers\Admin\BfpController;
use App\Http\Controllers\Admin\PnpController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Route (Dashboard)
Route::middleware(['auth'])->group(function () {
    // User Dashboard (Only Users in DEFAULT Agency)

    Route::middleware(['role:user,DEFAULT'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        Route::get('user/reports/create', [ReportController::class, 'create'])->name('user.reports.create');
        Route::post('user/reports', [ReportController::class, 'store'])->name('user.reports.store');
        Route::get('user/reports', [ReportController::class, 'index'])->name('user.reports.index');
    });
    
    Route::middleware(['role:admin,PNP'])->group(function () {
        Route::get('/admin/pnp-dashboard', [PnpController::class, 'pnpDashboard'])->name('admin.pnp');
        Route::get('admin/pnp/all-reports', [PnpController::class, 'allReports'])->name('admin.pnp.reports');
        Route::get('admin/pnp/reports/{id}/view', [PnpController::class, 'viewReport'])->name('pnp.reports.view');
        Route::post('admin/pnp/reports/{id}/ongoing', [PnpController::class, 'markAsOngoing'])->name('pnp.reports.ongoing');
        Route::post('admin/pnp/reports/{id}/resolve', [PnpController::class, 'markAsResolved'])->name('pnp.reports.resolve');
    });

    Route::middleware(['role:admin,BFP'])->group(function () {
        Route::get('/admin/bfp-dashboard', [BfpController::class, 'bfpDashboard'])->name('admin.bfp');
        Route::get('admin/bfp/all-reports', [BfpController::class, 'allReports'])->name('admin.bfp.reports');
        Route::get('admin/bfp/reports/{id}/view', [BfpController::class, 'viewReport'])->name('bfp.reports.view');
        Route::post('admin/bfp/reports/{id}/ongoing', [BfpController::class, 'markAsOngoing'])->name('bfp.reports.ongoing');
        Route::post('admin/bfp/reports/{id}/resolve', [BfpController::class, 'markAsResolved'])->name('bfp.reports.resolve');
    });
    
    Route::middleware('role:admin,MDRRMO')->get('/admin/mdrrmo-dashboard', [AdminController::class, 'mdrrmoDashboard'])->name('admin.mdrrmo');

    Route::middleware('role:admin,MHO')->get('/admin/mho-dashboard', [AdminController::class, 'mhoDashboard'])->name('admin.mho');

    Route::middleware('role:admin,COAST GUARD')->get('/admin/coast-guard-dashboard', [AdminController::class, 'coastGuardDashboard'])->name('admin.coastguard');
    
    Route::middleware('role:admin,LGU')->get('/admin/lgu-dashboard', [AdminController::class, 'lguDashboard'])->name('admin.lgu');

    // Super Admin Dashboard (Only Super Admins in DEFAULT Agency)
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'index'])
        ->middleware('role:super admin,DEFAULT')
        ->name('superadmin.dashboard');
});
