@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Column - Logo -->
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4">
                            <div class="text-center">
                                <a href="{{ route('welcome') }}"><img src="{{ asset('asset/image/logo.png') }}" alt="Heroes Logo"
                                        class="img-fluid p-3"></a>
                                <div class="mt-4">
                                    <h5 class="text-danger fw-bold">Create an Account</h5>
                                    <p class="text-muted">Join us! {{-- to access all features and services. --}}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Registration Form -->
                        <div class="col-md-8">
                            <div class="card-header bg-danger text-white text-center py-3">
                                <h4 class="mb-0">Register</h4>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                        <!-- Left Column of Form -->
                                        <div class="col-md-6">
                                            <!-- Username -->
                                            <div class="mb-3">
                                                <label class="form-label">Username:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="username" class="form-control"
                                                        value="{{ old('username') }}" placeholder="Choose a username"
                                                        required>
                                                </div>
                                                @error('username')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="mb-3">
                                                <label class="form-label">Email:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email') }}" placeholder="Your email address"
                                                        required>
                                                </div>
                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Contact Number -->
                                            <div class="mb-3">
                                                <label class="form-label">Contact Number:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="text" name="contact_number" id="contact_number"
                                                        class="form-control" value="{{ old('contact_number') }}" required
                                                        pattern="\d{11}" maxlength="11"
                                                        placeholder="11-digit number (09123456789)">
                                                </div>
                                                @error('contact_number')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Password -->
                                            <div class="mb-3">
                                                <label class="form-label">Password:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Create a password" required>
                                                </div>
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
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
                                                        value="{{ old('firstname') }}" placeholder="Your first name"
                                                        required>
                                                </div>
                                                @error('firstname')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Middle Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Middle Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="middlename" class="form-control"
                                                        value="{{ old('middlename') }}"
                                                        placeholder="Your middle name (optional)">
                                                </div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Last Name:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="lastname" class="form-control"
                                                        value="{{ old('lastname') }}" placeholder="Your last name"
                                                        required>
                                                </div>
                                                @error('lastname')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <!-- Extension Name -->
                                            <div class="mb-3">
                                                <label class="form-label">Extension Name (if any):</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                                    <input type="text" name="extname" class="form-control"
                                                        value="{{ old('extname') }}"
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
                                                        value="{{ old('bday') }}" required>
                                                </div>
                                                @error('bday')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-danger px-5">Register</button>
                                    </div>

                                    <!-- Already have an account? -->
                                    <div class="text-center mt-3">
                                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}"
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
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const contactInput = document.getElementById("contact_number");

            contactInput.addEventListener("input", function(e) {
                // Remove non-numeric characters
                this.value = this.value.replace(/\D/g, "");

                // Limit input to exactly 10 digits
                if (this.value.length > 11) {
                    this.value = this.value.slice(0, 11);
                }
            });
        });
    </script>
@endsection
