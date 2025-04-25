<!DOCTYPE html>
<html>

<head>
    <title>Incident Report: {{ $report->report_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 30px;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            border-radius: 4px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #e1e1e1;
            padding-bottom: 20px;
        }

        .header h1 {
            margin-bottom: 5px;
            color: #333;
            font-weight: 600;
        }

        .header h2 {
            color: #555;
            font-weight: 500;
            margin-top: 0;
        }

        .report-meta {
            margin-bottom: 15px;
            font-size: 0.9em;
            color: #666;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            border-bottom: 1px solid #e1e1e1;
            padding-bottom: 8px;
            color: #333;
            font-size: 1.3em;
            font-weight: 500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #e1e1e1;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: 500;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #e1e1e1;
            padding-top: 20px;
        }

        .signatures {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature-line {
            width: 45%;
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }

        .highlight {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 3px solid #555;
            margin-bottom: 15px;
        }

        /* Improved timeline styling */
        .timeline {
            position: relative;
            padding-left: 30px;
            margin-left: 10px;
            border-left: 1px solid #e1e1e1;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #f0f0f0;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -36px;
            top: 5px;
            height: 10px;
            width: 10px;
            border-radius: 50%;
            background: #555;
            border: 2px solid #fff;
            box-shadow: 0 0 0 1px #e1e1e1;
        }

        .timeline-item .time-stamp {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .timeline-item .status-update {
            margin-bottom: 5px;
        }

        .timeline-item .log-details {
            color: #555;
            margin-top: 5px;
            padding-left: 5px;
            border-left: 2px solid #f0f0f0;
        }

        .badge {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 500;
            color: #fff;
        }

        .bg-danger {
            background-color: #dc3545;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #333;
        }

        .bg-success {
            background-color: #28a745;
        }

        /* Improvements for responding agencies section */
        .agencies-table {
            border-collapse: collapse;
            width: 100%;
        }

        .agencies-table th {
            background-color: #f5f5f5;
            border: 1px solid #e1e1e1;
            padding: 12px;
            text-align: left;
        }

        .agencies-table td {
            border: 1px solid #e1e1e1;
            padding: 12px;
        }

        .agencies-table tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>HEROES APP</h1>
            <h2>INCIDENT RESOLUTION REPORT</h2>
            <div class="report-meta">
                <p><strong>Report Number:</strong> {{ $report->report_number }}</p>
                <p><strong>Generated on:</strong> {{ now()->format('F j, Y h:i A') }}</p>
            </div>
        </div>

        <div class="section">
            <h2>Incident Information</h2>
            <table>
                <tr>
                    <th>Case Number:</th>
                    <td>{{ $case->case_number }}</td>
                    <th>Incident Type:</th>
                    <td>{{ $case->incidentType->name }}</td>
                </tr>
                <tr>
                    <th>Source Type:</th>
                    <td>{{ $call ? 'Emergency Call' : 'Emergency Message' }}</td>
                    <th>Source Date:</th>
                    <td>
                        @if ($call)
                            {{ $call->created_at->format('F j, Y h:i A') }}
                        @elseif($message)
                            {{ $message->created_at->format('F j, Y h:i A') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Incident Status:</th>
                    <td>Resolved</td>
                    <th>Resolution Date:</th>
                    <td>{{ $report->resolution_date->format('F j, Y h:i A') }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Reporter Information</h2>
            <table>
                @if ($call)
                    <tr>
                        <th>Caller Contact:</th>
                        <td>{{ $call->caller_contact }}</td>
                        @if ($call->caller_description)
                            <th>Call Description:</th>
                            <td>{{ $call->caller_description }}</td>
                        @else
                            <th>Status at Time of Call:</th>
                            <td>Emergency</td>
                        @endif
                    </tr>
                @elseif($message)
                    <tr>
                        <th>Sender Contact:</th>
                        <td>{{ $message->sender_contact }}</td>
                        <th>Message Type:</th>
                        <td>{{ $message->sender_type }}</td>
                    </tr>
                    <tr>
                        <th>Message Content:</th>
                        <td colspan="3">{{ $message->message_content }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="section">
            <h2>Incident Location & Details</h2>
            <table>
                <tr>
                    <th>Location:</th>
                    <td>
                        @if ($call)
                            {{ $call->requests->where('incident_case_id', $case->id)->first()->address ?? 'N/A' }}
                        @elseif($message)
                            {{ $message->requests->where('incident_case_id', $case->id)->first()->address ?? 'N/A' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td>
                        @if ($call)
                            {{ $call->requests->where('incident_case_id', $case->id)->first()->description ?? 'N/A' }}
                        @elseif($message)
                            {{ $message->requests->where('incident_case_id', $case->id)->first()->description ?? 'N/A' }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Response Timeline</h2>
            <div class="timeline">
                @if ($call)
                    @foreach ($call->statusLogCalls->sortBy('created_at') as $log)
                        <div class="timeline-item">
                            <div class="time-stamp">{{ $log->created_at->format('F j, Y h:i A') }}</div>
                            <div class="status-update">
                                Status changed to <span class="badge bg-{{ $log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning' : 'success') }}">
                                    {{ $log->status->name }}
                                </span> by
                                {{ $log->user->profile->firstname . ' ' . $log->user->profile->lastname ?? 'System' }}
                            </div>
                            <div class="log-details">{{ $log->log_details }}</div>
                        </div>
                    @endforeach
                @elseif($message)
                    @foreach ($message->statusLogMessages->sortBy('created_at') as $log)
                        <div class="timeline-item">
                            <div class="time-stamp">{{ $log->created_at->format('F j, Y h:i A') }}</div>
                            <div class="status-update">
                                Status changed to <span class="badge bg-{{ $log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning' : 'success') }}">
                                    {{ $log->status->name }}
                                </span> by
                                {{ $log->user->profile->firstname . ' ' . $log->user->profile->lastname ?? 'System' }}
                            </div>
                            <div class="log-details">{{ $log->log_details }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="section">
            <h2>Responding Agencies</h2>
            <table class="agencies-table">
                <tr>
                    <th>Agency</th>
                    <th>Latest Response Time</th>
                    <th>Latest Status</th>
                    <th>Responded By</th>
                </tr>

                @php
                    $logs = collect();

                    if ($call) {
                        $logs = $call->statusLogCalls; // Removed the where('incident_case_id') condition
                    } elseif ($message) {
                        $logs = $message->statusLogMessages;
                    }

                    $agencyLogs = $logs->groupBy('agency_id');
                @endphp


                @foreach ($agencyLogs as $agencyId => $logsForAgency)
                    @php
                        $latestLog = $logsForAgency->sortByDesc('created_at')->first();

                        // If agency_id exists
                        $agencyName = \App\Models\Agency::find($agencyId)?->name;

                        // Fallback: get agency from user (if agency_id is null or invalid)
                        if (!$agencyName && $latestLog->user && $latestLog->user->agency) {
                            $agencyName = $latestLog->user->agency->name;
                        }

                        $agencyName = $agencyName ?? 'Unknown Agency';

                        $personnel =
                            $latestLog->user && $latestLog->user->profile
                                ? $latestLog->user->profile->firstname . ' ' . $latestLog->user->profile->lastname
                                : $latestLog->user->profile->firstname . ' ' . $latestLog->user->profile->lastname ??
                                    'System';
                    @endphp


                    <tr>
                        <td>{{ $agencyName }}</td>
                        <td>{{ $latestLog->created_at->format('F j, Y h:i A') }}</td>
                        <td>{{ $latestLog->status->name }}</td>
                        <td>{{ $personnel }}</td>
                    </tr>
                @endforeach

                @if ($agencyLogs->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center;">No agency responses recorded for this case.</td>
                    </tr>
                @endif
            </table>
        </div>


        <div class="section">
            <h2>Resolution Details</h2>
            <div class="highlight">
                {{ $report->resolution_details }}
            </div>
        </div>

        <div class="signatures">
            <div class="signature-line">
                <p>Prepared by:</p>
                <p><strong>{{ $report->user->profile->firstname . ' ' . $report->user->profile->lastname }}</strong></p>
                <p>{{ Auth::user()->agency->name }} Officer</p>
            </div>

            <div class="signature-line">
                <p>Verified by:</p>
                <p><strong>_______________________</strong></p>
                <p>MDRRMO Head</p>
            </div>
        </div>

        <div class="footer">
            <p>This is an official document generated by the Heroes App.</p>
            <p>Report generated on: {{ now()->format('F j, Y h:i A') }}</p>
            <p>Report ID: {{ $report->id }} | Case ID: {{ $case->id }}</p>
        </div>
    </div>
</body>

</html>