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
<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get form elements
            const loginForm = document.querySelector('form[action*="login"]');
            const loginInput = document.querySelector('input[name="login"]');
            const passwordInput = document.querySelector('input[name="password"]');
            const submitButton = loginForm.querySelector('button[type="submit"]');

            // Add id attributes to form elements for easier targeting
            loginForm.id = 'login-form';
            loginInput.id = 'login';
            passwordInput.id = 'password';
            submitButton.id = 'login-btn';

            // Create error message elements
            const loginErrorDiv = document.createElement('div');
            loginErrorDiv.id = 'login_error';
            loginErrorDiv.className = 'text-danger small mt-1';
            loginErrorDiv.innerHTML = 'Username or email must be at least 3 characters';
            loginErrorDiv.style.display = 'none';
            loginInput.parentNode.parentNode.appendChild(loginErrorDiv);

            const passwordErrorDiv = document.createElement('div');
            passwordErrorDiv.id = 'password_error';
            passwordErrorDiv.className = 'text-danger small mt-1';
            passwordErrorDiv.innerHTML = 'Password must be at least 8 characters';
            passwordErrorDiv.style.display = 'none';
            passwordInput.parentNode.parentNode.appendChild(passwordErrorDiv);

            // Add show password functionality
            const passwordContainer = passwordInput.parentNode.parentNode;
            const showPasswordDiv = document.createElement('div');
            showPasswordDiv.className = 'form-check mt-1';
            showPasswordDiv.innerHTML = `
        <input type="checkbox" class="form-check-input" id="show-password">
        <label class="form-check-label small" for="show-password">Show password</label>
    `;
            passwordContainer.appendChild(showPasswordDiv);

            // Validation function
            function validateInput(input) {
                const value = input.value.trim();
                if (input.id === 'login') {
                    const errorElement = document.getElementById('login_error');
                    if (value === '' || value.length < 3) {
                        errorElement.style.display = 'block';
                        input.classList.add('is-invalid');
                        return false;
                    } else {
                        errorElement.style.display = 'none';
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                        return true;
                    }
                }

                if (input.id === 'password') {
                    const errorElement = document.getElementById('password_error');
                    if (value.length < 8) {
                        errorElement.style.display = 'block';
                        input.classList.add('is-invalid');
                        return false;
                    } else {
                        errorElement.style.display = 'none';
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                        return true;
                    }
                }

                return true; // Valid input
            }

            // Add input event listeners for validation
            loginInput.addEventListener('input', function() {
                validateInput(loginInput);
            });

            passwordInput.addEventListener('input', function() {
                validateInput(passwordInput);
            });

            // Show Password Functionality
            document.getElementById("show-password").addEventListener("change", function() {
                passwordInput.type = this.checked ? "text" : "password"; // Toggle password visibility
            });

            // Form submit handler
            loginForm.addEventListener('submit', function(event) {
                const isLoginValid = validateInput(loginInput);
                const isPasswordValid = validateInput(passwordInput);

                if (!isLoginValid || !isPasswordValid) {
                    event.preventDefault(); // Prevent form submission if validation fails
                } else {
                    // Show loading message
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Authenticating...';
                    submitButton.disabled = true;

                    // Add loading notification
                    if (!document.getElementById('login-notification')) {
                        const notification = document.createElement('div');
                        notification.id = 'login-notification';
                        notification.className = 'alert alert-info mt-3 d-flex align-items-center';
                        notification.innerHTML = `
                    <div class="spinner-grow spinner-grow-sm text-info me-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>
                        <strong>Please wait!</strong> Verifying your credentials...
                    </div>
                `;
                        loginForm.appendChild(notification);
                    }

                    // Add page overlay for loading effect
                    const overlay = document.createElement('div');
                    overlay.id = 'loading-overlay';
                    overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            `;

                    const spinner = document.createElement('div');
                    spinner.className = 'spinner-border text-light';
                    spinner.style.width = '3rem';
                    spinner.style.height = '3rem';
                    spinner.setAttribute('role', 'status');
                    spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';

                    overlay.appendChild(spinner);
                    document.body.appendChild(overlay);
                }
            });

            // Add custom styling
            const style = document.createElement('style');
            style.textContent = `
        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        #login-notification {
            animation: pulse 2s infinite;
        }
    `;
            document.head.appendChild(style);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/auth/login.blade.php ENDPATH**/ ?>