<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LguController extends Controller
{
    public function lguDashboard()
    {
        $user = Auth::user();

        // Fetch reports assigned to PNP (agency_id = 2)
        $reports = Report::whereHas('incidentType', function ($query) {
            $query->whereIn('name', ['ROAD ACCIDENT', 'DISASTER', 'HEALTH EMERGENCY']);
        })->get();
    
        // Count reports by status
        $totalReports = $reports->count();
        $pendingReports = $reports->where('status_id', 1)->count();
        $ongoingReports = $reports->where('status_id', 2)->count();
        $resolvedReports = $reports->where('status_id', 3)->count();
    
        return view('admin.lgu.dashboard', compact('totalReports', 'pendingReports', 'resolvedReports','ongoingReports', 'reports'));
    }

    public function allReports()
    {
        $reports = Report::whereHas('incidentType', function ($query) {
            $query->whereIn('name', ['ROAD ACCIDENT', 'DISASTER', 'HEALTH EMERGENCY']);
        })->orderBy('created_at', 'desc')->get();

        return view('admin.lgu.report.all-report', compact('reports'));
    }
    public function viewReport($id)
    {
        $report = Report::with(['incidentType', 'location', 'status', 'agencies', 'reportAttachments'])->findOrFail($id);
        
        return view('admin.lgu.report.view', compact('report'));
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

    public function markAsResolved($id)
    {
        try {
            $report = Report::findOrFail($id);
            $report->status_id = 3; // 3 = Resolved
            $report->save();

            return redirect()->back()->with('success', 'Report marked as resolved.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update report.');
        }
    }

}
