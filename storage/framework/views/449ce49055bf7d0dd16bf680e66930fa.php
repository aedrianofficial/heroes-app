<!DOCTYPE html>
<html>

<head>
    <title>Incident Report: <?php echo e($report->report_number); ?></title>
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
                <p><strong>Report Number:</strong> <?php echo e($report->report_number); ?></p>
                <p><strong>Generated on:</strong> <?php echo e(now()->format('F j, Y h:i A')); ?></p>
            </div>
        </div>

        <div class="section">
            <h2>Incident Information</h2>
            <table>
                <tr>
                    <th>Case Number:</th>
                    <td><?php echo e($case->case_number); ?></td>
                    <th>Incident Type:</th>
                    <td><?php echo e($case->incidentType->name); ?></td>
                </tr>
                <tr>
                    <th>Source Type:</th>
                    <td><?php echo e($call ? 'Emergency Call' : 'Emergency Message'); ?></td>
                    <th>Source Date:</th>
                    <td>
                        <?php if($call): ?>
                            <?php echo e($call->created_at->format('F j, Y h:i A')); ?>

                        <?php elseif($message): ?>
                            <?php echo e($message->created_at->format('F j, Y h:i A')); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Incident Status:</th>
                    <td>Resolved</td>
                    <th>Resolution Date:</th>
                    <td><?php echo e($report->resolution_date->format('F j, Y h:i A')); ?></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Reporter Information</h2>
            <table>
                <?php if($call): ?>
                    <tr>
                        <th>Caller Contact:</th>
                        <td><?php echo e($call->caller_contact); ?></td>
                        <?php if($call->caller_description): ?>
                            <th>Call Description:</th>
                            <td><?php echo e($call->caller_description); ?></td>
                        <?php else: ?>
                            <th>Status at Time of Call:</th>
                            <td>Emergency</td>
                        <?php endif; ?>
                    </tr>
                <?php elseif($message): ?>
                    <tr>
                        <th>Sender Contact:</th>
                        <td><?php echo e($message->sender_contact); ?></td>
                        <th>Message Type:</th>
                        <td><?php echo e($message->sender_type); ?></td>
                    </tr>
                    <tr>
                        <th>Message Content:</th>
                        <td colspan="3"><?php echo e($message->message_content); ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <div class="section">
            <h2>Incident Location & Details</h2>
            <table>
                <tr>
                    <th>Location:</th>
                    <td>
                        <?php if($call): ?>
                            <?php echo e($call->requests->where('incident_case_id', $case->id)->first()->address ?? 'N/A'); ?>

                        <?php elseif($message): ?>
                            <?php echo e($message->requests->where('incident_case_id', $case->id)->first()->address ?? 'N/A'); ?>

                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Description:</th>
                    <td>
                        <?php if($call): ?>
                            <?php echo e($call->requests->where('incident_case_id', $case->id)->first()->description ?? 'N/A'); ?>

                        <?php elseif($message): ?>
                            <?php echo e($message->requests->where('incident_case_id', $case->id)->first()->description ?? 'N/A'); ?>

                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Response Timeline</h2>
            <div class="timeline">
                <?php if($call): ?>
                    <?php $__currentLoopData = $call->statusLogCalls->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item">
                            <div class="time-stamp"><?php echo e($log->created_at->format('F j, Y h:i A')); ?></div>
                            <div class="status-update">
                                Status changed to <span class="badge bg-<?php echo e($log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning' : 'success')); ?>">
                                    <?php echo e($log->status->name); ?>

                                </span> by
                                <?php echo e($log->user->profile->firstname . ' ' . $log->user->profile->lastname ?? 'System'); ?>

                            </div>
                            <div class="log-details"><?php echo e($log->log_details); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php elseif($message): ?>
                    <?php $__currentLoopData = $message->statusLogMessages->sortBy('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="timeline-item">
                            <div class="time-stamp"><?php echo e($log->created_at->format('F j, Y h:i A')); ?></div>
                            <div class="status-update">
                                Status changed to <span class="badge bg-<?php echo e($log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning' : 'success')); ?>">
                                    <?php echo e($log->status->name); ?>

                                </span> by
                                <?php echo e($log->user->profile->firstname . ' ' . $log->user->profile->lastname ?? 'System'); ?>

                            </div>
                            <div class="log-details"><?php echo e($log->log_details); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
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

                <?php
                    $logs = collect();

                    if ($call) {
                        $logs = $call->statusLogCalls; // Removed the where('incident_case_id') condition
                    } elseif ($message) {
                        $logs = $message->statusLogMessages;
                    }

                    $agencyLogs = $logs->groupBy('agency_id');
                ?>


                <?php $__currentLoopData = $agencyLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agencyId => $logsForAgency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
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
                    ?>


                    <tr>
                        <td><?php echo e($agencyName); ?></td>
                        <td><?php echo e($latestLog->created_at->format('F j, Y h:i A')); ?></td>
                        <td><?php echo e($latestLog->status->name); ?></td>
                        <td><?php echo e($personnel); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($agencyLogs->isEmpty()): ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No agency responses recorded for this case.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>


        <div class="section">
            <h2>Resolution Details</h2>
            <div class="highlight">
                <?php echo e($report->resolution_details); ?>

            </div>
        </div>

        <div class="signatures">
            <div class="signature-line">
                <p>Prepared by:</p>
                <p><strong><?php echo e($report->user->profile->firstname . ' ' . $report->user->profile->lastname); ?></strong></p>
                <p><?php echo e(Auth::user()->agency->name); ?> Officer</p>
            </div>

            <div class="signature-line">
                <p>Verified by:</p>
                <p><strong>_______________________</strong></p>
                <p>MDRRMO Head</p>
            </div>
        </div>

        <div class="footer">
            <p>This is an official document generated by the Heroes App.</p>
            <p>Report generated on: <?php echo e(now()->format('F j, Y h:i A')); ?></p>
            <p>Report ID: <?php echo e($report->id); ?> | Case ID: <?php echo e($case->id); ?></p>
        </div>
    </div>
</body>

</html><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/bfp/incidents/view.blade.php ENDPATH**/ ?>