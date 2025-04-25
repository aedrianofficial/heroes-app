<?php

namespace App\Http\Controllers;

use App\Models\VehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleRequestController extends Controller
{
    


    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
        ]);

        VehicleRequest::create([
            'requested_by' => Auth::id(),
            'full_name' => $validated['full_name'],
            'vehicle_type' => $validated['vehicle_type'],
            'location' => $validated['location'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'priority' => $validated['priority'],
            'status' => 'Pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Vehicle request submitted successfully.');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected,Completed',
        ]);

        $vehicleRequest = VehicleRequest::findOrFail($id);
        $vehicleRequest->status = $validated['status'];
        $vehicleRequest->save();

        return redirect()->back()->with('success', 'Vehicle request status updated successfully.');
    }
}
