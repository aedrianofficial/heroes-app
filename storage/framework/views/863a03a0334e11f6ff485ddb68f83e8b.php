<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Column - Logo -->
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4">
                            <div class="text-center">
                                <a href="<?php echo e(route('welcome')); ?>"><img src="<?php echo e(asset('asset/image/logo.png')); ?>"
                                        alt="Heroes Logo" class="img-fluid p-3"></a>
                                <div class="mt-4">
                                    <h5 class="text-danger fw-bold">Create an Account</h5>
                                    <p class="text-muted">Join us! </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Registration Form -->
                        <div class="col-md-8">
                            <div class="card-header bg-danger text-white text-center py-3">
                                <h4 class="mb-0">Register</h4>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="<?php echo e(route('register')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <!-- Left Column of Form -->
                                        <div class="col-md-6">
                                            <!-- Username -->
                                            <div class="mb-3">
                                                <label class="form-label">Username:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="username" class="form-control"
                                                        value="<?php echo e(old('username')); ?>" placeholder="Choose a username"
                                                        required>
                                                </div>
                                                <?php $__errorArgs = ['username'];
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

                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label class="form-label">Email:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="email" name="email" class="form-control"
                                                        value="<?php echo e(old('email')); ?>" placeholder="Your email address"
                                                        required>
                                                </div>
                                                <?php $__errorArgs = ['email'];
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

                                            <!-- Contact Number -->
                                            <div class="mb-3">
                                                <label class="form-label">Contact Number:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="text" name="contact_number" id="contact_number"
                                                        class="form-control" value="<?php echo e(old('contact_number')); ?>" required
                                                        pattern="\d{11}" maxlength="11"
                                                        placeholder="11-digit number (09123456789)">
                                                </div>
                                                <?php $__errorArgs = ['contact_number'];
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
                                                        placeholder="Create a password" required>
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

                                            <!-- Confirm Password -->
                                            <div class="mb-3">
                                                <label class="form-label">Confirm Password:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        placeholder="Confirm your password" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Column of Form -->
                                        <div class="col-md-6">
                                            <!-- First Name -->
                                            <div class="mb-3">
                                                <label class="form-label">First Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="firstname" class="form-control"
                                                        value="<?php echo e(old('firstname')); ?>" placeholder="Your first name"
                                                        required>
                                                </div>
                                                <?php $__errorArgs = ['firstname'];
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

                                            <!-- Middle Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Middle Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="middlename" class="form-control"
                                                        value="<?php echo e(old('middlename')); ?>"
                                                        placeholder="Your middle name (optional)">
                                                </div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Last Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="lastname" class="form-control"
                                                        value="<?php echo e(old('lastname')); ?>" placeholder="Your last name"
                                                        required>
                                                </div>
                                                <?php $__errorArgs = ['lastname'];
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

                                            <!-- Extension Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Extension Name (if any):</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="extname" class="form-control"
                                                        value="<?php echo e(old('extname')); ?>"
                                                        placeholder="Jr., Sr., III, etc. (optional)">
                                                </div>
                                            </div>

                                            <!-- Birthdate -->
                                            <div class="mb-3">
                                                <label class="form-label">Birthdate:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-calendar-alt"></i></span>
                                                    <input type="date" name="bday" class="form-control"
                                                        value="<?php echo e(old('bday')); ?>" required>
                                                </div>
                                                <?php $__errorArgs = ['bday'];
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
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-danger px-5">Register</button>
                                    </div>

                                    <!-- Already have an account? -->
                                    <div class="text-center mt-3">
                                        <p class="mb-0">Already have an account? <a href="<?php echo e(route('login')); ?>"
                                                class="text-danger fw-bold">Login here</a></p>
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
            const registerForm = document.querySelector('form[action*="register"]');
            const submitButton = registerForm.querySelector('button[type="submit"]');

            // Add id to the register form and submit button
            registerForm.id = 'register-form';
            submitButton.id = 'register-btn';

            // Form input fields
            const usernameInput = registerForm.querySelector('input[name="username"]');
            const emailInput = registerForm.querySelector('input[name="email"]');
            const passwordInput = registerForm.querySelector('input[name="password"]');
            const passwordConfirmInput = registerForm.querySelector('input[name="password_confirmation"]');
            const firstnameInput = registerForm.querySelector('input[name="firstname"]');
            const lastnameInput = registerForm.querySelector('input[name="lastname"]');
            const contactInput = document.getElementById('contact_number');
            const bdayInput = registerForm.querySelector('input[name="bday"]');

            // Add ids to input fields for easier targeting
            usernameInput.id = 'username';
            emailInput.id = 'email';
            passwordInput.id = 'password';
            passwordConfirmInput.id = 'password_confirmation';
            firstnameInput.id = 'firstname';
            lastnameInput.id = 'lastname';
            bdayInput.id = 'bday';

            // Create error message elements
            function createErrorElement(inputElement, errorMessage, errorId) {
                const errorDiv = document.createElement('div');
                errorDiv.id = errorId;
                errorDiv.className = 'text-danger small mt-1';
                errorDiv.innerHTML = errorMessage;
                errorDiv.style.display = 'none';

                // If there's already an error message from Laravel, don't add this one
                const existingError = inputElement.parentNode.parentNode.querySelector('.text-danger');
                if (!existingError) {
                    inputElement.parentNode.parentNode.appendChild(errorDiv);
                }
                return errorDiv;
            }

            // Create error elements for validation
            const usernameError = createErrorElement(usernameInput, 'Username must be at least 3 characters',
                'username_error');
            const emailError = createErrorElement(emailInput, 'Please enter a valid email address', 'email_error');
            const passwordError = createErrorElement(passwordInput, 'Password must be at least 8 characters',
                'password_error');
            const passwordConfirmError = createErrorElement(passwordConfirmInput, 'Passwords do not match',
                'password_confirm_error');
            const firstnameError = createErrorElement(firstnameInput, 'First name is required', 'firstname_error');
            const lastnameError = createErrorElement(lastnameInput, 'Last name is required', 'lastname_error');
            const contactError = createErrorElement(contactInput, 'Contact number must be 11 digits',
                'contact_error');
            const bdayError = createErrorElement(bdayInput, 'Birthdate is required', 'bday_error');

            // Add show password functionality
            const passwordContainer = passwordInput.parentNode.parentNode;
            const showPasswordDiv = document.createElement('div');
            showPasswordDiv.className = 'form-check mt-1';
            showPasswordDiv.innerHTML = `
        <input type="checkbox" class="form-check-input" id="show-password">
        <label class="form-check-label small" for="show-password">Show password</label>
    `;
            passwordContainer.appendChild(showPasswordDiv);

            // Password show/hide toggle
            document.getElementById("show-password").addEventListener("change", function() {
                passwordInput.type = this.checked ? "text" : "password";
                passwordConfirmInput.type = this.checked ? "text" : "password";
            });

            // Validation functions
            function validateUsername(input) {
                const value = input.value.trim();
                if (value === '' || value.length < 3) {
                    usernameError.style.display = 'block';
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    usernameError.style.display = 'none';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    return true;
                }
            }

            function validateEmail(input) {
                const value = input.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    emailError.style.display = 'block';
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    emailError.style.display = 'none';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    return true;
                }
            }

            function validatePassword(input) {
                const value = input.value;
                if (value.length < 8) {
                    passwordError.style.display = 'block';
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    passwordError.style.display = 'none';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    return true;
                }
            }

            function validatePasswordConfirm() {
                const password = passwordInput.value;
                const confirm = passwordConfirmInput.value;
                if (password !== confirm) {
                    passwordConfirmError.style.display = 'block';
                    passwordConfirmInput.classList.add('is-invalid');
                    return false;
                } else {
                    passwordConfirmError.style.display = 'none';
                    passwordConfirmInput.classList.remove('is-invalid');
                    if (password.length >= 8) {
                        passwordConfirmInput.classList.add('is-valid');
                    }
                    return true;
                }
            }

            function validateContact(input) {
                const value = input.value.trim();
                if (value.length !== 11 || !/^\d+$/.test(value)) {
                    contactError.style.display = 'block';
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    contactError.style.display = 'none';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    return true;
                }
            }

            function validateName(input, errorElement) {
                const value = input.value.trim();
                if (value === '') {
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

            function validateBday(input) {
                const value = input.value.trim();
                if (value === '') {
                    bdayError.style.display = 'block';
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    bdayError.style.display = 'none';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    return true;
                }
            }

            // Add input event listeners for validation
            usernameInput.addEventListener('input', function() {
                validateUsername(usernameInput);
            });

            emailInput.addEventListener('input', function() {
                validateEmail(emailInput);
            });

            passwordInput.addEventListener('input', function() {
                validatePassword(passwordInput);
                if (passwordConfirmInput.value.length > 0) {
                    validatePasswordConfirm();
                }
            });

            passwordConfirmInput.addEventListener('input', function() {
                validatePasswordConfirm();
            });

            firstnameInput.addEventListener('input', function() {
                validateName(firstnameInput, firstnameError);
            });

            lastnameInput.addEventListener('input', function() {
                validateName(lastnameInput, lastnameError);
            });

            contactInput.addEventListener('input', function() {
                // Remove non-numeric characters
                this.value = this.value.replace(/\D/g, "");

                // Limit input to exactly 11 digits
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }

                validateContact(contactInput);
            });

            bdayInput.addEventListener('change', function() {
                validateBday(bdayInput);
            });

            // Form submit handler
            registerForm.addEventListener('submit', function(event) {
                // Validate all fields
                const isUsernameValid = validateUsername(usernameInput);
                const isEmailValid = validateEmail(emailInput);
                const isPasswordValid = validatePassword(passwordInput);
                const isPasswordConfirmValid = validatePasswordConfirm();
                const isFirstnameValid = validateName(firstnameInput, firstnameError);
                const isLastnameValid = validateName(lastnameInput, lastnameError);
                const isContactValid = validateContact(contactInput);
                const isBdayValid = validateBday(bdayInput);

                // Check if all validations passed
                if (!isUsernameValid || !isEmailValid || !isPasswordValid || !isPasswordConfirmValid ||
                    !isFirstnameValid || !isLastnameValid || !isContactValid || !isBdayValid) {
                    event.preventDefault(); // Prevent form submission if validation fails
                } else {
                    // Show loading message
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...';
                    submitButton.disabled = true;

                    // Add loading notification
                    if (!document.getElementById('register-notification')) {
                        const notification = document.createElement('div');
                        notification.id = 'register-notification';
                        notification.className = 'alert alert-info mt-3 d-flex align-items-center';
                        notification.innerHTML = `
                    <div class="spinner-grow spinner-grow-sm text-info me-2" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div>
                        <strong>Please wait!</strong> Creating your account...
                    </div>
                `;
                        registerForm.appendChild(notification);
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
        
        #register-notification {
            animation: pulse 2s infinite;
        }
    `;
            document.head.appendChild(style);
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/auth/register.blade.php ENDPATH**/ ?>