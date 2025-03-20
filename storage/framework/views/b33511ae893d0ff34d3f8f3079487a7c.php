<?php $__env->startSection('content'); ?>
    <div class="container">

        <!--All Reports Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Reports</h5>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Incident Type</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($report->name); ?></td>
                                <td><?php echo e($report->incidentType->name); ?></td>
                                <td><?php echo e($report->location->address); ?></td>
                                <td>
                                    <span
                                        class="badge bg-<?php echo e($report->status_id == 1 ? 'danger' : ($report->status_id == 2 ? 'warning text-dark' : 'success')); ?>">
                                        <?php echo e($report->status->name); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('mho.reports.view', $report->id)); ?>"
                                        class="btn btn-sm btn-primary">View</a>

                                </td>
                                <td>
                                    <form action="<?php echo e(route('mho.reports.ongoing', $report->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" onclick="confirmOngoing(event)"
                                            class="btn btn-sm btn-warning ">Ongoing</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?php echo e(route('mho.reports.complete', $report->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" onclick="confirmComplete(event)"
                                            class="btn btn-sm btn-success ">Complete</button>
                                    </form>
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

        function confirmOngoing(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as ongoing?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as ongoing!",
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

        function confirmOngoing(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as ongoing?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as ongoing!",
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

<?php echo $__env->make('layouts.mho', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/admin/mho/report/all-report.blade.php ENDPATH**/ ?>