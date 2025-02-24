@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Register</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Username -->
                                <div class="mb-3">
                                    <label class="form-label">Username:</label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label">Email:</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label">Password:</label>
                                    <input type="password" name="password" class="form-control" required>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password:</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label class="form-label">First Name:</label>
                                    <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" required>
                                    @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Middle Name -->
                                <div class="mb-3">
                                    <label class="form-label">Middle Name:</label>
                                    <input type="text" name="middlename" class="form-control" value="{{ old('middlename') }}">
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label class="form-label">Last Name:</label>
                                    <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" required>
                                    @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Extension Name -->
                                <div class="mb-3">
                                    <label class="form-label">Extension Name (if any):</label>
                                    <input type="text" name="extname" class="form-control" value="{{ old('extname') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary px-5">Register</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Already have an account? -->
            <div class="text-center mt-3">
                <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
