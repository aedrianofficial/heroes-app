<?php

use App\Events\CallNotification;
use App\Http\Controllers\CallController;
use App\Models\Call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/calls', [CallController::class, 'store']);

Route::get('/api/caller-info/{mobile}', function ($mobile) {
    $profile = DB::connection('aparrio_db')
        ->table('m_profiles')
        ->join('m_contacts', 'm_profiles.id', '=', 'm_contacts.p_id')
        ->where('m_contacts.mobile_no', $mobile)
        ->select('m_profiles.first_name', 'm_profiles.middle_name', 'm_profiles.last_name', 'm_profiles.nameofbarangay')
        ->first();

    if ($profile) {
        return response()->json([
            'name' => "{$profile->first_name} {$profile->middle_name} {$profile->last_name}",
            'address' => $profile->nameofbarangay
        ]);
    }

    return response()->json([
        'name' => 'Unknown Caller',
        'address' => 'Unknown Address'
    ]);
});
