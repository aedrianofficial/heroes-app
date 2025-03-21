<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg mt-4">

                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Sender Contact</h5>
                                    <p class="text-dark"><?php echo e($message->sender_contact); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Message Content</h5>
                                    <p class="text-dark"><?php echo e($message->message_content); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Date recieve</h5>
                                    <p class="text-dark"><?php echo e($message->created_at->format('F j, Y g:i A')); ?></p>
                                </div>
                                

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Status</h5>
                                    <span
                                        class="badge bg-<?php echo e($message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success')); ?> px-3 py-2">
                                        <?php echo e($message->status->name); ?>

                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Incident Type</h5>
                                    
                                    <p>Test</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Agencies Involved</h5>
                                    
                                    <p>Test</p>
                                </div>
                                
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <h5 class="fw-bold text-muted">Sender Profile</h5>
                                <?php if($profile): ?>
                                    <div class="mb-3">
                                        <p><strong>Name:</strong> <?php echo e($profile->first_name); ?> <?php echo e($profile->middle_name); ?>

                                            <?php echo e($profile->last_name); ?> <?php echo e($profile->suffix); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Date of Birth:</strong> <?php echo e($profile->dob); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Sex:</strong> <?php echo e($profile->sex); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Marital Status:</strong> <?php echo e($profile->marital_status); ?></p>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No profile information available.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <?php if($profile): ?>
                                    <div class="mb-3">
                                        <p><strong>Religion:</strong> <?php echo e($profile->religion); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Ethnicity:</strong> <?php echo e($profile->ethnicity); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Birth Place:</strong> <?php echo e($profile->birth_place); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Zone:</strong> <?php echo e($profile->zone); ?></p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Barangay:</strong> <?php echo e($profile->nameofbarangay); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                        <?php if($message->requests->isNotEmpty()): ?>
                            <?php $__currentLoopData = $message->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded p-3 mb-4 shadow-sm">
                                    <h5 class="fw-bold text-muted">Request <?php echo e($index + 1); ?></h5>
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <p><strong>Name:</strong> <?php echo e($request->name); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Address:</strong> <?php echo e($request->address); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Description:</strong> <?php echo e($request->description); ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Time:</strong> <?php echo e($request->created_at->format('F j, Y g:i A')); ?></p>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <h5 class="fw-bold text-muted">Assigned Agencies</h5>
                                            <?php if($request->agencies->isNotEmpty()): ?>
                                                <div class="mb-3">
                                                    <ul>
                                                        <?php $__currentLoopData = $request->agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li><?php echo e($agency->name); ?></li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted">No assigned agencies</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p class="text-muted">No requests found for this message.</p>
                        @endifs
                        <hr>
                        <div class="mb-3">
                            <h5 class="fw-bold text-muted">Status Log</h5>
                            <?php if($message->statusLogMessages->isNotEmpty()): ?>
                                <ul class="list-group">
                                    <?php $__currentLoopData = $message->statusLogMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item">
                                            <strong><?php echo e($log->user->profile->firstname ?? 'Unknown User'); ?>

                                                <?php echo e($log->user->profile->lastname ?? 'Unknown User'); ?>


                                            </strong> marked this message as
                                            <span
                                                class="badge bg-<?php echo e($log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning text-dark' : 'success')); ?>">
                                                <?php echo e($log->status->name); ?>

                                            </span>
                                            on <?php echo e($log->created_at->format('F j, Y g:i A')); ?>.
                                            <br>
                                            <strong>Log Details:</strong> <?php echo e($log->log_details); ?>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">No status logs available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('mho.emergencymessage.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="ongoingForm-<?php echo e($message->id); ?>"
                                action="<?php echo e(route('mho.emergencymessage.ongoing', $message->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="message_id" value="<?php echo e($message->id); ?>">
                                <button type="button" onclick="confirmOngoing(event, 'ongoingForm-<?php echo e($message->id); ?>')"
                                    class="btn btn-sm btn-warning">Ongoing</button>
                            </form>
                            <form id="completeForm-<?php echo e($message->id); ?>"
                                action="<?php echo e(route('mho.emergencymessage.complete', $message->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="button" onclick="confirmComplete(event, 'completeForm-<?php echo e($message->id); ?>')"
                                    class="btn btn-sm btn-success">
                                    Complete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <!--sweet alert-->
    <!--Mark as Ongoing-->
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

        function confirmOngoing(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this message as ongoing?",
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
                confirmButtonText: "Yes, mark as ongoing!",
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


        function confirmComplete(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this message as completed?",
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
<?php echo $__env->make('layouts.mho', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/mho/emergency-messages/view.blade.php ENDPATH**/ ?>