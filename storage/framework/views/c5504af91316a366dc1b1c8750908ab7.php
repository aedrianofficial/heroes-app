
<?php $__env->startSection('styles'); ?>
    <style>
        /* Equal-sized buttons */
        .action-btn {
            width: 90px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media screen and (max-width: 767px) {
            .table-responsive .table {
                border: 0;
            }

            .table-responsive .table thead {
                display: none;
            }

            .table-responsive .table tr {
                display: block;
                margin-bottom: 1.5rem;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .table-responsive .table td {
                display: block;
                text-align: right;
                padding: 0.75rem;
                border-bottom: 1px solid #dee2e6;
            }

            .table-responsive .table td:last-child {
                border-bottom: 0;
            }

            .table-responsive .table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }

            .table-responsive .table td.text-center {
                text-align: center !important;
            }

            .table-responsive .table td.text-center::before {
                display: block;
                float: none;
                text-align: center;
                margin-bottom: 0.5rem;
            }

            .table-responsive .table td.action-btns {
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .table-responsive .table td.action-btns .d-flex {
                flex-direction: column;
                width: 100%;
            }

            .table-responsive .table td.action-btns .action-btn {
                width: 100px;
            }

        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">

        <!--All Emergency Calls Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Cases</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Incident Case</th>
                                <th>Caller Contact</th>
                                <th>Call Date</th>
                                <th>Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="Incident Case">
                                        <?php if($call->requests->isNotEmpty()): ?>
                                            <?php $__currentLoopData = $call->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e(optional($request->incidentCase)->case_number ?? 'N/A'); ?><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Caller Contact"><?php echo e($call->caller_contact); ?></td>
                                    <td data-label="Call Date"><?php echo e($call->created_at); ?></td>
                                    <td data-label="Status">
                                        <span
                                            class="badge bg-<?php echo e($call->status_id == 1 ? 'danger' : ($call->status_id == 2 ? 'warning text-dark' : 'success')); ?>">
                                            <?php echo e($call->status->name); ?>

                                        </span>
                                    </td>
                                    <td class="action-btns" data-label="View">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <div class="d-inline">
                                                <a href="<?php echo e(route('mho.emergencycall.view', $call->id)); ?>"
                                                    class="btn btn-sm btn-danger action-btn">View</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-btns" data-label="Actions">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <form id="respondedForm-<?php echo e($call->id); ?>"
                                                action="<?php echo e(route('mho.emergencycall.responded', $call->id)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="call_id" value="<?php echo e($call->id); ?>">
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                                    title="<?php echo e($call->status_id == 3 ? 'This call is already completed' : 'Mark as responded'); ?>">
                                                    <button type="button"
                                                        onclick="confirmResponded(event, 'respondedForm-<?php echo e($call->id); ?>')"
                                                        class="btn btn-sm btn-warning action-btn"
                                                        <?php echo e($call->status_id == 3 ? 'disabled' : ''); ?>>
                                                        Responded
                                                    </button>
                                                </span>
                                            </form>

                                            <form id="completeForm-<?php echo e($call->id); ?>"
                                                action="<?php echo e(route('mho.emergencycall.complete', $call->id)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                                    title="<?php echo e($call->status_id == 3 ? 'This call is already completed' : ($call->can_complete ? 'Mark as Complete' : 'Required agencies must respond first')); ?>">
                                                    <button type="button"
                                                        onclick="confirmComplete(event, 'completeForm-<?php echo e($call->id); ?>')"
                                                        class="btn btn-sm btn-success action-btn"
                                                        <?php echo e($call->status_id == 3 ? 'disabled' : ($call->can_complete ? '' : 'disabled')); ?>>
                                                        Complete
                                                    </button>
                                                </span>
                                            </form>


                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No emergency calls found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($calls->links('pagination::bootstrap-5', ['paginator' => $calls, 'elements' => [1 => $calls->getUrlRange(1, $calls->lastPage())], 'onEachSide' => 1])); ?>

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
                text: "Do you want to mark this call as responded?",
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
                        Swal.showValidationCall("Log details are required!");
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
                text: "Do you want to mark this call as completed?",
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
                        Swal.showValidationCall("Log details are required!");
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

<?php echo $__env->make('layouts.mho', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/mho/cases/index.blade.php ENDPATH**/ ?>