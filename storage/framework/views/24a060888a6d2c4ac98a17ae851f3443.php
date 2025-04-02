<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Column - Logo -->
                        <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                            <div class="text-center">
                                <a href="<?php echo e(route('welcome')); ?>"><img src="<?php echo e(asset('asset/image/logo.png')); ?>"
                                        alt="Heroes Logo" class="img-fluid p-3"></a>
                            </div>
                        </div>

                        <!-- Right Column - Login Form -->
                        <div class="col-md-7">
                            <div class="card-header bg-danger text-white text-center py-3">
                                <h4 class="mb-0">Login to Your Account</h4>
                            </div>
                            <div class="card-body p-4">
                                <?php if(session('success')): ?>
                                    <div class="alert alert-success">
                                        <?php echo e(session('success')); ?>

                                    </div>
                                <?php endif; ?>
                                <form method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo csrf_field(); ?>

                                    <!-- Username or Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Username or Email:</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="login" class="form-control"
                                                value="<?php echo e(old('login')); ?>" placeholder="Enter your username or email"
                                                required>
                                        </div>
                                        <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <small class="text-danger"><?php echo e($message); ?></small>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label class="form-label">Password:</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Enter your password" required>
                                        </div>
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <small class="text-danger"><?php echo e($message); ?></small>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- Remember Me and Forgot Password -->
                                    <div class="d-flex justify-content-between mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="remember_token"
                                                id="remember">
                                            <label class="form-check-label" for="remember">Remember Me</label>
                                        </div>
                                        <div>
                                            <a href="" class="text-danger">Forgot Password?</a>
                                        </div>
                                    </div>

                                    <!-- Login Button -->
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-danger">Login</button>
                                    </div>

                                    <!-- Register Link -->
                                    <div class="text-center">
                                        <p class="mb-0">Don't have an account? <a href="<?php echo e(route('register.form')); ?>"
                                                class="text-danger fw-bold">Register here</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/auth/login.blade.php ENDPATH**/ ?>