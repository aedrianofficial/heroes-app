<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h5>All Users & Roles</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Agency</th>
                                <th>Contact Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->profile->firstname); ?> <?php echo e($user->profile->lastname); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td><?php echo e($user->role->name); ?></td>
                                    <td><?php echo e($user->agency->name ?? 'N/A'); ?></td>
                                    <td><?php echo e($user->contacts->first()->contact_number ?? 'N/A'); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('superadmin.users.view', $user->id)); ?>"
                                            class="btn btn-sm btn-primary">View</a>
                                        <a href="<?php echo e(route('superadmin.users.edit', $user->id)); ?>"
                                            class="btn btn-sm btn-warning">Edit</a>


                                        
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

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/super-admin/users/all-users.blade.php ENDPATH**/ ?>