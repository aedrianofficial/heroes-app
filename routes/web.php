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
use App\Http\Controllers\CallController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use App\Models\Call;

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


Route::get('/sse/calls', function () {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('X-Accel-Buffering: no'); // Prevents buffering on Nginx

    // Check for new call
    $call = Call::where('is_processed', false)->first();

    if ($call) {
        echo "event: call-submit\n";
        echo 'data: ' . json_encode([
            'caller_contact' => $call->caller_contact,
            'call_time' => $call->call_time
        ]) . "\n\n";

        ob_flush();
        flush();

        // Mark call as processed
        $call->update(['is_processed' => true]);
    }

    // Close the connection so the client can reconnect
    exit();
});



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
        //dashboard
        Route::get('/admin/pnp-dashboard', [PnpController::class, 'pnpDashboard'])->name('admin.pnp');
        Route::post('admin/pnp/reports/{id}/ongoing', [PnpController::class, 'markAsOngoing'])->name('pnp.reports.ongoing');
        Route::post('admin/pnp/reports/{id}/complete', [PnpController::class, 'markAsCompleted'])->name('pnp.reports.complete');
        
        //report
        Route::get('pnp/reports/create', [PnpController::class, 'createReport'])->name('pnp.reports.create');
        Route::post('pnp/reports', [PnpController::class, 'storeReport'])->name('pnp.reports.store');
        Route::get('pnp/all-reports', [PnpController::class, 'reportList'])->name('pnp.reports.index');
        Route::get('admin/pnp/reports/{id}/view', [PnpController::class, 'viewReport'])->name('pnp.reports.view');

        //emergency message
        Route::get('pnp/all-emergency-message', [PnpController::class, 'emergencyMessageList'])->name('pnp.emergencymessage.index');
        Route::get('admin/pnp/emergency-message/{id}/view', [PnpController::class, 'viewEmergencyMessage'])->name('pnp.emergencymessage.view');
        Route::post('admin/pnp/emergency-message/{id}/ongoing', [PnpController::class, 'markAsOngoingForMessage'])->name('pnp.emergencymessage.ongoing');
        Route::post('admin/pnp/emergency-message/{id}/complete', [PnpController::class, 'markAsCompletedForMessage'])->name('pnp.emergencymessage.complete');
    });

    // Bureau of Fire Protection (BFP)
    Route::middleware(['role:admin,BFP'])->group(function () {
        //dashboard
        Route::get('/admin/bfp-dashboard', [BfpController::class, 'bfpDashboard'])->name('admin.bfp');
        Route::post('admin/bfp/reports/{id}/ongoing', [BfpController::class, 'markAsOngoing'])->name('bfp.reports.ongoing');
        Route::post('admin/bfp/reports/{id}/complete', [BfpController::class, 'markAsCompleted'])->name('bfp.reports.complete');

        //report
        Route::get('bfp/reports/create', [BfpController::class, 'createReport'])->name('bfp.reports.create');
        Route::post('bfp/reports', [BfpController::class, 'storeReport'])->name('bfp.reports.store');
        Route::get('bfp/all-reports', [BfpController::class, 'reportList'])->name('bfp.reports.index');
        Route::get('admin/bfp/reports/{id}/view', [BfpController::class, 'viewReport'])->name('bfp.reports.view');

        //emergency message
        Route::get('bfp/all-emergency-message', [BfpController::class, 'emergencyMessageList'])->name('bfp.emergencymessage.index');
        Route::get('admin/bfp/emergency-message/{id}/view', [BfpController::class, 'viewEmergencyMessage'])->name('bfp.emergencymessage.view');
        Route::post('admin/bfp/emergency-message/{id}/ongoing', [BfpController::class, 'markAsOngoingForMessage'])->name('bfp.emergencymessage.ongoing');
        Route::post('admin/bfp/emergency-message/{id}/complete', [BfpController::class, 'markAsCompletedForMessage'])->name('bfp.emergencymessage.complete');
    });
    
    //Municipal Disaster Risk Reduction and Management Office (MDRRMO)
    Route::middleware( ['role:admin,MDRRMO'])->group(function () {
         Route::get('/admin/mdrrmo-dashboard', action: [MdrrmoController::class, 'mdrrmoDashboard'])->name('admin.mdrrmo');
         Route::get('admin/mdrrmo/all-reports', [MdrrmoController::class, 'allReports'])->name('admin.mdrrmo.reports');
         Route::post('admin/mdrrmo/reports/{id}/ongoing', [MdrrmoController::class, 'markAsOngoing'])->name('mdrrmo.reports.ongoing');
         Route::post('admin/mdrrmo/reports/{id}/complete', [MdrrmoController::class, 'markAsCompleted'])->name('mdrrmo.reports.complete');

         
         Route::get('mdrrmo/reports/create', [MdrrmoController::class, 'createReport'])->name('mdrrmo.reports.create');
         Route::post('mdrrmo/reports', [MdrrmoController::class, 'storeReport'])->name('mdrrmo.reports.store');
         Route::get('mdrrmo/all-reports', [MdrrmoController::class, 'reportList'])->name('mdrrmo.reports.index');
         Route::get('admin/mdrrmo/reports/{id}/view', [MdrrmoController::class, 'viewReport'])->name('mdrrmo.reports.view');

          //emergency message
        Route::get('mdrrmo/all-emergency-message', [MdrrmoController::class, 'emergencyMessageList'])->name('mdrrmo.emergencymessage.index');
        Route::get('admin/mdrrmo/emergency-message/{id}/view', [MdrrmoController::class, 'viewEmergencyMessage'])->name('mdrrmo.emergencymessage.view');
        Route::post('admin/mdrrmo/emergency-message/{id}/ongoing', [MdrrmoController::class, 'markAsOngoingForMessage'])->name('mdrrmo.emergencymessage.ongoing');
        Route::post('admin/mdrrmo/emergency-message/{id}/complete', [MdrrmoController::class, 'markAsCompletedForMessage'])->name('mdrrmo.emergencymessage.complete');
    });
    
    //Municipal Health Office (MHO)
    Route::middleware( ['role:admin,MHO'])->group(function () {
        Route::get('/admin/mho-dashboard', [MhoController::class, 'mhoDashboard'])->name('admin.mho');
        Route::get('admin/mho/all-reports', [MhoController::class, 'allReports'])->name('admin.mho.reports');
        Route::post('admin/mho/reports/{id}/ongoing', [MhoController::class, 'markAsOngoing'])->name('mho.reports.ongoing');
        Route::post('admin/mho/reports/{id}/complete', [MhoController::class, 'markAsCompleted'])->name('mho.reports.complete');

        Route::get('mho/reports/create', [MhoController::class, 'createReport'])->name('mho.reports.create');
        Route::post('mho/reports', [MhoController::class, 'storeReport'])->name('mho.reports.store');
        Route::get('mho/all-reports', [MhoController::class, 'reportList'])->name('mho.reports.index');
        Route::get('admin/mho/reports/{id}/view', [MhoController::class, 'viewReport'])->name('mho.reports.view');

        //emergency message
        Route::get('mho/all-emergency-message', [MhoController::class, 'emergencyMessageList'])->name('mho.emergencymessage.index');
        Route::get('admin/mho/emergency-message/{id}/view', [MhoController::class, 'viewEmergencyMessage'])->name('mho.emergencymessage.view');
        Route::post('admin/mho/emergency-message/{id}/ongoing', [MhoController::class, 'markAsOngoingForMessage'])->name('mho.emergencymessage.ongoing');
        Route::post('admin/mho/emergency-message/{id}/complete', [MhoController::class, 'markAsCompletedForMessage'])->name('mho.emergencymessage.complete');
    });

    // Coast Guard
    Route::middleware(['role:admin,COAST GUARD'])->group(function () {
        Route::get('/admin/coast-guard-dashboard', [CoastGuardController::class, 'coastGuardDashboard'])->name('admin.coastguard');
        Route::get('admin/coast-guard/all-reports', [CoastGuardController::class, 'allReports'])->name('admin.coastguard.reports');
        Route::post('admin/coast-guard/reports/{id}/ongoing', [CoastGuardController::class, 'markAsOngoing'])->name('coastguard.reports.ongoing');
        Route::post('admin/coast-guard/reports/{id}/complete', [CoastGuardController::class, 'markAsCompleted'])->name('coastguard.reports.complete');

        Route::get('coast-guard/reports/create', [CoastGuardController::class, 'createReport'])->name('coastguard.reports.create');
        Route::post('coast-guard/reports', [CoastGuardController::class, 'storeReport'])->name('coastguard.reports.store');
        Route::get('coast-guard/all-reports', [CoastGuardController::class, 'reportList'])->name('coastguard.reports.index');
        Route::get('admin/coast-guard/reports/{id}/view', [CoastGuardController::class, 'viewReport'])->name('coastguard.reports.view');

         //emergency message
         Route::get('coast-guard/all-emergency-message', [CoastGuardController::class, 'emergencyMessageList'])->name('coastguard.emergencymessage.index');
         Route::get('admin/coastguard/emergency-message/{id}/view', [CoastGuardController::class, 'viewEmergencyMessage'])->name('coastguard.emergencymessage.view');
         Route::post('admin/coastguard/emergency-message/{id}/ongoing', [CoastGuardController::class, 'markAsOngoingForMessage'])->name('coastguard.emergencymessage.ongoing');
         Route::post('admin/coastguard/emergency-message/{id}/complete', [CoastGuardController::class, 'markAsCompletedForMessage'])->name('coastguard.emergencymessage.complete');
    });
    
    //Local Government Unit (LGU)
    Route::middleware(['role:admin,LGU'])->group(function () {
        Route::get('/admin/lgu-dashboard', [LguController::class, 'lguDashboard'])->name('admin.lgu');
        Route::get('admin/lgu/all-reports', [LguController::class, 'allReports'])->name('admin.lgu.reports');
        Route::post('admin/lgu/reports/{id}/ongoing', [LguController::class, 'markAsOngoing'])->name('lgu.reports.ongoing');
        Route::post('admin/lgu/reports/{id}/complete', [LguController::class, 'markAsCompleted'])->name('lgu.reports.complete');

        //reports
        Route::get('lgu/reports/create', [LguController::class, 'createReport'])->name('lgu.reports.create');
        Route::post('lgu/reports', [LguController::class, 'storeReport'])->name('lgu.reports.store');
        Route::get('lgu/all-reports', [LguController::class, 'reportList'])->name('lgu.reports.index');
        Route::get('admin/lgu/reports/{id}/view', [LguController::class, 'viewReport'])->name('lgu.reports.view');

        //emergency message
        Route::get('lgu/all-emergency-message', [LguController::class, 'emergencyMessageList'])->name('lgu.emergencymessage.index');
        Route::get('admin/lgu/emergency-message/{id}/view', [LguController::class, 'viewEmergencyMessage'])->name('lgu.emergencymessage.view');
        Route::post('admin/lgu/emergency-message/{id}/ongoing', [LguController::class, 'markAsOngoingForMessage'])->name('lgu.emergencymessage.ongoing');
        Route::post('admin/lgu/emergency-message/{id}/complete', [LguController::class, 'markAsCompletedForMessage'])->name('lgu.emergencymessage.complete');
    });

    Route::middleware(['role:super admin,DEFAULT'])->group(function () {

        // Super Admin Dashboard (Only Super Admins in DEFAULT Agency)
        Route::get('/super-admin/dashboard', [SuperAdminController::class, 'superAdminDashboard'])->name('superadmin.dashboard');
        Route::get('/super-admin/users', [SuperAdminController::class, 'usersList'])->name('superadmin.users');
        Route::get('/super-admin/users/{id}', [SuperAdminController::class, 'viewUser'])->name('superadmin.users.view');

    });
});
