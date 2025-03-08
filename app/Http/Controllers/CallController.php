<?php

namespace App\Http\Controllers;

use App\Events\CallNotification;
use App\Models\Call;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'caller_contact' => 'required|string',
            'call_time' => 'required|date',
        ]);

        // Save call to the database
        $call = Call::create([
            'caller_contact' => $request->caller_contact,
            'call_time' => $request->call_time,
        ]);

        return response()->json(['message' => 'Call saved successfully'], 201);
    }
}
