<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Call;
use App\Models\RequestCall;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function agencyPerformance(Request $request)
    {
        // Get parameters or use defaults
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $agencyId = $request->input('agency_id');
        
        // Base query for request calls
        $query = RequestCall::whereBetween('created_at', [$startDate, $endDate]);
        
        // Filter by agency if specified
        if ($agencyId) {
            $query->whereHas('agencies', function($q) use ($agencyId) {
                $q->where('agency_id', $agencyId);
            });
        }
        
        // Get all agencies or a specific one
        $agencies = $agencyId 
            ? Agency::where('id', $agencyId)->get() 
            : Agency::all();
            
        $results = [];
        
        foreach ($agencies as $agency) {
            // Get requests assigned to this agency
            $agencyRequests = DB::table('request_call_agency')
                ->join('request_calls', 'request_calls.id', '=', 'request_call_agency.request_call_id')
                ->where('request_call_agency.agency_id', $agency->id)
                ->whereBetween('request_calls.created_at', [$startDate, $endDate])
                ->count();
                
            // Get calls processed by this agency (via requests)
            $processedCalls = DB::table('request_call_agency')
                ->join('request_calls', 'request_calls.id', '=', 'request_call_agency.request_call_id')
                ->join('calls', 'calls.id', '=', 'request_calls.call_id')
                ->where('request_call_agency.agency_id', $agency->id)
                ->where('calls.is_processed', true)
                ->whereBetween('request_calls.created_at', [$startDate, $endDate])
                ->count();
                
            // Views count by users of this agency
            $requestViews = DB::table('request_call_views')
                ->join('users', 'users.id', '=', 'request_call_views.user_id')
                ->where('users.agency_id', $agency->id)
                ->whereBetween('request_call_views.created_at', [$startDate, $endDate])
                ->count();
                
            // Most recent activity timestamps
            $lastRequestTimestamp = DB::table('request_call_agency')
                ->join('request_calls', 'request_calls.id', '=', 'request_call_agency.request_call_id')
                ->where('request_call_agency.agency_id', $agency->id)
                ->whereBetween('request_calls.created_at', [$startDate, $endDate])
                ->max('request_calls.created_at');
                
            $lastViewTimestamp = DB::table('request_call_views')
                ->join('users', 'users.id', '=', 'request_call_views.user_id')
                ->where('users.agency_id', $agency->id)
                ->whereBetween('request_call_views.created_at', [$startDate, $endDate])
                ->max('request_call_views.created_at');
                
            $results[] = [
                'agency_id' => $agency->id,
                'agency_name' => $agency->name,
                'total_requests' => $agencyRequests,
                'processed_calls' => $processedCalls,
                'request_views' => $requestViews,
                'views_per_request' => $agencyRequests > 0 ? round($requestViews / $agencyRequests, 2) : 0,
                'last_activity' => $lastViewTimestamp ?? $lastRequestTimestamp ?? null
            ];
        }
        
        return response()->json([
            'timeframe' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ],
            'agencies' => $results
        ]);
    }
    
    public function dailyCallVolume(Request $request)
    {
        $days = $request->input('days', 30);
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        $dailyCalls = Call::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $dailyRequests = RequestCall::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Get processed vs unprocessed calls
        $callsByStatus = Call::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('is_processed'), 
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date', 'is_processed')
            ->orderBy('date')
            ->get();
            
        // Format for easier consumption by frontend
        $processedCallsByDate = [];
        foreach ($callsByStatus as $record) {
            if (!isset($processedCallsByDate[$record->date])) {
                $processedCallsByDate[$record->date] = [
                    'processed' => 0,
                    'unprocessed' => 0
                ];
            }
            
            if ($record->is_processed) {
                $processedCallsByDate[$record->date]['processed'] = $record->count;
            } else {
                $processedCallsByDate[$record->date]['unprocessed'] = $record->count;
            }
        }
        
        return response()->json([
            'daily_calls' => $dailyCalls,
            'daily_requests' => $dailyRequests,
            'calls_by_status' => $processedCallsByDate
        ]);
    }
    
    public function topAgencies(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $limit = $request->input('limit', 5);
        
        // Top agencies by request count
        $topByRequests = DB::table('request_call_agency')
            ->join('request_calls', 'request_calls.id', '=', 'request_call_agency.request_call_id')
            ->join('agencies', 'agencies.id', '=', 'request_call_agency.agency_id')
            ->whereBetween('request_calls.created_at', [$startDate, $endDate])
            ->select('agencies.id', 'agencies.name', DB::raw('COUNT(*) as request_count'))
            ->groupBy('agencies.id', 'agencies.name')
            ->orderBy('request_count', 'DESC')
            ->limit($limit)
            ->get();
            
        // Top agencies by view activity
        $topByViews = DB::table('request_call_views')
            ->join('users', 'users.id', '=', 'request_call_views.user_id')
            ->join('agencies', 'agencies.id', '=', 'users.agency_id')
            ->whereBetween('request_call_views.created_at', [$startDate, $endDate])
            ->select('agencies.id', 'agencies.name', DB::raw('COUNT(*) as view_count'))
            ->groupBy('agencies.id', 'agencies.name')
            ->orderBy('view_count', 'DESC')
            ->limit($limit)
            ->get();
            
        return response()->json([
            'timeframe' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ],
            'top_by_requests' => $topByRequests,
            'top_by_views' => $topByViews
        ]);
    }
    
    public function callsStatusDistribution(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Distribution of calls by status
        $statusDistribution = Call::whereBetween('created_at', [$startDate, $endDate])
            ->join('statuses', 'statuses.id', '=', 'calls.status_id')
            ->select('statuses.id', 'statuses.name', DB::raw('COUNT(*) as count'))
            ->groupBy('statuses.id', 'statuses.name')
            ->orderBy('count', 'DESC')
            ->get();
            
        // Get total for percentage calculation
        $total = $statusDistribution->sum('count');
        
        // Add percentage to each status
        $statusDistribution = $statusDistribution->map(function ($item) use ($total) {
            $item->percentage = $total > 0 ? round(($item->count / $total) * 100, 2) : 0;
            return $item;
        });
        
        return response()->json([
            'timeframe' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ],
            'status_distribution' => $statusDistribution,
            'total' => $total
        ]);
    }
}
