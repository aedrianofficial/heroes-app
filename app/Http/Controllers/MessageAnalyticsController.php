<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;
use App\Models\Message;
use App\Models\RequestMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MessageAnalyticsController extends Controller
{
    public function agencyPerformance(Request $request)
    {
        // Get parameters or use defaults
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $agencyId = $request->input('agency_id');
        
        // First, make sure we have agencies
        $agenciesQuery = Agency::query();
        
        // If agency_id is provided, filter to just that agency
        if ($agencyId) {
            $agenciesQuery->where('id', $agencyId);
        } else {
            // Exclude Default agency only when not specifically requested
            $agenciesQuery->where('id', '!=', 1);
        }
        
        $agencies = $agenciesQuery->get();
        
        // Check if we have any agencies
        if ($agencies->isEmpty()) {
            return response()->json([
                'timeframe' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate
                ],
                'agencies' => [],
                'debug' => 'No agencies found matching the criteria'
            ]);
        }
        
        $results = [];
        
        foreach ($agencies as $agency) {
            // Get requests assigned to this agency
            $agencyRequests = DB::table('request_message_agency')
                ->join('request_messages', 'request_messages.id', '=', 'request_message_agency.request_message_id')
                ->where('request_message_agency.agency_id', $agency->id)
                ->whereBetween('request_messages.created_at', [$startDate, $endDate])
                ->count();
                
            // Get messages processed by this agency (via requests)
            $processedMessages = DB::table('request_message_agency')
                ->join('request_messages', 'request_messages.id', '=', 'request_message_agency.request_message_id')
                ->join('messages', 'messages.id', '=', 'request_messages.message_id')
                ->where('request_message_agency.agency_id', $agency->id)
                ->where('messages.is_processed', true)
                ->whereBetween('request_messages.created_at', [$startDate, $endDate])
                ->count();
                
            // Views count by users of this agency
            $requestViews = DB::table('request_message_views')
                ->join('users', 'users.id', '=', 'request_message_views.user_id')
                ->where('users.agency_id', $agency->id)
                ->whereBetween('request_message_views.created_at', [$startDate, $endDate])
                ->count();
                
            // Most recent activity timestamps
            $lastRequestTimestamp = DB::table('request_message_agency')
                ->join('request_messages', 'request_messages.id', '=', 'request_message_agency.request_message_id')
                ->where('request_message_agency.agency_id', $agency->id)
                ->whereBetween('request_messages.created_at', [$startDate, $endDate])
                ->max('request_messages.created_at');
                
            $lastViewTimestamp = DB::table('request_message_views')
                ->join('users', 'users.id', '=', 'request_message_views.user_id')
                ->where('users.agency_id', $agency->id)
                ->whereBetween('request_message_views.created_at', [$startDate, $endDate])
                ->max('request_message_views.created_at');
            $messageViews = DB::table('message_views')
                ->join('users', 'users.id', '=', 'message_views.user_id')
                ->join('messages', 'messages.id', '=', 'message_views.message_id')
                ->where('users.agency_id', $agency->id)
                ->whereBetween('message_views.created_at', [$startDate, $endDate])
                ->count();   
            $results[] = [
                'agency_id' => $agency->id,
                'agency_name' => $agency->name,
                'total_requests' => $agencyRequests,
                'processed_messages' => $processedMessages,
                'request_views' => $requestViews,
                'message_views' => $messageViews,
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
    
    public function dailyMessageVolume(Request $request)
    {
        $days = $request->input('days', 30);
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        $dailyMessages = Message::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $dailyRequests = RequestMessage::where('created_at', '>=', $startDate)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Get processed vs unprocessed messages
        $messagesByStatus = Message::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'), 
                DB::raw('is_processed'), 
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date', 'is_processed')
            ->orderBy('date')
            ->get();
            
        // Format for easier consumption by frontend
        $processedMessagesByDate = [];
        foreach ($messagesByStatus as $record) {
            if (!isset($processedMessagesByDate[$record->date])) {
                $processedMessagesByDate[$record->date] = [
                    'processed' => 0,
                    'unprocessed' => 0
                ];
            }
            
            if ($record->is_processed) {
                $processedMessagesByDate[$record->date]['processed'] = $record->count;
            } else {
                $processedMessagesByDate[$record->date]['unprocessed'] = $record->count;
            }
        }
        
        return response()->json([
            'daily_messages' => $dailyMessages,
            'daily_requests' => $dailyRequests,
            'messages_by_status' => $processedMessagesByDate
        ]);
    }
    
    public function topAgencies(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $limit = $request->input('limit', 5);
        
        // Top agencies by request count
        $topByRequests = DB::table('request_message_agency')
            ->join('request_messages', 'request_messages.id', '=', 'request_message_agency.request_message_id')
            ->join('agencies', 'agencies.id', '=', 'request_message_agency.agency_id')
            ->whereBetween('request_messages.created_at', [$startDate, $endDate])
            ->select('agencies.id', 'agencies.name', DB::raw('COUNT(*) as request_count'))
            ->groupBy('agencies.id', 'agencies.name')
            ->orderBy('request_count', 'DESC')
            ->limit($limit)
            ->get();
            
        // Top agencies by view activity
        $topByRequestViews = DB::table('request_message_views')
            ->join('users', 'users.id', '=', 'request_message_views.user_id')
            ->join('agencies', 'agencies.id', '=', 'users.agency_id')
            ->whereBetween('request_message_views.created_at', [$startDate, $endDate])
            ->select('agencies.id', 'agencies.name', DB::raw('COUNT(*) as view_count'))
            ->groupBy('agencies.id', 'agencies.name')
            ->orderBy('view_count', 'DESC')
            ->limit($limit)
            ->get();
        $topByMessageViews = DB::table('message_views')
            ->join('users', 'users.id', '=', 'message_views.user_id')
            ->join('agencies', 'agencies.id', '=', 'users.agency_id')
            ->whereBetween('message_views.created_at', [$startDate, $endDate])
            ->select('agencies.id', 'agencies.name', DB::raw('COUNT(*) as message_view_count'))
            ->groupBy('agencies.id', 'agencies.name')
            ->orderBy('message_view_count', 'DESC')
            ->limit($limit)
            ->get();   
        return response()->json([
            'timeframe' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ],
            'top_by_requests' => $topByRequests,
            'top_by_views' => $topByRequestViews,
            'top_by_message_views' => $topByMessageViews,
        ]);
    }
    
    public function messagesStatusDistribution(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Distribution of messages by status
        $statusDistribution = Message::whereBetween('messages.created_at', [$startDate, $endDate])
                        ->join('statuses', 'statuses.id', '=', 'messages.status_id')
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
