@extends('layouts.user')

@section('content')

    <h2>My Reports</h2>
    @foreach ($reports as $report)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $report->title }}</h5>
                <p class="card-text">{{ $report->description }}</p>
                <p><strong>Agency:</strong> {{ $report->agency->name }}</p>
                <p><strong>Status:</strong> <span class="badge bg-info">{{ $report->status->name }}</span></p>
               
            </div>
        </div>
    @endforeach

@endsection
