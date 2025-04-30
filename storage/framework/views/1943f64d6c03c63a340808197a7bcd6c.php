<!--call-->

<?php $__env->startSection('content'); ?>
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column: Call and Caller Information -->
                            <div class="col-md-6 border-end">
                                <div class="px-4">
                                    <h3 class="mb-4 text-primary">Call Details</h3>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <h5 class="text-muted">Caller Contact</h5>
                                            <p class="text-dark"><?php echo e($call->caller_contact); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-muted">Date Received</h5>
                                            <p class="text-dark"><?php echo e($call->created_at->format('F j, Y g:i A')); ?></p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-muted">Status</h5>
                                        <span
                                            class="badge bg-<?php echo e($call->status_id == 1 ? 'danger' : ($call->status_id == 2 ? 'warning text-dark' : 'success')); ?> px-3 py-2">
                                            <?php echo e($call->status->name); ?>

                                        </span>
                                    </div>

                                    <?php if($call->caller_description): ?>
                                        <div class="mb-3">
                                            <h5 class="text-muted">Caller Description</h5>
                                            <p class="text-dark"><?php echo e($call->caller_description); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <hr>

                                    <h3 class="mb-4 text-primary">Caller Profile</h3>
                                    <?php if($profile): ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Name:</strong> <?php echo e($profile->first_name); ?>

                                                    <?php echo e($profile->middle_name); ?> <?php echo e($profile->last_name); ?>

                                                    <?php echo e($profile->suffix); ?></p>
                                                <p><strong>Sex:</strong> <?php echo e($profile->sex); ?></p>
                                                <p><strong>Marital Status:</strong> <?php echo e($profile->marital_status); ?></p>
                                            </div>
                                            <div class="col-6">
                                                <p><strong>Zone:</strong> <?php echo e($profile->zone); ?></p>
                                                <p><strong>Barangay:</strong> <?php echo e($profile->nameofbarangay); ?></p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted">No profile information available.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Right Column: Requests and Status Log -->
                            <div class="col-md-6">
                                <div class="px-4">
                                    <h3 class="mb-4 text-primary">Requests</h3>
                                    <?php if($call->requests->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $call->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="card mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title text-muted">Request <?php echo e($index + 1); ?></h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p><strong>Name:</strong> <?php echo e($request->name); ?></p>
                                                            <p><strong>Address:</strong> <?php echo e($request->address); ?></p>
                                                            <p><strong>Description:</strong> <?php echo e($request->description); ?>

                                                            </p>
                                                            <p><strong>Time:</strong>
                                                                <?php echo e($request->created_at->format('F j, Y g:i A')); ?></p>
                                                        </div>
                                                        <div class="col-6">
                                                            <h6 class="text-muted">Assigned Agencies</h6>
                                                            <?php if($request->agencies->isNotEmpty()): ?>
                                                                <ul class="list-unstyled">
                                                                    <?php $__currentLoopData = $request->agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li><?php echo e($agency->name); ?></li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                            <?php else: ?>
                                                                <p class="text-muted">No assigned agencies</p>
                                                            <?php endif; ?>

                                                            <?php if($request->incidentCase): ?>
                                                                <h6 class="text-muted mt-3">Incident Case</h6>
                                                                <p><strong>Case Number:</strong>
                                                                    <?php echo e($request->incidentCase->case_number); ?></p>
                                                            <?php else: ?>
                                                                <p class="text-muted">No Incident Case Assigned</p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <p class="text-muted">No requests found for this call.</p>
                                    <?php endif; ?>

                                    <hr>

                                    <h3 class="mb-4 text-primary">Status Log</h3>
                                    <?php if($call->statusLogCalls->isNotEmpty()): ?>
                                        <div class="list-group">
                                            <?php $__currentLoopData = $call->statusLogCalls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="list-group-item list-group-item-action mb-2">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <?php if($log->user && $log->user->agency_id): ?>
                                                                <?php
                                                                    $agencyLogoPath = '';
                                                                    switch ($log->user->agency_id) {
                                                                        case 2:
                                                                            $agencyLogoPath = 'pnp-logo.png';
                                                                            break;
                                                                        case 3:
                                                                            $agencyLogoPath = 'bfp-logo.png';
                                                                            break;
                                                                        case 4:
                                                                            $agencyLogoPath = 'mdrrmo-logo.jpg';
                                                                            break;
                                                                        case 5:
                                                                            $agencyLogoPath = 'mho-logo.jpg';
                                                                            break;
                                                                        case 6:
                                                                            $agencyLogoPath = 'coastguard-logo.png';
                                                                            break;
                                                                        case 7:
                                                                            $agencyLogoPath = 'lgu-logo.jpg';
                                                                            break;
                                                                        default:
                                                                            $agencyLogoPath = '';
                                                                    }
                                                                ?>

                                                                <?php if($agencyLogoPath): ?>
                                                                    <img src="<?php echo e(asset('asset/image/logo/' . $agencyLogoPath)); ?>"
                                                                        alt="Agency Logo" class="me-2"
                                                                        style="height: 24px; width: auto;">
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <h5 class="mb-0">
                                                                <?php echo e($log->user->profile->firstname ?? 'Unknown User'); ?>

                                                                <?php echo e($log->user->profile->lastname ?? 'Unknown User'); ?>

                                                            </h5>
                                                        </div>
                                                        <small><?php echo e($log->created_at->format('F j, Y g:i A')); ?></small>
                                                    </div>
                                                    <p class="mb-1 mt-2">
                                                        Marked as
                                                        <span
                                                            class="badge bg-<?php echo e($log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning text-dark' : 'success')); ?>">
                                                            <?php echo e($log->status->name); ?>

                                                        </span>
                                                    </p>
                                                    <small><strong>Log Details:</strong> <?php echo e($log->log_details); ?></small>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted">No status logs available.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('superadmin.emergencycall.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="respondedForm-<?php echo e($call->id); ?>"
                                action="<?php echo e(route('superadmin.emergencycall.responded', $call->id)); ?>" method="POST"
                                class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="call_id" value="<?php echo e($call->id); ?>">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="<?php echo e($call->status_id == 3 ? 'This case is already completed' : ($call->requests->isNotEmpty() ? 'Mark as responded' : 'No requests to respond to')); ?>">
                                    <button type="button"
                                        onclick="confirmResponded(event, 'respondedForm-<?php echo e($call->id); ?>')"
                                        class="btn btn-sm btn-warning action-btn"
                                        <?php echo e($call->status_id == 3 || $call->requests->isEmpty() ? 'disabled' : ''); ?>>
                                        Responded
                                    </button>
                                </span>
                            </form>

                            <form id="completeForm-<?php echo e($call->id); ?>"
                                action="<?php echo e(route('superadmin.emergencycall.complete', $call->id)); ?>" method="POST"
                                class="d-inline">
                                <?php echo csrf_field(); ?>
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="<?php echo e($call->status_id == 3 ? 'This case is already completed' : ($call->requests->isEmpty() ? 'No requests to complete' : ($call->can_complete ? 'Mark as Complete' : 'Required agencies must respond first' . (!empty($call->missing_agencies) ? ' (' . implode(', ', $call->missing_agencies) . ')' : '')))); ?>">
                                    <button type="button"
                                        onclick="confirmComplete(event, 'completeForm-<?php echo e($call->id); ?>')"
                                        class="btn btn-sm btn-success action-btn"
                                        <?php echo e($call->status_id == 3 || $call->requests->isEmpty() ? 'disabled' : ($call->can_complete ? '' : 'disabled')); ?>>
                                        Complete
                                    </button>
                                </span>
                            </form>
                            <?php if($call->status_id == 3): ?>
                                <?php
                                    $allCasesHaveReports = true;
                                    $caseIds = [];
                                    $reportsInfo = [];

                                    // Collect all incident case IDs for this call
                                    foreach ($call->requests as $request) {
                                        if ($request->incidentCase) {
                                            $caseIds[] = $request->incidentCase->id;

                                            // Check if this case has a report and store report info
                                            $report = \App\Models\IncidentReport::where(
                                                'incident_case_id',
                                                $request->incidentCase->id,
                                            )->first();
                                            if ($report) {
                                                $reportsInfo[] = [
                                                    'id' => $report->id,
                                                    'case_number' => $request->incidentCase->case_number,
                                                ];
                                            }
                                        }
                                    }

                                    // Check if each case already has a report
                                    if (!empty($caseIds)) {
                                        foreach ($caseIds as $caseId) {
                                            $reportExists = \App\Models\IncidentReport::where(
                                                'incident_case_id',
                                                $caseId,
                                            )->exists();
                                            if (!$reportExists) {
                                                $allCasesHaveReports = false;
                                                break;
                                            }
                                        }
                                    } else {
                                        // No cases, so can't generate report
                                        $allCasesHaveReports = true;
                                    }
                                ?>

                                <span class="d-inline-block">
                                    <?php if(!$allCasesHaveReports): ?>
                                        <button type="button" class="btn btn-sm btn-primary action-btn"
                                            data-bs-toggle="modal" data-bs-target="#generateReportModal">
                                            Generate Report
                                        </button>
                                    <?php else: ?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-secondary action-btn" disabled
                                                title="Reports already generated for all cases">
                                                Reports Generated
                                            </button>

                                            <?php if(!empty($reportsInfo)): ?>
                                                <button type="button"
                                                    class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="visually-hidden">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <?php $__currentLoopData = $reportsInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reportInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="dropdown-item-text">
                                                            <small class="text-muted">Case
                                                                #<?php echo e($reportInfo['case_number']); ?></small>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('superadmin.incident_reports.view', $reportInfo['id'])); ?>"
                                                                target="_blank">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="<?php echo e(route('superadmin.incident_reports.download', $reportInfo['id'])); ?>">
                                                                <i class="fas fa-download me-1"></i> Download
                                                            </a>
                                                        </li>
                                                        <?php if(!$loop->last): ?>
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <!--Initialize tooltips-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <!--sweet alert-->
    <!--Mark as Responded-->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successCall = "<?php echo e(session('success')); ?>";
            let errorCall = "<?php echo e(session('error')); ?>";

            if (successCall) {
                Swal.fire({
                    title: "Success!",
                    text: successCall,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorCall) {
                Swal.fire({
                    title: "Error!",
                    text: errorCall,
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        function confirmResponded(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this case as responded?",
                icon: "warning",
                input: "textarea",
                inputLabel: "Log Details",
                inputPlaceholder: "Enter log details here...",
                inputAttributes: {
                    required: true
                },
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as responded!",
                customClass: {
                    confirmButton: 'text-dark'
                },
                preConfirm: (logDetails) => {
                    if (!logDetails) {
                        Swal.showValidationMessage("Log details are required!");
                    }
                    return logDetails;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById(formId);
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "log_details";
                    input.value = result.value;
                    form.appendChild(input);

                    form.submit();
                }
            });
        }
    </script>

    <!--Mark as Completed-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successCall = "<?php echo e(session('success')); ?>";
            let errorCall = "<?php echo e(session('error')); ?>";

            if (successCall) {
                Swal.fire({
                    title: "Success!",
                    text: successCall,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorCall) {
                Swal.fire({
                    title: "Error!",
                    text: errorCall,
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });


        function confirmComplete(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this case as completed?",
                icon: "warning",
                input: "textarea",
                inputLabel: "Log Details",
                inputPlaceholder: "Enter log details here...",
                inputAttributes: {
                    required: true
                },
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as completed!",
                preConfirm: (logDetails) => {
                    if (!logDetails) {
                        Swal.showValidationMessage("Log details are required!");
                    }
                    return logDetails;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById(formId);
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "log_details";
                    input.value = result.value;
                    form.appendChild(input);

                    form.submit();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/super-admin/emergency-calls/view.blade.php ENDPATH**/ ?>