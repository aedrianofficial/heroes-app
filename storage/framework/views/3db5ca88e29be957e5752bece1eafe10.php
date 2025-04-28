<!--message-->


<?php $__env->startSection('content'); ?>
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column: Message and Sender Information -->
                            <div class="col-md-6 border-end">
                                <div class="px-4">
                                    <h3 class="mb-4 text-primary">Message Details</h3>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <h5 class="text-muted">Sender Contact</h5>
                                            <p class="text-dark"><?php echo e($message->sender_contact); ?></p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-muted">Date Received</h5>
                                            <p class="text-dark"><?php echo e($message->created_at->format('F j, Y g:i A')); ?></p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-muted">Status</h5>
                                        <span
                                            class="badge bg-<?php echo e($message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success')); ?> px-3 py-2">
                                            <?php echo e($message->status->name); ?>

                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-muted">Message Content</h5>
                                        <p class="text-dark"><?php echo e($message->message_content); ?></p>
                                    </div>

                                    <hr>

                                    <h3 class="mb-4 text-primary">Sender Profile</h3>
                                    <?php if($profile): ?>
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Name:</strong> <?php echo e($profile->first_name); ?>

                                                    <?php echo e($profile->middle_name); ?> <?php echo e($profile->last_name); ?>

                                                    <?php echo e($profile->suffix); ?></p>
                                                <p><strong>Sex:</strong> <?php echo e($profile->sex); ?></p>
                                                <p><strong>Marital Status:</strong> <?php echo e($profile->marital_status); ?></p>
                                                <p><strong>Date of Birth:</strong> <?php echo e($profile->dob); ?></p>
                                            </div>
                                            <div class="col-6">
                                                <p><strong>Zone:</strong> <?php echo e($profile->zone); ?></p>
                                                <p><strong>Barangay:</strong> <?php echo e($profile->nameofbarangay); ?></p>
                                                <p><strong>Religion:</strong> <?php echo e($profile->religion); ?></p>
                                                <p><strong>Birth Place:</strong> <?php echo e($profile->birth_place); ?></p>
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
                                    <?php if($message->requests->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $message->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                <?php if($request->created_at): ?>
                                                                    <?php echo e($request->created_at->format('F j, Y g:i A')); ?>

                                                                <?php else: ?>
                                                                    <em>No date available</em>
                                                                <?php endif; ?>
                                                            </p>
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
                                        <p class="text-muted">No requests found for this message.</p>
                                    <?php endif; ?>

                                    <hr>

                                    <h3 class="mb-4 text-primary">Status Log</h3>
                                    <?php if($message->statusLogMessages->isNotEmpty()): ?>
                                        <div class="list-group">
                                            <?php $__currentLoopData = $message->statusLogMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                            $agencyLogoPath = 'bfp-logo.jpg';
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
                        <a href="<?php echo e(route('bfp.emergencymessage.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="respondedForm-<?php echo e($message->id); ?>"
                                action="<?php echo e(route('bfp.emergencymessage.responded', $message->id)); ?>" method="POST"
                                class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="message_id" value="<?php echo e($message->id); ?>">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="<?php echo e($message->status_id == 3 ? 'This case is already completed' : ($message->requests->isNotEmpty() ? 'Mark as responded' : 'No requests to respond to')); ?>">
                                    <button type="button"
                                        onclick="confirmResponded(event, 'respondedForm-<?php echo e($message->id); ?>')"
                                        class="btn btn-sm btn-warning action-btn"
                                        <?php echo e($message->status_id == 3 || $message->requests->isEmpty() ? 'disabled' : ''); ?>>
                                        Responded
                                    </button>
                                </span>
                            </form>

                            <form id="completeForm-<?php echo e($message->id); ?>"
                                action="<?php echo e(route('bfp.emergencymessage.complete', $message->id)); ?>" method="POST"
                                class="d-inline">
                                <?php echo csrf_field(); ?>
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="<?php echo e($message->status_id == 3 ? 'This case is already completed' : ($message->requests->isEmpty() ? 'No requests to complete' : ($message->can_complete ? 'Mark as Complete' : 'Required agencies must respond first' . (!empty($message->missing_agencies) ? ' (' . implode(', ', $message->missing_agencies) . ')' : '')))); ?>">
                                    <button type="button"
                                        onclick="confirmComplete(event, 'completeForm-<?php echo e($message->id); ?>')"
                                        class="btn btn-sm btn-success action-btn"
                                        <?php echo e($message->status_id == 3 || $message->requests->isEmpty() ? 'disabled' : ($message->can_complete ? '' : 'disabled')); ?>>
                                        Complete
                                    </button>
                                </span>
                            </form>
                            <?php if($message->status_id == 3): ?>
                                <?php
                                    $allCasesHaveReports = true;
                                    $caseIds = [];

                                    // Collect all incident case IDs for this message
                                    foreach ($message->requests as $request) {
                                        if ($request->incidentCase) {
                                            $caseIds[] = $request->incidentCase->id;
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
                                        <button type="button" class="btn btn-sm btn-secondary action-btn" disabled
                                            title="Reports already generated for all cases">
                                            Reports Generated
                                        </button>
                                    <?php endif; ?>
                                </span>

                                <!-- Generate Report Modal -->
                                <?php if(!$allCasesHaveReports): ?>
                                    <div class="modal fade" id="generateReportModal" tabindex="-1"
                                        aria-labelledby="generateReportModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form
                                                    action="<?php echo e(route('bfp.incident_reports.generate.with_source', ['id' => $message->id, 'source_type' => 'message'])); ?>"
                                                    method="GET">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="generateReportModalLabel">Generate
                                                            Incident Report</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-4">
                                                            <h6 class="text-muted mb-3">Message Information</h6>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><strong>Sender Contact:</strong>
                                                                        <?php echo e($message->sender_contact); ?></p>
                                                                    <p><strong>Date Received:</strong>
                                                                        <?php echo e($message->created_at->format('F j, Y g:i A')); ?>

                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>Message Type:</strong>
                                                                        <?php echo e($message->sender_type); ?></p>
                                                                    <p><strong>Case Number(s):</strong>
                                                                        <?php $__currentLoopData = $message->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if($request->incidentCase): ?>
                                                                                <?php
                                                                                    $hasReport = \App\Models\IncidentReport::where(
                                                                                        'incident_case_id',
                                                                                        $request->incidentCase->id,
                                                                                    )->exists();
                                                                                ?>
                                                                                <span
                                                                                    class="badge <?php echo e($hasReport ? 'bg-success' : 'bg-info'); ?>">
                                                                                    <?php echo e($request->incidentCase->case_number); ?>

                                                                                    <?php echo e($hasReport ? '✓' : ''); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <?php if(count($caseIds) > 0): ?>
                                                                <div class="alert alert-info mt-2">
                                                                    <small>
                                                                        <i class="fas fa-info-circle"></i>
                                                                        Reports will only be generated for cases that don't
                                                                        already have one.
                                                                        Cases with existing reports are marked with ✓.
                                                                    </small>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="resolution_details" class="form-label">Resolution
                                                                Details <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="resolution_details" name="resolution_details" rows="5" required
                                                                placeholder="Provide detailed information about how this incident was resolved..."></textarea>
                                                            <small class="form-text text-muted">
                                                                Include actions taken, resources deployed, outcomes, and any
                                                                follow-up requirements.
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Generate
                                                            Report</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
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

    <!--Mark as Responded-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successMessage = "<?php echo e(session('success')); ?>";
            let errorMessage = "<?php echo e(session('error')); ?>";

            if (successMessage) {
                Swal.fire({
                    title: "Success!",
                    text: successMessage,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: "Error!",
                    text: errorMessage,
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

<?php echo $__env->make('layouts.bfp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/bfp/emergency-messages/view.blade.php ENDPATH**/ ?>