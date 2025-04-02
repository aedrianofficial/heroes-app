<?php

use App\Http\Controllers\Admin\BfpController;
use App\Http\Controllers\Admin\CoastGuardController;
use App\Http\Controllers\Admin\LguController;
use App\Http\Controllers\Admin\MdrrmoController;
use App\Http\Controllers\Admin\MhoController;
use App\Http\Controllers\Admin\PnpController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MessageAnalyticsController;
use App\Http\Controllers\User\ReportController;
use App\Models\CallView;
use App\Models\MessageView;
use App\Models\RequestMessageView;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use App\Models\Agency;
use App\Models\Call;
use App\Models\Message;
use App\Models\RequestCallView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


Route::get('/view-logs', function () {
    return response()->json(['log' => file_get_contents(storage_path('logs/laravel.log'))]);
});
Route::get('/auth-check', function () {
    return Auth::check() ? 'User is logged in' : 'User is not logged in';
});


Route::get('/', function () {
    return view('website.welcome');
})->name('welcome');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/analytics', 'App\Http\Controllers\AnalyticsController@index')->name('admin.analytics');
}); 

Route::get('/api/incident-counts', [AnalyticsController::class, 'getIncidentTypeCounts'])->name('api.incident-counts');

Route::get('analytics/agency-performance', [AnalyticsController::class, 'agencyPerformance']);
Route::middleware(['auth:sanctum'])->prefix('api/analytics')->group(function (): void {
    Route::get('analytics/agency-performance', [AnalyticsController::class, 'agencyPerformance']);
    Route::get('/daily-call-volume', [AnalyticsController::class,'dailyCallVolume']);
    Route::get('/top-agencies', [AnalyticsController::class,'topAgencies']);
    Route::get('/calls-status-distribution', [AnalyticsController::class,'callsStatusDistribution']);

    // New message analytics routes
    Route::get('/message-agency-performance', [MessageAnalyticsController::class, 'agencyPerformance']);
    Route::get('/daily-message-volume', [MessageAnalyticsController::class, 'dailyMessageVolume']);
    Route::get('/message-top-agencies', [MessageAnalyticsController::class, 'topAgencies']);
    Route::get('/messages-status-distribution', [MessageAnalyticsController::class, 'messagesStatusDistribution']);
});



Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/news', [WebsiteController::class, 'news'])->name('news');
Route::get('/safety-guide', [WebsiteController::class, 'safetyGuide'])->name('safetyguide');
Route::get('/about-us', [WebsiteController::class, 'aboutUs'])->name('aboutus');
Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact'); 


// Route to mark call as seen
Route::post('/mark-call-as-seen', function (Request $request) {
    CallView::updateOrCreate([
        'call_id' => $request->call_id,
        'user_id' => Auth::id()
    ]);
    
    return response()->json(['success' => true]);
});

//  SSE endpoint for calls
Route::get('/sse/calls', function () {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('X-Accel-Buffering: no');
    
   // Get calls not yet processed AND not yet seen by this user
    $userId = Auth::id();
    $calls = Call::where('is_processed', false)
        ->whereNotExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('call_views')
                ->whereRaw('call_views.call_id = calls.id')
                ->where('call_views.user_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
    if ($calls->isNotEmpty()) {
        foreach ($calls as $call) {
            // Search for caller in external database
            $profile = DB::connection('aparrio_db')
                ->table('m_profiles')
                ->join('m_contacts', 'm_profiles.id', '=', 'm_contacts.p_id')
                ->where('m_contacts.mobile_no', $call->caller_contact)
                ->select('m_profiles.first_name', 'm_profiles.middle_name', 'm_profiles.last_name', 'm_profiles.nameofbarangay')
                ->first();

            // Determine the caller name
            $callerName = $profile
                ? "{$profile->first_name} {$profile->middle_name} {$profile->last_name}"
                : "Unknown Caller";

            $address = $profile
                ? "{$profile->nameofbarangay}"
                : "Unknown Address";

            // Send the data to the client
            echo "event: call-submit\n";
            echo 'data: ' . json_encode([
                'id' => $call->id,
                'caller_contact' => $call->caller_contact,
                'caller_name' => $callerName,
                'address' => $address,
                'created_at' => $call->created_at->format('Y-m-d H:i:s')
            ]) . "\n\n";

            ob_flush();
            flush();
        }
    }
    
    exit();
});

// Route to mark message
Route::post('/mark-message-as-seen', function (Request $request) {
    // Store that this user has seen this message
    MessageView::updateOrCreate([
        'message_id' => $request->message_id,
        'user_id' => Auth::id() 
    ]);
    
    return response()->json(['success' => true]);
});

//  SSE messages endpoint 
Route::get('/sse/messages', function () {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('X-Accel-Buffering: no');
    
    // Get messages not yet processed AND not yet seen by this user
    $userId = Auth::id();
    $messages = Message::where('is_processed', false)
        ->whereNotExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('message_views')
                ->whereRaw('message_views.message_id = messages.id')
                ->where('message_views.user_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    
    if ($messages->isNotEmpty()) {
        foreach ($messages as $message) {
            // Search for sender in external database
            $profile = DB::connection('aparrio_db')
                ->table('m_profiles')
                ->join('m_contacts', 'm_profiles.id', '=', 'm_contacts.p_id')
                ->where('m_contacts.mobile_no', $message->sender_contact)
                ->select('m_profiles.first_name', 'm_profiles.middle_name', 'm_profiles.last_name', 'm_profiles.nameofbarangay')
                ->first();

            // Determine the sender name
            $senderName = $profile
                ? "{$profile->first_name} {$profile->middle_name} {$profile->last_name}"
                : "Unknown Sender";
            $address = $profile
                ? "{$profile->nameofbarangay}"
                : "Unknown Address";
            // Send the data to the client
            echo "event: message-submit\n";
            echo 'data: ' . json_encode([
                'id' => $message->id,
                'sender_contact' => $message->sender_contact,
                'message_content' => $message->message_content,
                'sender_name' => $senderName,
                'address' => $address,
                'created_at' => $message->created_at->format('Y-m-d H:i:s')
            ]) . "\n\n";

            ob_flush();
            flush();
        }
    }
    
    exit();
});

//  SSE request-call 
Route::post('/mark-request-call-as-seen', function (Request $request) {
    RequestCallView::updateOrCreate([
        'request_call_id' => $request->request_call_id,
        'user_id' => Auth::id()
    ]);

    return response()->json(['success' => true]);
});

Route::get('/sse/request-call', function () {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('X-Accel-Buffering: no');

    $userId = Auth::id();
    $userAgencyId = Auth::user()->agency_id; // Assuming users are linked to agencies

    $requests = DB::table('request_calls')
        ->join('request_call_agency', 'request_calls.id', '=', 'request_call_agency.request_call_id')
        ->where('request_call_agency.agency_id', $userAgencyId)
        ->where('request_calls.is_processed', false)
        ->whereNotExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('request_call_views')
                ->whereRaw('request_call_views.request_call_id = request_calls.id')
                ->where('request_call_views.user_id', $userId);
        })
        ->select('request_calls.id', 'request_calls.call_id', 'request_calls.name', 'request_calls.address', 'request_calls.description', 'request_calls.is_processed', 'request_calls.created_at')
        ->orderBy('request_calls.created_at', 'asc')
        ->get();

    if ($requests->isNotEmpty()) {
        foreach ($requests as $request) {
            echo "event: request-submit\n";
            echo 'data: ' . json_encode([
                'id' => $request->call_id,
                'request_call_id' => $request->id,
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'created_at' => $request->created_at
            ]) . "\n\n";

            ob_flush();
            flush();
        }
    }

    exit();
});

//  SSE request-message
Route::post('/mark-request-message-as-seen', function (Request $request) {
    RequestMessageView::updateOrCreate([
        'request_message_id' => $request->request_message_id,
        'user_id' => Auth::id()
    ]);

    return response()->json(['success' => true]);
});

Route::get('/sse/request-message', function () {
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');
    header('X-Accel-Buffering: no');

    $userId = Auth::id();
    $userAgencyId = Auth::user()->agency_id;

    $requests = DB::table('request_messages')
        ->join('request_message_agency', 'request_messages.id', '=', 'request_message_agency.request_message_id')
        ->where('request_message_agency.agency_id', $userAgencyId)
        ->where('request_messages.is_processed', false)
        ->whereNotExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('request_message_views')
                ->whereRaw('request_message_views.request_message_id = request_messages.id')
                ->where('request_message_views.user_id', $userId);
        })
        ->select('request_messages.id', 'request_messages.message_id', 'request_messages.name', 
                 'request_messages.address', 'request_messages.description', 
                 'request_messages.is_processed', 'request_messages.created_at')
        ->orderBy('request_messages.created_at', 'asc')
        ->get();

    if ($requests->isNotEmpty()) {
        foreach ($requests as $request) {
            echo "event: message-submit\n";
            echo 'data: ' . json_encode([
                'id' => $request->message_id,
                'request_message_id' => $request->id, // Include the actual database ID
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'created_at' => $request->created_at
            ]) . "\n\n";

            ob_flush();
            flush();
        }
    }

    exit();
});


// Add this route to your web.php or api.php
Route::get('/api/calls/{call}/can-complete', 'EmergencyCallController@canComplete');

// Then add this method to your EmergencyCallController



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
        Route::get('/admin/pnp-dashboard/call-analytics', function () {
            $agencies = Agency::all();
            return view('admin.pnp.partials.call-analytics',compact('agencies'));
        });

        Route::get('/admin/pnp-dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('admin.pnp.partials.message-analytics',compact('agencies'));
        })->name('admin.pnp.message-analytics');
        //dashboard
        Route::get('/admin/pnp-dashboard', [PnpController::class, 'pnpDashboard'])->name('admin.pnp');
        Route::post('admin/pnp/reports/{id}/responded', [PnpController::class, 'markAsResponded'])->name('pnp.reports.responded');
        Route::post('admin/pnp/reports/{id}/complete', [PnpController::class, 'markAsCompleted'])->name('pnp.reports.complete');
        
        //report
        Route::get('pnp/reports/create', [PnpController::class, 'createReport'])->name('pnp.reports.create');
        Route::post('pnp/reports', [PnpController::class, 'storeReport'])->name('pnp.reports.store');
        Route::get('pnp/all-reports', [PnpController::class, 'reportList'])->name('pnp.reports.index');
        Route::get('admin/pnp/reports/{id}/view', [PnpController::class, 'viewReport'])->name('pnp.reports.view');

        //emergency message
        Route::get('pnp/all-emergency-message', [PnpController::class, 'emergencyMessageList'])->name('pnp.emergencymessage.index');
        Route::get('admin/pnp/emergency-message/{id}/view', [PnpController::class, 'viewEmergencyMessage'])->name('pnp.emergencymessage.view');
        Route::post('admin/pnp/emergency-message/{id}/responded', [PnpController::class, 'markAsRespondedForMessage'])->name('pnp.emergencymessage.responded');
        Route::post('admin/pnp/emergency-message/{id}/complete', [PnpController::class, 'markAsCompletedForMessage'])->name('pnp.emergencymessage.complete');

         //emergency call
         Route::get('pnp/all-emergency-call', [PnpController::class, 'emergencyCallList'])->name('pnp.emergencycall.index');
         Route::get('admin/pnp/emergency-call/{id}/view', [PnpController::class, 'viewEmergencyCall'])->name('pnp.emergencycall.view');
         Route::post('admin/pnp/emergency-call/{id}/responded', [PnpController::class, 'markAsRespondedForCall'])->name('pnp.emergencycall.responded');
         Route::post('admin/pnp/emergency-call/{id}/complete', [PnpController::class, 'markAsCompletedForCall'])->name('pnp.emergencycall.complete');

         //cases
         Route::get('pnp/all-call-cases', [PnpController::class, 'callCaseLists'])->name('pnp.call_cases.index');
         Route::get('pnp/all-message-cases', [PnpController::class, 'messageCaseLists'])->name('pnp.message_cases.index');
    });

    // Bureau of Fire Protection (BFP)
    Route::middleware(['role:admin,BFP'])->group(function () {

        Route::get('/admin/bfp-dashboard/call-analytics', function () {
            $agencies = Agency::all();
            return view('admin.bfp.partials.call-analytics',compact('agencies'));
        });

        Route::get('/admin/bfp-dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('admin.bfp.partials.message-analytics',compact('agencies'));
        })->name('admin.bfp.message-analytics');
        //dashboard
        Route::get('/admin/bfp-dashboard', [BfpController::class, 'bfpDashboard'])->name('admin.bfp');
        Route::post('admin/bfp/reports/{id}/responded', [BfpController::class, 'markAsResponded'])->name('bfp.reports.responded');
        Route::post('admin/bfp/reports/{id}/complete', [BfpController::class, 'markAsCompleted'])->name('bfp.reports.complete');

        //report
        Route::get('bfp/reports/create', [BfpController::class, 'createReport'])->name('bfp.reports.create');
        Route::post('bfp/reports', [BfpController::class, 'storeReport'])->name('bfp.reports.store');
        Route::get('bfp/all-reports', [BfpController::class, 'reportList'])->name('bfp.reports.index');
        Route::get('admin/bfp/reports/{id}/view', [BfpController::class, 'viewReport'])->name('bfp.reports.view');

        //emergency message
        Route::get('bfp/all-emergency-message', [BfpController::class, 'emergencyMessageList'])->name('bfp.emergencymessage.index');
        Route::get('admin/bfp/emergency-message/{id}/view', [BfpController::class, 'viewEmergencyMessage'])->name('bfp.emergencymessage.view');
        Route::post('admin/bfp/emergency-message/{id}/responded', [BfpController::class, 'markAsRespondedForMessage'])->name('bfp.emergencymessage.responded');
        Route::post('admin/bfp/emergency-message/{id}/complete', [BfpController::class, 'markAsCompletedForMessage'])->name('bfp.emergencymessage.complete');

         //emergency call
         Route::get('bfp/all-emergency-call', [BfpController::class, 'emergencyCallList'])->name('bfp.emergencycall.index');
         Route::get('admin/bfp/emergency-call/{id}/view', [BfpController::class, 'viewEmergencyCall'])->name('bfp.emergencycall.view');
         Route::post('admin/bfp/emergency-call/{id}/responded', [BfpController::class, 'markAsRespondedForCall'])->name('bfp.emergencycall.responded');
         Route::post('admin/bfp/emergency-call/{id}/complete', [BfpController::class, 'markAsCompletedForCall'])->name('bfp.emergencycall.complete');

        //cases
        Route::get('bfp/all-call-cases', [BfpController::class, 'callCaseLists'])->name('bfp.call_cases.index');
        Route::get('bfp/all-message-cases', [BfpController::class, 'messageCaseLists'])->name('bfp.message_cases.index');
    });
    
    //Municipal Disaster Risk Reduction and Management Office (MDRRMO)
    Route::middleware( ['role:admin,MDRRMO'])->group(function () {
        Route::get('/admin/mdrrmo-dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('admin.mdrrmo.partials.message-analytics',compact('agencies'));
        })->name('admin.mdrrmo.message-analytics');

         Route::get('/admin/mdrrmo-dashboard', action: [MdrrmoController::class, 'mdrrmoDashboard'])->name('admin.mdrrmo');
         Route::get('admin/mdrrmo/all-reports', [MdrrmoController::class, 'allReports'])->name('admin.mdrrmo.reports');
         Route::post('admin/mdrrmo/reports/{id}/responded', [MdrrmoController::class, 'markAsResponded'])->name('mdrrmo.reports.responded');
         Route::post('admin/mdrrmo/reports/{id}/complete', [MdrrmoController::class, 'markAsCompleted'])->name('mdrrmo.reports.complete');

         
         Route::get('mdrrmo/reports/create', [MdrrmoController::class, 'createReport'])->name('mdrrmo.reports.create');
         Route::post('mdrrmo/reports', [MdrrmoController::class, 'storeReport'])->name('mdrrmo.reports.store');
         Route::get('mdrrmo/all-reports', [MdrrmoController::class, 'reportList'])->name('mdrrmo.reports.index');
         Route::get('admin/mdrrmo/reports/{id}/view', [MdrrmoController::class, 'viewReport'])->name('mdrrmo.reports.view');

          //emergency message
        Route::get('mdrrmo/all-emergency-message', [MdrrmoController::class, 'emergencyMessageList'])->name('mdrrmo.emergencymessage.index');
        Route::get('admin/mdrrmo/emergency-message/{id}/view', [MdrrmoController::class, 'viewEmergencyMessage'])->name('mdrrmo.emergencymessage.view');
        Route::post('admin/mdrrmo/emergency-message/{id}/responded', [MdrrmoController::class, 'markAsRespondedForMessage'])->name('mdrrmo.emergencymessage.responded');
        Route::post('admin/mdrrmo/emergency-message/{id}/complete', [MdrrmoController::class, 'markAsCompletedForMessage'])->name('mdrrmo.emergencymessage.complete');

         //emergency call
         Route::get('mdrrmo/all-emergency-call', [MdrrmoController::class, 'emergencyCallList'])->name('mdrrmo.emergencycall.index');
         Route::get('admin/mdrrmo/emergency-call/{id}/view', [MdrrmoController::class, 'viewEmergencyCall'])->name('mdrrmo.emergencycall.view');
         Route::post('admin/mdrrmo/emergency-call/{id}/responded', [MdrrmoController::class, 'markAsRespondedForCall'])->name('mdrrmo.emergencycall.responded');
         Route::post('admin/mdrrmo/emergency-call/{id}/complete', [MdrrmoController::class, 'markAsCompletedForCall'])->name('mdrrmo.emergencycall.complete');

         //cases
         Route::get('mdrrmo/all-call-cases', [MdrrmoController::class, 'callCaseLists'])->name('mdrrmo.call_cases.index');
         Route::get('mdrrmo/all-message-cases', [MdrrmoController::class, 'messageCaseLists'])->name('mdrrmo.message_cases.index');
    });
    
    //Municipal Health Office (MHO)
    Route::middleware( ['role:admin,MHO'])->group(function () {
        Route::get('/admin/mho-dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('admin.mho.partials.message-analytics',compact('agencies'));
        })->name('admin.mho.message-analytics');

        Route::get('/admin/mho-dashboard', [MhoController::class, 'mhoDashboard'])->name('admin.mho');
        Route::get('admin/mho/all-reports', [MhoController::class, 'allReports'])->name('admin.mho.reports');
        Route::post('admin/mho/reports/{id}/responded', [MhoController::class, 'markAsResponded'])->name('mho.reports.responded');
        Route::post('admin/mho/reports/{id}/complete', [MhoController::class, 'markAsCompleted'])->name('mho.reports.complete');

        Route::get('mho/reports/create', [MhoController::class, 'createReport'])->name('mho.reports.create');
        Route::post('mho/reports', [MhoController::class, 'storeReport'])->name('mho.reports.store');
        Route::get('mho/all-reports', [MhoController::class, 'reportList'])->name('mho.reports.index');
        Route::get('admin/mho/reports/{id}/view', [MhoController::class, 'viewReport'])->name('mho.reports.view');

        //emergency message
        Route::get('mho/all-emergency-message', [MhoController::class, 'emergencyMessageList'])->name('mho.emergencymessage.index');
        Route::get('admin/mho/emergency-message/{id}/view', [MhoController::class, 'viewEmergencyMessage'])->name('mho.emergencymessage.view');
        Route::post('admin/mho/emergency-message/{id}/responded', [MhoController::class, 'markAsRespondedForMessage'])->name('mho.emergencymessage.responded');
        Route::post('admin/mho/emergency-message/{id}/complete', [MhoController::class, 'markAsCompletedForMessage'])->name('mho.emergencymessage.complete');

         //emergency call
         Route::get('mho/all-emergency-call', [MhoController::class, 'emergencyCallList'])->name('mho.emergencycall.index');
         Route::get('admin/mho/emergency-call/{id}/view', [MhoController::class, 'viewEmergencyCall'])->name('mho.emergencycall.view');
         Route::post('admin/mho/emergency-call/{id}/responded', [MhoController::class, 'markAsRespondedForCall'])->name('mho.emergencycall.responded');
         Route::post('admin/mho/emergency-call/{id}/complete', [MhoController::class, 'markAsCompletedForCall'])->name('mho.emergencycall.complete');

        //cases
        Route::get('mho/all-call-cases', [MhoController::class, 'callCaseLists'])->name('mho.call_cases.index');
        Route::get('mho/all-message-cases', [MhoController::class, 'messageCaseLists'])->name('mho.message_cases.index');
    });

    // Coast Guard
    Route::middleware(['role:admin,COAST GUARD'])->group(function () {
        Route::get('/admin/coastguard-dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('admin.coastguard.partials.message-analytics',compact('agencies'));
        })->name('admin.coastguard.message-analytics');

        Route::get('/admin/coast-guard-dashboard', [CoastGuardController::class, 'coastGuardDashboard'])->name('admin.coastguard');
        Route::get('admin/coast-guard/all-reports', [CoastGuardController::class, 'allReports'])->name('admin.coastguard.reports');
        Route::post('admin/coast-guard/reports/{id}/responded', [CoastGuardController::class, 'markAsResponded'])->name('coastguard.reports.responded');
        Route::post('admin/coast-guard/reports/{id}/complete', [CoastGuardController::class, 'markAsCompleted'])->name('coastguard.reports.complete');

        Route::get('coast-guard/reports/create', [CoastGuardController::class, 'createReport'])->name('coastguard.reports.create');
        Route::post('coast-guard/reports', [CoastGuardController::class, 'storeReport'])->name('coastguard.reports.store');
        Route::get('coast-guard/all-reports', [CoastGuardController::class, 'reportList'])->name('coastguard.reports.index');
        Route::get('admin/coast-guard/reports/{id}/view', [CoastGuardController::class, 'viewReport'])->name('coastguard.reports.view');

         //emergency message
         Route::get('coast-guard/all-emergency-message', [CoastGuardController::class, 'emergencyMessageList'])->name('coastguard.emergencymessage.index');
         Route::get('admin/coastguard/emergency-message/{id}/view', [CoastGuardController::class, 'viewEmergencyMessage'])->name('coastguard.emergencymessage.view');
         Route::post('admin/coastguard/emergency-message/{id}/responded', [CoastGuardController::class, 'markAsRespondedForMessage'])->name('coastguard.emergencymessage.responded');
         Route::post('admin/coastguard/emergency-message/{id}/complete', [CoastGuardController::class, 'markAsCompletedForMessage'])->name('coastguard.emergencymessage.complete');

           //emergency call
           Route::get('coast-guard/all-emergency-call', [CoastGuardController::class, 'emergencyCallList'])->name('coastguard.emergencycall.index');
           Route::get('admin/coast-guard/emergency-call/{id}/view', [CoastGuardController::class, 'viewEmergencyCall'])->name('coastguard.emergencycall.view');
           Route::post('admin/coast-guard/emergency-call/{id}/responded', [CoastGuardController::class, 'markAsRespondedForCall'])->name('coastguard.emergencycall.responded');
           Route::post('admin/coast-guard/emergency-call/{id}/complete', [CoastGuardController::class, 'markAsCompletedForCall'])->name('coastguard.emergencycall.complete');

          //cases
          Route::get('coastguard/all-call-cases', [CoastGuardController::class, 'callCaseLists'])->name('coastguard.call_cases.index');
          Route::get('coastguard/all-message-cases', [CoastGuardController::class, 'messageCaseLists'])->name('coastguard.message_cases.index');
    });
    
    //Local Government Unit (LGU)
    Route::middleware(['role:admin,LGU'])->group(function () {
        Route::get('/admin/lgu-dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('admin.lgu.partials.message-analytics',compact('agencies'));
        })->name('admin.lgu.message-analytics');

        Route::get('/admin/lgu-dashboard', [LguController::class, 'lguDashboard'])->name('admin.lgu');
        Route::get('admin/lgu/all-reports', [LguController::class, 'allReports'])->name('admin.lgu.reports');
        Route::post('admin/lgu/reports/{id}/responded', [LguController::class, 'markAsResponded'])->name('lgu.reports.responded');
        Route::post('admin/lgu/reports/{id}/complete', [LguController::class, 'markAsCompleted'])->name('lgu.reports.complete');

        //reports
        Route::get('lgu/reports/create', [LguController::class, 'createReport'])->name('lgu.reports.create');
        Route::post('lgu/reports', [LguController::class, 'storeReport'])->name('lgu.reports.store');
        Route::get('lgu/all-reports', [LguController::class, 'reportList'])->name('lgu.reports.index');
        Route::get('admin/lgu/reports/{id}/view', [LguController::class, 'viewReport'])->name('lgu.reports.view');

        //emergency message
        Route::get('lgu/all-emergency-message', [LguController::class, 'emergencyMessageList'])->name('lgu.emergencymessage.index');
        Route::get('admin/lgu/emergency-message/{id}/view', [LguController::class, 'viewEmergencyMessage'])->name('lgu.emergencymessage.view');
        Route::post('admin/lgu/emergency-message/{id}/responded', [LguController::class, 'markAsRespondedForMessage'])->name('lgu.emergencymessage.responded');
        Route::post('admin/lgu/emergency-message/{id}/complete', [LguController::class, 'markAsCompletedForMessage'])->name('lgu.emergencymessage.complete');

        //emergency call
        Route::get('lgu/all-emergency-call', [LguController::class, 'emergencyCallList'])->name('lgu.emergencycall.index');
        Route::get('admin/lgu/emergency-call/{id}/view', [LguController::class, 'viewEmergencyCall'])->name('lgu.emergencycall.view');
        Route::post('admin/lgu/emergency-call/{id}/responded', [LguController::class, 'markAsRespondedForCall'])->name('lgu.emergencycall.responded');
        Route::post('admin/lgu/emergency-call/{id}/complete', [LguController::class, 'markAsCompletedForCall'])->name('lgu.emergencycall.complete');

         //cases
         Route::get('lgu/all-call-cases', [LguController::class, 'callCaseLists'])->name('lgu.call_cases.index');
         Route::get('lgu/all-message-cases', [LguController::class, 'messageCaseLists'])->name('lgu.message_cases.index');
    });

    Route::middleware(['role:super admin,DEFAULT'])->group(function () {
        Route::get('/super-admin/dashboard/message-analytics', function () {
            $agencies = Agency::all();
            return view('super-admin.partials.message-analytics',compact('agencies'));
        })->name('admin.superadmin.message-analytics');

        // Super Admin Dashboard (Only Super Admins in DEFAULT Agency)
        Route::get('/super-admin/dashboard', [SuperAdminController::class, 'superAdminDashboard'])->name('superadmin.dashboard');

        Route::get('/super-admin/users', [SuperAdminController::class, 'usersList'])->name('superadmin.users');
        Route::get('/super-admin/users/{id}', [SuperAdminController::class, 'viewUser'])->name('superadmin.users.view');
        Route::get('/superadmin/users/{id}/edit', [SuperAdminController::class, 'edit'])->name('superadmin.users.edit');
        Route::put('/superadmin/users/{id}/update', [SuperAdminController::class, 'update'])->name('superadmin.users.update');
        Route::post('/superadmin/users/store', [SuperAdminController::class, 'store'])->name('superadmin.users.store');
        Route::get('/superadmin/users/create', [SuperAdminController::class, 'create'])->name('superadmin.users.create');

        //reports
        Route::get('superadmin/reports/create', [SuperAdminController::class, 'createReport'])->name('superadmin.reports.create');
        Route::post('superadmin/reports', [SuperAdminController::class, 'storeReport'])->name('superadmin.reports.store');
        Route::get('superadmin/all-reports', [SuperAdminController::class, 'reportList'])->name('superadmin.reports.index');
        Route::get('admin/superadmin/reports/{id}/view', [SuperAdminController::class, 'viewReport'])->name('superadmin.reports.view');

          //emergency message
          Route::get('superadmin/all-emergency-message', [SuperAdminController::class, 'emergencyMessageList'])->name('superadmin.emergencymessage.index');
          Route::get('admin/superadmin/emergency-message/{id}/view', [SuperAdminController::class, 'viewEmergencyMessage'])->name('superadmin.emergencymessage.view');
          Route::post('admin/superadmin/emergency-message/{id}/responded', [SuperAdminController::class, 'markAsRespondedForMessage'])->name('superadmin.emergencymessage.responded');
          Route::post('admin/superadmin/emergency-message/{id}/complete', [SuperAdminController::class, 'markAsCompletedForMessage'])->name('superadmin.emergencymessage.complete');
  
          //emergency call
          Route::get('superadmin/all-emergency-call', [SuperAdminController::class, 'emergencyCallList'])->name('superadmin.emergencycall.index');
          Route::get('admin/superadmin/emergency-call/{id}/view', [SuperAdminController::class, 'viewEmergencyCall'])->name('superadmin.emergencycall.view');
          Route::post('admin/superadmin/emergency-call/{id}/responded', [SuperAdminController::class, 'markAsRespondedForCall'])->name('superadmin.emergencycall.responded');
          Route::post('admin/superadmin/emergency-call/{id}/complete', [SuperAdminController::class, 'markAsCompletedForCall'])->name('superadmin.emergencycall.complete');

            //cases
         Route::get('superadmin/all-call-cases', [SuperAdminController::class, 'callCaseLists'])->name('superadmin.call_cases.index');
         Route::get('superadmin/all-message-cases', [SuperAdminController::class, 'messageCaseLists'])->name('superadmin.message_cases.index');
    });
});
