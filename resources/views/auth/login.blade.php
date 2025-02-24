@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Login</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        <!-- Username or Email -->
                        <div class="mb-3">
                            <label class="form-label">Username or Email:</label>
                            <input type="text" name="login" class="form-control" value="{{ old('login') }}" required>
                            @error('login') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember_token" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <!-- Login Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Register Link -->
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="{{ route('register.form') }}">Register here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
