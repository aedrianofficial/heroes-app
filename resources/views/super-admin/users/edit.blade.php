@extends('layouts.superadmin')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h5>Edit User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" value="{{ $user->profile->firstname }}" required>
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" value="{{ $user->profile->lastname }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="role_id" class="form-label">Role</label>
                    <select name="role_id" class="form-control" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role->id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="agency_id" class="form-label">Agency</label>
                    <select name="agency_id" class="form-control">
                        <option value="">None</option>
                        @foreach ($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ $user->agency && $user->agency->id == $agency->id ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="contact_number" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" name="contact_number" value="{{ $user->contacts->first()->contact_number ?? '' }}">
                </div>

                <button type="submit" class="btn btn-success">Update User</button>
                <a href="{{ route('superadmin.users.view', $user->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
