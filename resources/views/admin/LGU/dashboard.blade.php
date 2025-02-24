@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Welcome, {{ auth()->user()->profile->firstname }}</h2>
        <p>You are logged in.</p>
        <h2>LGU Dashboard</h2>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
@endsection