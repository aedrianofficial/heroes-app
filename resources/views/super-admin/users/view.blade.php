@extends('layouts.superadmin')

@section('content')
    <div class="container">
        <div class="col-lg-10">
            <div class="card shadow-lg mt-4">
                
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Name</h5>
                                <p class="text-dark">{{ $user->profile->firstname}} {{ $user->profile->lastname}}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Email</h5>
                                <p class="text-dark">{{ $user->email }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Role</h5>
                                <p class="badge bg-primary px-3 py-2">{{ $user->role->name }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Agency</h5>
                                <p class="text-dark">{{ $user->agency->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Contact Number</h5>
                                <p class="text-dark">{{ $user->contacts->first()->contact_number ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Address</h5>
                                <p class="text-dark">{{ $user->profile->address ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <h5 class="fw-bold text-muted">Date Registered</h5>
                                <p class="text-dark">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                            <div class="mb-4">
                                <h5 class="fw-bold text-muted">Profile Picture</h5>
                                @if ($user->profile->photo)
                                    <img src="{{ asset('storage/' . $user->profile->photo) }}" alt="Profile Picture"
                                        class="rounded shadow-sm border border-primary" width="200" height="200"
                                        style="object-fit: cover;">
                                @else
                                    <p class="text-muted">No profile picture available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between">
                    <a href="{{ route('superadmin.users') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
