@extends('layouts.user')

@section('content')

    <h2 class="mb-4">My Reports</h2>

    @if ($reports->isEmpty())
        <div class="alert alert-warning">No reports found.</div>
    @else
        <div class="row">
            @foreach ($reports as $report)
                <div class="col-md-6"> <!-- Two-column layout -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $report->title }}</h5>
                            <hr>

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <p><strong>Description:</strong> {{ $report->description }}</p>
                                    <p><strong>Incident Type:</strong> {{ $report->incidentType->name }}</p>
                                    <p><strong>Contact Number:</strong> {{ $report->contact_number }}</p>
                                    <p><strong>Address:</strong> {{ $report->location->address }}</p>
                                    <p><strong>Coordinates:</strong> ({{ $report->location->latitude }},
                                        {{ $report->location->longitude }})
                                    </p>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <p><strong>Agencies:</strong>
                                        @foreach ($report->agencies as $agency)
                                            <span class="badge bg-primary">{{ $agency->name }}</span>
                                        @endforeach
                                    </p>

                                    <p><strong>Status:</strong>
                                        <span class="badge bg-info">{{ $report->status->name }}</span>
                                    </p>

                                    @if ($report->reportAttachments && $report->reportAttachments->isNotEmpty())
                                        <p><strong>Attachments:</strong></p>
                                        <div class="d-flex flex-wrap">
                                            @foreach ($report->reportAttachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                        alt="Report Attachment"
                                                        class="img-thumbnail m-1"
                                                        style="max-width: 100px; height: 100px;">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p><strong>Attachments:</strong> No attachments uploaded.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
