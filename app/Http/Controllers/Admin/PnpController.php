<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentType;
use App\Models\Message;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\StatusLogMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PnpController extends Controller
{
    public function pnpDashboard()
    {
        $user = Auth::user();

        // Fetch reports assigned to PNP (agency_id = 2)
        $reports = Report::whereHas('user', function ($query) {
            $query->where('agency_id', 2); 
        })->with(['incidentType', 'agencies', 'status', 'location', 'reportAttachments'])
          ->latest()
          ->get();
    
        // Count reports by status
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status_id', 1)->count();
        $ongoingReports = $reports->where('status_id', 2)->count();
        $completedReports = $reports->where('status_id', 3)->count();
    
        return view('admin.pnp.dashboard', compact('totalReports', 'pendingReports', 'completedReports','ongoingReports', 'reports'));
    }

    public function viewReport($id)
    {
        $report = Report::with(['incidentType', 'location', 'status', 'agencies', 'reportAttachments'])->findOrFail($id);
        
        return view('admin.pnp.report.view', compact('report'));
    }
    public function markAsOngoing($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->status_id = 2; // 2 = Ongoing
            $report->save();

            return redirect()->back()->with('success', 'Report marked as ongoing.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update report.');
        }
    }

    public function markAsCompleted($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->status_id = 3; // 3 = Completed
            $report->save();

            return redirect()->back()->with('success', 'Report marked as completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update report.');
        }
    }

    //new
    public function createReport(){
        return view('admin.pnp.report.create');
    }
    public function storeReport(Request $request){
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
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
     
        $contactNumber = $request->contact_number;
       
    
        // Debugging Output
       
    
        if (!$contactNumber) {
            return redirect()->back()->withErrors(['contact_number' => 'Contact number is required.']);
        }
     
        // Create Report
        $report = Report::create([
            'user_id' => Auth::id(),
            'incident_type_id' => $request->incident_type_id,
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => 2, // Ongoing
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
    
        return redirect()->route('pnp.reports.index')->with('success', 'Report marked as ongoing.');
    }

    public function reportList()
    {
        $reports = Report::with(['incidentType', 'agencies', 'status', 'location', 'reportAttachments'])
            ->whereHas('user', function ($query) {
                $query->where('agency_id', 2); // Filtering users by agency_id = 2 (PNP)
            })
            ->latest()
            ->get();
    
        return view('admin.PNP.report.all-report', compact('reports'));
    }    

    public function emergencyMessageList()
    {
        $messages = Message::with(['incidentTypes', 'agencies', 'user', 'status'])->latest()->get();


        // Return view with data
        return view('admin.PNP.emergency-messages.index', compact('messages'));
    }
    public function viewEmergencyMessage($id)
    {
        $message = Message::with(['incidentTypes', 'agencies', 'user', 'status', 'statusLogMessages.user.profile' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Fetch logs in descending order
        }])->findOrFail($id);

        return view('admin.pnp.emergency-messages.view', compact('message'));
    }

    public function markAsOngoingForMessage($id, Request $request)
    {
        try {
            $message = Message::findOrFail($id);
            $message->status_id = 2; // 2 = Ongoing
            $message->save();

            // Save log entry
            StatusLogMessage::create([
                'message_id' => $message->id,
                'status_id' => 2, // Ongoing
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as ongoing.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update.');
        }
    }


    public function markAsCompletedForMessage($id, Request $request)
    {
        try {
            $message = Message::findOrFail($id);
            $message->status_id = 3; // 3 = Completed
            $message->save();

            // Save log entry
            StatusLogMessage::create([
                'message_id' => $message->id,
                'status_id' => 3, // Ongoing
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update.');
        }
    }
    
}
