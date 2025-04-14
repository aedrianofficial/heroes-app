

<?php $__env->startSection('title', 'Email Verification'); ?>

<?php $__env->startSection('content'); ?>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <a href="<?php echo e(route('user.dashboard')); ?>">
                                <img src="<?php echo e(asset('asset/image/logo.png')); ?>" alt="Logo"
                                     class="img-fluid mb-3" style="max-width: 200px;">
                            </a>
                            <h3>Verify Email Address</h3>
                            <p class="text-muted">Please verify your email address to complete your registration.</p>
                        </div>
                        <div class="card-body">
                            <?php if(session('resent')): ?>
                                <div class="alert alert-success" role="alert">
                                    A fresh verification link has been sent to your email address.
                                </div>
                            <?php endif; ?>

                            <p>Before proceeding, please check your email for a verification link.</p>
                            <p>If you did not receive the email, please check your spam folder or:</p>

                            <form id="verification-form" method="POST" action="<?php echo e(route('verification.send')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="d-grid gap-2">
                                    <button id="verify-btn" type="submit" class="btn btn-primary">
                                        <?php echo e(__('Request another verification link')); ?>

                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button id="logout-btn" type="submit" class="btn btn-link">
                                        <?php echo e(__('Log Out')); ?>

                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Email verification page scripts loaded successfully');

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function () {
                document.querySelectorAll('.alert').forEach(function (alert) {
                    alert.style.display = 'none';
                });
            }, 5000);

            // Handle verification resend
            const verificationForm = document.getElementById('verification-form');
            const verifyBtn = document.getElementById('verify-btn');

            if (verificationForm) {
                verificationForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    // Show spinner and disable button
                    verifyBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending link...';
                    verifyBtn.disabled = true;

                    // Show loading message
                    if (!document.getElementById('verification-notification')) {
                        const notification = document.createElement('div');
                        notification.id = 'verification-notification';
                        notification.className = 'alert alert-info mt-3 d-flex align-items-center';
                        notification.innerHTML = `
                            <div class="spinner-grow spinner-grow-sm text-info me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div>
                                <strong>Please wait!</strong> Sending verification link to your email...
                            </div>
                        `;
                        verificationForm.appendChild(notification);
                    }

                    // Simulate delay and submit
                    setTimeout(() => {
                        verificationForm.submit();
                    }, 800);
                });
            }

            // Handle logout
            const logoutForm = document.getElementById('logout-form');
            const logoutBtn = document.getElementById('logout-btn');

            if (logoutForm) {
                logoutForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    // Show spinner and disable button
                    logoutBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Logging out...';
                    logoutBtn.disabled = true;

                    // Show loading message
                    if (!document.getElementById('logout-notification')) {
                        const notification = document.createElement('div');
                        notification.id = 'logout-notification';
                        notification.className = 'alert alert-info mt-2 small d-flex align-items-center';
                        notification.innerHTML = `
                            <div class="spinner-grow spinner-grow-sm text-info me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div>
                                <strong>Please wait!</strong> Logging you out...
                            </div>
                        `;
                        logoutForm.appendChild(notification);
                    }

                    // Simulate delay and submit
                    setTimeout(() => {
                        logoutForm.submit();
                    }, 800);
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/auth/verify-email.blade.php ENDPATH**/ ?>