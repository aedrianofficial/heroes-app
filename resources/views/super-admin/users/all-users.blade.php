@extends('layouts.superadmin')

@section('content')
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
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->profile->firstname }} {{ $user->profile->lastname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->agency->name ?? 'N/A' }}</td>
                                    <td>{{ $user->contacts->first()->contact_number ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('superadmin.users.view', $user->id) }}"
                                            class="btn btn-sm btn-primary">View</a>
                                        <a href="{{ route('superadmin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>


                                        {{-- <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
