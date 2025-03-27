<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><?php echo e($report->title); ?></h4>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Description</h5>
                                    <p class="text-dark"><?php echo e($report->description); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Incident Type</h5>
                                    <p class="badge bg-danger px-3 py-2"><?php echo e($report->incidentType->name); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Address</h5>
                                    <p class="text-dark"><?php echo e($report->location->address); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Contact Number</h5>
                                    <p class="text-dark"><?php echo e($report->contact_number); ?></p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Coordinates</h5>
                                    <p>(<?php echo e($report->location->latitude); ?>,
                                        <?php echo e($report->location->longitude); ?>)
                                    </p>
                                </div>

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Status</h5>
                                    <span
                                        class="badge bg-<?php echo e($report->status_id == 1 ? 'danger' : ($report->status_id == 2 ? 'warning text-dark' : 'success')); ?> px-3 py-2">
                                        <?php echo e($report->status->name); ?>

                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Agencies Involved</h5>
                                    <p>
                                        <?php $__currentLoopData = $report->agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-primary px-3 py-2"><?php echo e($agency->name); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="fw-bold text-muted">Attachments</h5>
                                    <?php if($report->reportAttachments->count() > 0): ?>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $report->reportAttachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(asset('storage/' . $attachment->file_path)); ?>" target="_blank">
                                                    <img src="<?php echo e(asset('storage/' . $attachment->file_path)); ?>"
                                                        alt="Attachment" class="rounded shadow-sm border border-primary"
                                                        width="200" height="200" style="object-fit: cover;">
                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted">No attachments available.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('lgu.reports.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form action="<?php echo e(route('lgu.reports.responded', $report->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" onclick="confirmResponded(event)" class="btn btn-sm btn-warning">Mark
                                    as Responded</button>
                            </form>
                            <form action="<?php echo e(route('lgu.reports.complete', $report->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" onclick="confirmComplete(event)" class="btn btn-sm btn-success">Mark
                                    as Completed</button>
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

        function confirmResponded(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as responded?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as responded!",
                customClass: {
                    confirmButton: 'text-dark' // Add this line to change the text color to black
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit(); // Submits the form normally
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

        function confirmResponded(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as responded?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as responded!",
                customClass: {
                    confirmButton: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit();
                }
            });
        }

        function confirmComplete(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as completed?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as completed!"
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.lgu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/lgu/report/view.blade.php ENDPATH**/ ?>