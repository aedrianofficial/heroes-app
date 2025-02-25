<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'agency_id' => 'required|exists:agencies,id',
            'report_attachments' => 'nullable',
            'report_attachments.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $report = Report::create([
            'user_id' => Auth::id(),
            'agency_id' => $request->agency_id,
            'title' => $request->title,
            'description' => $request->description,
            'status_id' => 1, // Default to Pending
        ]);
    
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
    
        return redirect()->route('user.reports.index')->with('success', 'Report submitted successfully.');
    }
    
    

    public function index()
    {
        $reports = Report::where('user_id', Auth::id())->latest()->get();
        return view('user.report.index', compact('reports'));
    }
}
