<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Models\Call;
use App\Models\IncidentType;
use App\Models\Message;
use App\Models\Report;
use App\Models\ReportAttachment;
use App\Models\Role;
use App\Models\StatusLogCall;
use App\Models\StatusLogMessage;
use App\Models\User;
use App\Models\UserContact;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function superAdminDashboard()
    {
        return view('super-admin.dashboard');
    }
    public function usersList()
    {
        $users = User::with('role', 'profile')->get(); // Load users with roles & profile info
        return view('super-admin.users.all-users', compact('users'));
    }
    public function viewUser($id)
    {
        $user = User::with('role', 'profile', 'agency', 'contacts')->findOrFail($id);
        return view('super-admin.users.view', compact('user'));
    }
    public function emergencyMessageList()
    {
        $messages = Message::with(['incidentTypes', 'agencies', 'user', 'status'])->latest()->get();
        // Return view with data
        return view('super-admin.emergency-messages.index', compact('messages'));
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
            'requests.agencies' // Include requests and their assigned agencies, like in viewEmergencyCall
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

        return view('super-admin.emergency-messages.view', compact('message', 'profile'));
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

    //call
    public function emergencyCallList()
    {
        $calls = Call::with([ 'status'])->latest()->get();
        // Return view with data
        return view('super-admin.emergency-calls.index', compact('calls'));
    }
    public function viewEmergencyCall($id)
    {
        $call = Call::with([
            'status',
            'statusLogCalls.user.profile' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'requests.agencies' // Include requests and their assigned agencies
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

        return view('super-admin.emergency-calls.view', compact('call', 'profile'));
    }
    


    public function markAsOngoingForCall($id, Request $request)
    {
        try {
            $call = Call::findOrFail($id);
            $call->status_id = 2; // 2 = Ongoing
            $call->save();

            // Save log entry
            StatusLogCall::create([
                'call_id' => $call->id,
                'status_id' => 2, // Ongoing
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as ongoing.');
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
                'status_id' => 3, // Ongoing
                'user_id' => Auth::id(),
                'log_details' => $request->log_details
            ]);

            return redirect()->back()->with('success', 'Marked as completed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update.');
        }
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
            'agency_id' => 'nullable|exists:agencies,id',
            'contact_number' => 'nullable|string|max:15',
        ]);
    
        // Update user profile
        $user->profile->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);
    
        // Update email & role
        $user->update([
            'email' => $request->email,
            'role_id' => $request->role_id,
            'agency_id' => $request->agency_id,
        ]);
    
        // Update contact number (if exists)
        if ($user->contacts->isNotEmpty()) {
            $user->contacts->first()->update([
                'contact_number' => $request->contact_number,
            ]);
        }
    
        return redirect()->route('superadmin.users.view', $id)->with('success', 'User updated successfully.');
        }
        public function create()
        {
            return view('super-admin.users.add-user', [
                'roles' => Role::all(),
                'agencies' => Agency::all(),
            ]);
        }
        public function store(Request $request)
        {
            // Validate user input
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => ['required', 'confirmed', 'string', 'min:8'],
                'role_id' => 'required|exists:roles,id',
                'agency_id' => 'nullable|exists:agencies,id',
                'firstname' => 'required|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'required|string|max:255',
                'extname' => 'nullable|string|max:50',
                'bday' => 'required|date',
                'contact_number' => 'required|string|max:11',
            ]);
        
            // Create User
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'agency_id' => $request->agency_id ?? null, // Allow null agencies
            ]);
        
            // Create User Profile
            UserProfile::create([
                'user_id' => $user->id,
                'firstname' => $request->firstname,
                'middlename' => $request->middlename,
                'lastname' => $request->lastname,
                'extname' => $request->extname,
                'bday' => $request->bday,
            ]);
        
            // Store Contact Number
            UserContact::create([
                'user_id' => $user->id,
                'contact_number' => $request->contact_number,
            ]);
        
            return redirect()->route('superadmin.users')->with('success', 'User added successfully!');
        }
        public function createReport(){
            return view('super-admin.report.create');
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
        
            return redirect()->route('lgu.reports.index')->with('success', 'Report marked as ongoing.');
        }
    
        public function reportList()
        {
            $reports = Report::with(['incidentType', 'agencies', 'status', 'location', 'reportAttachments'])
                ->whereHas('user', function ($query) {
                    $query->where('agency_id', 7); // Filtering users by agency_id = 2 (lgu)
                })
                ->latest()
                ->get();
        
            return view('super-admin.report.all-report', compact('reports'));
        }
}
