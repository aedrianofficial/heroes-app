

<?php $__env->startSection('content'); ?>
    <div class="container">
        <!-- Contact Messages Table -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Contact Messages</h5>
                <div>
                    <form action="<?php echo e(route('superadmin.contact-messages.index')); ?>" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2"
                            placeholder="Search by name or email" value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date Received</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $contactMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="Full Name"><?php echo e($message->full_name); ?></td>
                                    <td data-label="Email"><?php echo e($message->email); ?></td>
                                    <td data-label="Subject"><?php echo e($message->subject); ?></td>
                                    <td data-label="Date"><?php echo e($message->created_at->format('F j, Y g:i A')); ?></td>
                                    <td class="action-btns" data-label="Actions">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <div class="d-inline">
                                                <button type="button" class="btn btn-sm btn-primary action-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewMessageModal<?php echo e($message->id); ?>">
                                                    View
                                                </button>
                                            </div>
                                            <div class="d-inline">
                                                <form
                                                    action="<?php echo e(route('superadmin.contact-messages.delete', $message->id)); ?>"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger action-btn">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- View Message Modal -->
                                <div class="modal fade" id="viewMessageModal<?php echo e($message->id); ?>" tabindex="-1"
                                    aria-labelledby="viewMessageModalLabel<?php echo e($message->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewMessageModalLabel<?php echo e($message->id); ?>">
                                                    Message Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <p><strong>Name:</strong> <?php echo e($message->full_name); ?></p>
                                                        <p><strong>Email:</strong> <?php echo e($message->email); ?></p>
                                                        <p><strong>Phone:</strong> <?php echo e($message->phone_number); ?></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Subject:</strong> <?php echo e($message->subject); ?></p>
                                                        <p><strong>Date Received:</strong>
                                                            <?php echo e($message->created_at->format('F j, Y g:i A')); ?></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h6>Message</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <?php echo e($message->message); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="mailto:<?php echo e($message->email); ?>" class="btn btn-primary">Reply via
                                                    Email</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No contact messages found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($contactMessages->links('pagination::bootstrap-5', ['paginator' => $contactMessages, 'elements' => [1 => $contactMessages->getUrlRange(1, $contactMessages->lastPage())], 'onEachSide' => 1])); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/super-admin/contact-messages/index.blade.php ENDPATH**/ ?>