<?php

namespace App\Http\Controllers\Mdrrmo;

use App\Http\Controllers\Controller;
use App\Models\Call;
use App\Models\Message;
use App\Models\IncidentCase;
use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IncidentReportController extends Controller
{
    /**
     * Generate a completed incident report for either a Call or Message
     */
    public function list()
    {
        // Get all incident reports with their relationships
        $reports = IncidentReport::with([
            'incidentCase.incidentType', 
            'user.profile',
            'incidentCase.requestCalls.call', 
            'incidentCase.requestMessages.message'
        ])->orderBy('created_at', 'desc')->get();
        
        // Determine source type for each report
        foreach ($reports as $report) {
            // Check if this incident case is linked to a call
            if ($report->incidentCase->requestCalls()->count() > 0) {
                $report->source_type = 'call';
                $report->source = $report->incidentCase->requestCalls->first()->call;
            } 
            // Check if this incident case is linked to a message
            elseif ($report->incidentCase->requestMessages()->count() > 0) {
                $report->source_type = 'message';
                $report->source = $report->incidentCase->requestMessages->first()->message;
            } 
            // If neither, set as unknown
            else {
                $report->source_type = 'unknown';
                $report->source = null;
            }
        }
        
        return view('admin.mdrrmo.incidents.list', compact('reports'));
    }
    public function generateReport(Request $request, $id)
    {
        // Determine if this is a call or message based ID
        $sourceType = $request->input('source_type', 'call'); // Default to 'call' if not specified
        
        if ($sourceType === 'call') {
            return $this->generateCallReport($request, $id);
        } else if ($sourceType === 'message') {
            return $this->generateMessageReport($request, $id);
        } else {
            return redirect()->back()->with('error', 'Invalid source type specified.');
        }
    }
    
    /**
     * Generate report from a call source
     */
    protected function generateCallReport(Request $request, $callId)
    {
        $call = Call::with(['requests.incidentCase.incidentType', 'status'])->findOrFail($callId);
        
        // Check if call is completed
        if ($call->status_id != 3) {
            return redirect()->back()->with('error', 'Cannot generate report for non-completed cases.');
        }
        
        // Get the incident case(s) associated with this call
        $incidentCases = collect();
        foreach ($call->requests as $requestCall) {
            if ($requestCall->incidentCase) {
                $incidentCases->push($requestCall->incidentCase);
            }
        }
        
        if ($incidentCases->isEmpty()) {
            return redirect()->back()->with('error', 'No incident cases found for this call.');
        }
        
        // For each incident case, create or retrieve a report
        $reports = $this->processIncidentCases($request, $incidentCases, $call, null);
        
        return view('admin.mdrrmo.incidents.index', [
            'call' => $call,
            'message' => null,
            'reports' => $reports,
            'source_type' => 'call'
        ]);
    }
    
    /**
     * Generate report from a message source
     */
    protected function generateMessageReport(Request $request, $messageId)
    {
        $message = Message::with(['requests.incidentCase.incidentType', 'status'])->findOrFail($messageId);
        
        // Check if message is completed
        if ($message->status_id != 3) {
            return redirect()->back()->with('error', 'Cannot generate report for non-completed cases.');
        }
        
        // Get the incident case(s) associated with this message
        $incidentCases = collect();
        foreach ($message->requests as $requestMessage) {
            if ($requestMessage->incidentCase) {
                $incidentCases->push($requestMessage->incidentCase);
            }
        }
        
        if ($incidentCases->isEmpty()) {
            return redirect()->back()->with('error', 'No incident cases found for this message.');
        }
        
        // For each incident case, create or retrieve a report
        $reports = $this->processIncidentCases($request, $incidentCases, null, $message);
        
        return view('admin.mdrrmo.incidents.index', [
            'call' => null,
            'message' => $message,
            'reports' => $reports,
            'source_type' => 'message'
        ]);
    }
    
    /**
     * Process incident cases to generate reports
     */
    /**
 * Process incident cases to generate reports
 */
    protected function processIncidentCases(Request $request, $incidentCases, $call = null, $message = null)
    {
        $reports = [];
        $reportsCreated = 0;
        $reportsUpdated = 0;
        
        foreach ($incidentCases as $case) {
            // Check if report already exists
            $report = IncidentReport::where('incident_case_id', $case->id)->first();
            
            if (!$report) {
                // Create a new report
                $report = new IncidentReport([
                    'incident_case_id' => $case->id,
                    'report_number' => IncidentReport::generateReportNumber($case->id),
                    'generated_by' => Auth::id(),
                    'resolution_details' => $request->input('resolution_details', ''),
                    'resolution_date' => now(),
                ]);
                
                // Make sure the storage directory exists
                if (!Storage::exists('public/incident_report')) {
                    Storage::makeDirectory('public/incident_report');
                }
                
                // Generate PDF and save it
                // Enhanced view data with more details
                $viewData = [
                    'call' => $call,
                    'message' => $message,
                    'case' => $case,
                    'report' => $report,
                ];
                
                // Add additional data for timeline and status logs
                if ($call) {
                    $viewData['statusLogs'] = $call->statusLogCalls;
                    $viewData['source_type'] = 'call';
                } elseif ($message) {
                    $viewData['statusLogs'] = $message->statusLogMessages;
                    $viewData['source_type'] = 'message';
                }
                
                $pdfContent = view('admin.mdrrmo.incidents.view', $viewData)->render();
                
                $pdfFileName = 'report_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $report->report_number) . '.pdf';
                $pdfPath = 'incident_report/' . $pdfFileName; // relative to public/storage
                
                $fullPath = public_path('storage/' . $pdfPath);
                
                // Make sure the directory exists
                if (!file_exists(public_path('storage/incident_report'))) {
                    mkdir(public_path('storage/incident_report'), 0775, true);
                }
                
                // Store the PDF directly
                $pdf = app('dompdf.wrapper');
                $pdf->loadHTML($pdfContent);
                file_put_contents($fullPath, $pdf->output());
                
                Log::info('Saved PDF to: ' . $fullPath);
                
                $report->report_path = $pdfPath; // Save relative path
                $report->save();
                
                $reportsCreated++;
            } else if ($request->has('resolution_details') && $request->input('resolution_details') !== $report->resolution_details) {
                // Update existing report with new resolution details if provided
                $report->resolution_details = $request->input('resolution_details');
                $report->save();
                
                // Regenerate the PDF to reflect the updated resolution details
                $viewData = [
                    'call' => $call,
                    'message' => $message,
                    'case' => $case,
                    'report' => $report,
                ];
                
                // Add additional data for timeline and status logs
                if ($call) {
                    $viewData['statusLogs'] = $call->statusLogCalls;
                    $viewData['source_type'] = 'call';
                } elseif ($message) {
                    $viewData['statusLogs'] = $message->statusLogMessages;
                    $viewData['source_type'] = 'message';
                }
                
                $pdfContent = view('admin.mdrrmo.incidents.view', $viewData)->render();
                
                $fullPath = public_path('storage/' . $report->report_path);
                
                // Store the updated PDF directly
                $pdf = app('dompdf.wrapper');
                $pdf->loadHTML($pdfContent);
                file_put_contents($fullPath, $pdf->output());
                
                Log::info('Updated PDF at: ' . $fullPath);
                
                $reportsUpdated++;
            }
            
            $reports[] = $report;
        }
        
        // Add a flash message indicating how many reports were created or updated
        if ($reportsCreated > 0 || $reportsUpdated > 0) {
            $message = [];
            if ($reportsCreated > 0) {
                $message[] = "{$reportsCreated} new report(s) created";
            }
            if ($reportsUpdated > 0) {
                $message[] = "{$reportsUpdated} existing report(s) updated";
            }
            session()->flash('success', implode(' and ', $message) . ' successfully.');
        } else {
            session()->flash('info', 'All reports were already generated. No new reports created.');
        }
        
        return $reports;
    }
    
    /**
     * View a completed report
     */
    public function viewReport($reportId)
    {
        $report = IncidentReport::with(['incidentCase.incidentType', 'user'])->findOrFail($reportId);
        
        // Check if file exists using the file_exists function since we're saving directly
        $filePath = public_path('storage/' . $report->report_path);
        
        if (!$report->report_path || !file_exists($filePath)) {
            Log::error('Report file not found: ' . $report->report_path);
            Log::error('Checking path: ' . $filePath);
            return redirect()->back()->with('error', 'Report file not found.');
        }
        
        return response()->file($filePath);
    }

    /**
     * Download a completed report
     */
    public function downloadReport($reportId)
    {
        $report = IncidentReport::with(['incidentCase.incidentType', 'user'])->findOrFail($reportId);
        
        // Check if file exists using the file_exists function
        $filePath = public_path('storage/' . $report->report_path);
        
        if (!$report->report_path || !file_exists($filePath)) {
            Log::error('Report file not found: ' . $report->report_path);
            Log::error('Checking path: ' . $filePath);
            return redirect()->back()->with('error', 'Report file not found.');
        }
        
        return response()->download($filePath);
    }
}
