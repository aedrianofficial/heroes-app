<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\IncidentType;
use App\Models\Report;
use App\Models\ReportAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create()
    {
        return view('user.report.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'incident_type_id' => 'required|exists:incident_types,id',
            'report_attachments' => 'nullable',
            'report_attachments.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'address' => 'required|string',
            'contact_number' => 'nullable|string|max:11',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        // Determine which contact number to use
        if ($request->use_saved_number == 1) {
            $contactNumber = $user->contacts->first()->contact_number ?? null;
        } else {
            $contactNumber = $request->contact_number;
        }
    
        // Debugging Output
       
    
        if (!$contactNumber) {
            return redirect()->back()->withErrors(['contact_number' => 'Contact number is required.']);
        }
     
        // Create Report
        $report = Report::create([
            'user_id' => Auth::id(),
            'incident_type_id' => $request->incident_type_id,
            'title' => $request->title,
            'description' => $request->description,
            'status_id' => 1, // Default to Pending
            'contact_number' => $contactNumber,
        ]);
    
        // Assign Agencies Based on Incident Type
        $incidentType = IncidentType::find($request->incident_type_id);
        $agencies = $incidentType->agencies;
        $report->agencies()->attach($agencies);
    
        // Save Location Data
        $report->location()->create([
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    
        // Handle Image Upload
        if ($request->hasFile('report_attachments')) {
            foreach ((array) $request->file('report_attachments') as $image) {
                if ($image) { // Ensure it's a valid file
                    $path = $image->store('report_images', 'public');
                    ReportAttachment::create([
                        'report_id' => $report->id,
                        'file_path' => $path,
                    ]);
                }
            }
        }
    
        return redirect()->route('user.reports.index')->with('success', 'Report marked as responded.');
    }
    
    public function index()
    {
        $reports = Report::with(['incidentType', 'agencies', 'status', 'location', 'reportAttachments'])->where('user_id', Auth::id())->latest()->paginate(10);
        return view('user.report.index', compact('reports'));
        
    }
}
