<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Call;
use App\Models\IncidentType;
use App\Models\Message;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\StatusLogCall;
use App\Models\StatusLogMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoastGuardController extends Controller
{
    public function coastguardDashboard()
    {
        $user = Auth::user();

        // Fetch reports assigned to PNP (agency_id = 2)
        $reports = Report::whereHas('user', function ($query) {
            $query->where('agency_id', 6); 
        })->with(['incidentType', 'agencies', 'status', 'location', 'reportAttachments'])
          ->latest()
          ->get();
    
        // Count reports by status
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status_id', 1)->count();
        $respondedReports = $reports->where('status_id', 2)->count();
        $completedReports = $reports->where('status_id', 3)->count();
        $agencies = Agency::all();
        return view('admin.coastguard.dashboard', compact('totalReports', 'pendingReports', 'completedReports','respondedReports', 'reports','agencies'));
    }
    public function allReports()
    {
        $reports = Report::whereHas('incidentType', function ($query) {
            $query->whereIn('name', ['SEA INCIDENT']);
        })->orderBy('created_at', 'desc')->get();

        return view('admin.coastguard.report.all-report', compact('reports'));
    }
    public function viewReport($id)
    {
        $report = Report::with(['incidentType', 'location', 'status', 'agencies', 'reportAttachments'])->findOrFail($id);
        
        return view('admin.coastguard.report.view', compact('report'));
    }
    public function markAsResponded($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->status_id = 2; // 2 = Responded
            $report->save();

            return redirect()->back()->with('success', 'Report marked as responded.');
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

    public function createReport(){
        return view('admin.coastguard.report.create');
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
            'status_id' => 2, // Responded
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
    
        return redirect()->route('coastguard.reports.index')->with('success', 'Report marked as responded.');
    }

    public function reportList()
    {
        $reports = Report::with(['incidentType', 'agencies', 'status', 'location', 'reportAttachments'])
            ->whereHas('user', function ($query) {
                $query->where('agency_id', 6); // Filtering users by agency_id = 2 (coastguard)
            })
            ->latest()
            ->paginate(10);
    
        return view('admin.coastguard.report.all-report', compact('reports'));
    }    
    public function emergencyMessageList()
    {
        $messages = Message::with(['incidentTypes', 'agencies', 'user', 'status'])->latest()->paginate(10);


        // Return view with data
        return view('admin.coastguard.emergency-messages.index', compact('messages'));
    }
    public function viewEmergencyMessage($id)
    {
        $message = Message::with([
            'incidentTypes', 
            'agencies', 
            'user', 
            'status', 
            'statusLogMessages.user.profile' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Fetch logs in descending order
            },
            'requests.agencies', // Include requests and their assigned agencies, like in viewEmergencyCall
            'requests.incidentCase' // Include incident case data
        ])->findOrFail($id);
    
        // Fetch the corresponding contact from aparrio1_dbbdc.m_contacts
        $contact = DB::connection('aparrio_db')->table('m_contacts')
            ->where('mobile_no', $message->sender_contact) // Assuming the field name is sender_contact
            ->first();
    
        $profile = null;
        if ($contact) {
            // Fetch the profile from aparrio1_dbbdc.m_profiles using p_id from m_contacts
            $profile = DB::connection('aparrio_db')->table('m_profiles')
                ->where('id', $contact->p_id)
                ->first();
        }
        
        // Determine if the message can be marked as completed
        $incidentTypeId = null;
        if ($message->requests->isNotEmpty()) {
            $incidentTypeId = optional($message->requests->first()->incidentCase)->incident_type_id;
        }
        
        // Get both the can_complete status and missing_agencies
        $result = $this->canMessageMarkAsCompleted($incidentTypeId, $message->id, true);
        $message->can_complete = $result['can_complete'];
        $message->missing_agencies = $result['missing_agencies'];
    
        return view('admin.coastguard.emergency-messages.view', compact('message', 'profile'));
    }
    public function markAsRespondedForMessage($id, Request $request)
    {
        try {
            $message = Message::findOrFail($id);
            $message->status_id = 2; // 2 = Responded
            $message->save();

            // Save log entry
            StatusLogMessage::create([
                'message_id' => $message->id,
                'status_id' => 2, // Responded
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as responded.');
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
                'status_id' => 3, // Responded
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update.');
        }
    }
    public function emergencyCallList()
    {
        $calls = Call::with([ 'status'])->latest()->paginate(10);
        // Return view with data
        return view('admin.coastguard.emergency-calls.index', compact('calls'));
    }
    public function viewEmergencyCall($id)
{
    $call = Call::with([
        'status',
        'statusLogCalls.user.profile' => function ($query) {
            $query->orderBy('created_at', 'desc');
        },
        'requests.agencies',
        'requests.incidentCase' // Include incident case data
    ])->findOrFail($id);

    // Fetch the corresponding contact from aparrio1_dbbdc.m_contacts
    $contact = DB::connection('aparrio_db')->table('m_contacts')
        ->where('mobile_no', $call->caller_contact)
        ->first();

    $profile = null;
    if ($contact) {
        // Fetch the profile from aparrio1_dbbdc.m_profiles using p_id from m_contacts
        $profile = DB::connection('aparrio_db')->table('m_profiles')
            ->where('id', $contact->p_id)
            ->first();
    }
    
    // Determine if the call can be marked as completed
    $incidentTypeId = null;
    if ($call->requests->isNotEmpty()) {
        $incidentTypeId = optional($call->requests->first()->incidentCase)->incident_type_id;
    }
    
    // Get both the can_complete status and missing_agencies
    $result = $this->canCallMarkAsCompleted($incidentTypeId, $call->id, true);
    $call->can_complete = $result['can_complete'];
    $call->missing_agencies = $result['missing_agencies'];

    return view('admin.coastguard.emergency-calls.view', compact('call', 'profile'));
}


    public function markAsRespondedForCall($id, Request $request)
    {
        try {
            $call = Call::findOrFail($id);
            $call->status_id = 2; // 2 = Responded
            $call->save();

            // Save log entry
            StatusLogCall::create([
                'call_id' => $call->id,
                'status_id' => 2, // Responded
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as responded.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update.');
        }
    }


    public function markAsCompletedForCall($id, Request $request)
    {
        try {
            $call = Call::findOrFail($id);
            $call->status_id = 3; // 3 = Completed
            $call->save();

            // Save log entry
            StatusLogCall::create([
                'call_id' => $call->id,
                'status_id' => 3, // Responded
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update.');
        }
    }
    public function callCaseLists()
    {
        $calls = Call::whereHas('requests', function ($query) {
            $query->whereNotNull('incident_case_id'); // Only get calls with incident cases
        })->with(['requests.incidentCase', 'status'])->paginate(10);
        
        // For each call, check if it can be marked as completed
        foreach ($calls as $call) {
            $incidentTypeId = null;
            
            // Get the incident type from the first request (if any)
            if ($call->requests->isNotEmpty()) {
                $incidentTypeId = optional($call->requests->first()->incidentCase)->incident_type_id;
            }
            
            $result = $this->canCallMarkAsCompleted($incidentTypeId, $call->id, true);
            $call->can_complete = $result['can_complete'];
            $call->missing_agencies = $result['missing_agencies'];
        }
        
        return view('admin.coastguard.call-cases.index', compact('calls'));
    }
    
    public function messageCaseLists()
    {
        $messages = Message::whereHas('requests', function ($query) {
            $query->whereNotNull('incident_case_id'); // Only get messages with incident cases
        })->with(['requests.incidentCase', 'status'])->paginate(10);
        
        // For each message, check if it can be marked as completed
        foreach ($messages as $message) {
            $incidentTypeId = null;
            
            // Get the incident type from the first request (if any)
            if ($message->requests->isNotEmpty()) {
                $incidentTypeId = optional($message->requests->first()->incidentCase)->incident_type_id;
            }
            
            $result = $this->canMessageMarkAsCompleted($incidentTypeId, $message->id, true);
            $message->can_complete = $result['can_complete'];
            $message->missing_agencies = $result['missing_agencies'];
        }
        
        return view('admin.coastguard.message-cases.index', compact('messages'));
    }
    
    /**
     * Check if all required agencies have responded based on incident type
     * 
     * @param int $incidentTypeId The type of incident
     * @param int $callId The ID of the emergency call
     * @param bool $returnMissing Whether to return missing agencies
     * @return array|bool Result array or boolean
     */
    private function canCallMarkAsCompleted($incidentTypeId, $callId, $returnMissing = false)
    {
        // Define agency names mapping
        $agencyNames = [
            2 => 'PNP',
            3 => 'BFP',
            4 => 'MDRRMO',
            5 => 'MHO',
            6 => 'COAST GUARD',
            7 => 'LGU'
        ];
        
        // If no incident type is specified, complete button should be disabled
        if (!$incidentTypeId) {
            return $returnMissing ? ['can_complete' => false, 'missing_agencies' => []] : false;
        }
        
        // Define required agencies for each incident type
        $requiredAgencies = [
            1 => [2], // CRIME: PNP only
            2 => [2, 4], // ROAD: PNP, MDRRMO
            3 => [5, 4], // HEALTH: MHO, MDRRMO
            4 => [2, 3, 4], // DISASTER: PNP, BFP, MDRRMO
            5 => [6, 4], // SEA: COAST GUARD, MDRRMO
            6 => [3, 4], // FIRE: BFP, MDRRMO
        ];
        
        // Get the required agencies for this incident type
        $mandatoryAgencies = $requiredAgencies[$incidentTypeId] ?? [];
        
        // If no mandatory agencies, default to disabled
        if (empty($mandatoryAgencies)) {
            return $returnMissing ? ['can_complete' => false, 'missing_agencies' => []] : false;
        }
        
        // Get all agencies that have responded to this call
        $respondedAgencies = DB::table('status_log_calls')
            ->join('users', 'status_log_calls.user_id', '=', 'users.id')
            ->where('status_log_calls.call_id', $callId)
            ->where('status_log_calls.status_id', 2) // Status 2 = Responded
            ->pluck('users.agency_id')
            ->toArray();
        
        // Check which mandatory agencies have not responded
        $missingAgencies = [];
        
        foreach ($mandatoryAgencies as $agencyId) {
            if (!in_array($agencyId, $respondedAgencies)) {
                $missingAgencies[] = $agencyNames[$agencyId] ?? "Agency ID $agencyId";
            }
        }
        
        $canComplete = empty($missingAgencies);
        
        if ($returnMissing) {
            return [
                'can_complete' => $canComplete,
                'missing_agencies' => $missingAgencies
            ];
        }
        
        return $canComplete;
    }
    
    private function canMessageMarkAsCompleted($incidentTypeId, $messageId, $returnMissing = false)
    {
        // Define agency names mapping
        $agencyNames = [
            2 => 'PNP',
            3 => 'BFP',
            4 => 'MDRRMO',
            5 => 'MHO',
            6 => 'COAST GUARD',
            7 => 'LGU'
        ];
        
        // If no incident type is specified, complete button should be disabled
        if (!$incidentTypeId) {
            return $returnMissing ? ['can_complete' => false, 'missing_agencies' => []] : false;
        }
        
        // Define required agencies for each incident type
        $requiredAgencies = [
            1 => [2], // CRIME: PNP only
            2 => [2, 4], // ROAD: PNP, MDRRMO
            3 => [5, 4], // HEALTH: MHO, MDRRMO
            4 => [2, 3, 4], // DISASTER: PNP, BFP, MDRRMO
            5 => [6, 4], // SEA: COAST GUARD, MDRRMO
            6 => [3, 4], // FIRE: BFP, MDRRMO
        ];
        
        // Get the required agencies for this incident type
        $mandatoryAgencies = $requiredAgencies[$incidentTypeId] ?? [];
        
        // If no mandatory agencies, default to disabled
        if (empty($mandatoryAgencies)) {
            return $returnMissing ? ['can_complete' => false, 'missing_agencies' => []] : false;
        }
        
        // Get all agencies that have responded to this message
        $respondedAgencies = DB::table('status_log_messages')
            ->join('users', 'status_log_messages.user_id', '=', 'users.id')
            ->where('status_log_messages.message_id', $messageId)
            ->where('status_log_messages.status_id', 2) // Status 2 = Responded
            ->pluck('users.agency_id')
            ->toArray();
        
        // Check which mandatory agencies have not responded
        $missingAgencies = [];
        
        foreach ($mandatoryAgencies as $agencyId) {
            if (!in_array($agencyId, $respondedAgencies)) {
                $missingAgencies[] = $agencyNames[$agencyId] ?? "Agency ID $agencyId";
            }
        }
        
        $canComplete = empty($missingAgencies);
        
        if ($returnMissing) {
            return [
                'can_complete' => $canComplete,
                'missing_agencies' => $missingAgencies
            ];
        }
        
        return $canComplete;
    }
}
