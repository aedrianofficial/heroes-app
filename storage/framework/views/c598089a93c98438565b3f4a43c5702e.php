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

        <!--All Emergency Messages Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Emergency Messages</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sender Contact</th>
                                <th>Message Content</th>
                                <th>Date Received</th>
                                <th>Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="Contact"><?php echo e($message->sender_contact); ?></td>
                                    <td data-label="Message"><?php echo e(Str::limit($message->message_content, 50)); ?></td>
                                    <td data-label="Date"><?php echo e($message->created_at->format('F j, Y g:i A')); ?></td>
                                    <td data-label="Status">
                                        <span
                                            class="badge bg-<?php echo e($message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success')); ?>">
                                            <?php echo e($message->status->name); ?>

                                        </span>
                                    </td>
                                    <td class="action-btns" data-label="View">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <div class="d-inline">
                                                <a href="<?php echo e(route('lgu.emergencymessage.view', $message->id)); ?>"
                                                    class="btn btn-sm btn-primary action-btn">View</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-btns" data-label="Actions">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <form id="ongoingForm-<?php echo e($message->id); ?>"
                                                action="<?php echo e(route('lgu.emergencymessage.ongoing', $message->id)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="message_id" value="<?php echo e($message->id); ?>">
                                                <button type="button"
                                                    onclick="confirmOngoing(event, 'ongoingForm-<?php echo e($message->id); ?>')"
                                                    class="btn btn-sm btn-warning action-btn">Ongoing</button>
                                            </form>

                                            <form id="completeForm-<?php echo e($message->id); ?>"
                                                action="<?php echo e(route('lgu.emergencymessage.complete', $message->id)); ?>"
                                                method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="button"
                                                    onclick="confirmComplete(event, 'completeForm-<?php echo e($message->id); ?>')"
                                                    class="btn btn-sm btn-success action-btn">Complete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
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

<?php echo $__env->make('layouts.lgu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/lgu/emergency-messages/index.blade.php ENDPATH**/ ?>