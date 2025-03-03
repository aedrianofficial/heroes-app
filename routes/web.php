<?php

use App\Http\Controllers\Admin\BfpController;
use App\Http\Controllers\Admin\CoastGuardController;
use App\Http\Controllers\Admin\LguController;
use App\Http\Controllers\Admin\MdrrmoController;
use App\Http\Controllers\Admin\MhoController;
use App\Http\Controllers\Admin\PnpController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;

Route::get('/', function () {
    return view('website.welcome');
})->name('welcome');


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/news', [WebsiteController::class, 'news'])->name('news');
Route::get('/safety-guide', [WebsiteController::class, 'safetyGuide'])->name('safetyguide');
Route::get('/about-us', [WebsiteController::class, 'aboutUs'])->name('aboutus');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');


// Protected Route (Dashboard)
Route::middleware(['auth'])->group(function () {
    // User Dashboard (Only Users in DEFAULT)
    Route::middleware(['role:user,DEFAULT'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        Route::get('user/reports/create', [ReportController::class, 'create'])->name('user.reports.create');
        Route::post('user/reports', [ReportController::class, 'store'])->name('user.reports.store');
        Route::get('user/reports', [ReportController::class, 'index'])->name('user.reports.index');
    });
    
    // Philippine National Police (PNP)
    Route::middleware(['role:admin,PNP'])->group(function () {
        Route::get('/admin/pnp-dashboard', [PnpController::class, 'pnpDashboard'])->name('admin.pnp');
        Route::get('admin/pnp/all-reports', [PnpController::class, 'allReports'])->name('admin.pnp.reports');
        Route::get('admin/pnp/reports/{id}/view', [PnpController::class, 'viewReport'])->name('pnp.reports.view');
        Route::post('admin/pnp/reports/{id}/ongoing', [PnpController::class, 'markAsOngoing'])->name('pnp.reports.ongoing');
        Route::post('admin/pnp/reports/{id}/resolve', [PnpController::class, 'markAsResolved'])->name('pnp.reports.resolve');
    });

    // Bureau of Fire Protection (BFP)
    Route::middleware(['role:admin,BFP'])->group(function () {
        Route::get('/admin/bfp-dashboard', [BfpController::class, 'bfpDashboard'])->name('admin.bfp');
        Route::get('admin/bfp/all-reports', [BfpController::class, 'allReports'])->name('admin.bfp.reports');
        Route::get('admin/bfp/reports/{id}/view', [BfpController::class, 'viewReport'])->name('bfp.reports.view');
        Route::post('admin/bfp/reports/{id}/ongoing', [BfpController::class, 'markAsOngoing'])->name('bfp.reports.ongoing');
        Route::post('admin/bfp/reports/{id}/resolve', [BfpController::class, 'markAsResolved'])->name('bfp.reports.resolve');
    });
    
    //Municipal Disaster Risk Reduction and Management Office (MDRRMO)
    Route::middleware( ['role:admin,MDRRMO'])->group(function () {
         Route::get('/admin/mdrrmo-dashboard', [MdrrmoController::class, 'mdrrmoDashboard'])->name('admin.mdrrmo');
         Route::get('admin/mdrrmo/all-reports', [MdrrmoController::class, 'allReports'])->name('admin.mdrrmo.reports');
         Route::get('admin/mdrrmo/reports/{id}/view', [MdrrmoController::class, 'viewReport'])->name('mdrrmo.reports.view');
         Route::post('admin/mdrrmo/reports/{id}/ongoing', [MdrrmoController::class, 'markAsOngoing'])->name('mdrrmo.reports.ongoing');
         Route::post('admin/mdrrmo/reports/{id}/resolve', [MdrrmoController::class, 'markAsResolved'])->name('mdrrmo.reports.resolve');
    });
    
    //Municipal Health Office (MHO)
    Route::middleware( ['role:admin,MHO'])->group(function () {
        Route::get('/admin/mho-dashboard', [MhoController::class, 'mhoDashboard'])->name('admin.mho');
        Route::get('admin/mho/all-reports', [MhoController::class, 'allReports'])->name('admin.mho.reports');
        Route::get('admin/mho/reports/{id}/view', [MhoController::class, 'viewReport'])->name('mho.reports.view');
        Route::post('admin/mho/reports/{id}/ongoing', [MhoController::class, 'markAsOngoing'])->name('mho.reports.ongoing');
        Route::post('admin/mho/reports/{id}/resolve', [MhoController::class, 'markAsResolved'])->name('mho.reports.resolve');
    });

    // Coast Guard
    Route::middleware(['role:admin,COAST GUARD'])->group(function () {
        Route::get('/admin/coast-guard-dashboard', [CoastGuardController::class, 'coastGuardDashboard'])->name('admin.coastguard');
        Route::get('admin/coast-guard/all-reports', [CoastGuardController::class, 'allReports'])->name('admin.coastguard.reports');
        Route::get('admin/coast-guard/reports/{id}/view', [CoastGuardController::class, 'viewReport'])->name('coastguard.reports.view');
        Route::post('admin/coast-guard/reports/{id}/ongoing', [CoastGuardController::class, 'markAsOngoing'])->name('coastguard.reports.ongoing');
        Route::post('admin/coast-guard/reports/{id}/resolve', [CoastGuardController::class, 'markAsResolved'])->name('coastguard.reports.resolve');
    });
    
    //Local Government Unit (LGU)
    Route::middleware(['role:admin,LGU'])->group(function () {
        Route::get('/admin/lgu-dashboard', [LguController::class, 'lguDashboard'])->name('admin.lgu');
        Route::get('admin/lgu/all-reports', [LguController::class, 'allReports'])->name('admin.lgu.reports');
        Route::get('admin/lgu/reports/{id}/view', [LguController::class, 'viewReport'])->name('lgu.reports.view');
        Route::post('admin/lgu/reports/{id}/ongoing', [LguController::class, 'markAsOngoing'])->name('lgu.reports.ongoing');
        Route::post('admin/lgu/reports/{id}/resolve', [LguController::class, 'markAsResolved'])->name('lgu.reports.resolve');
    });

    Route::middleware(['role:super admin,DEFAULT'])->group(function () {

        // Super Admin Dashboard (Only Super Admins in DEFAULT Agency)
        Route::get('/super-admin/dashboard', [SuperAdminController::class, 'superAdminDashboard'])->name('superadmin.dashboard');
        Route::get('/super-admin/users', [SuperAdminController::class, 'usersList'])->name('superadmin.users');
        Route::get('/super-admin/users/{id}', [SuperAdminController::class, 'viewUser'])->name('superadmin.users.view');

    });
});
