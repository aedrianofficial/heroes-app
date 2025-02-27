@extends('layouts.bfp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $report->title }}</h4>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Description</h5>
                                    <p class="text-dark">{{ $report->description }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Incident Type</h5>
                                    <p class="badge bg-danger px-3 py-2">{{ $report->incidentType->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Address</h5>
                                    <p class="text-dark">{{ $report->location->address }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Contact Number</h5>
                                    <p class="text-dark">{{ $report->contact_number }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Coordinates</h5>
                                    <p>({{ $report->location->latitude }},
                                        {{ $report->location->longitude }})
                                    </p>
                                </div>

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Status</h5>
                                    <span
                                        class="badge bg-{{ $report->status_id == 1 ? 'danger' : ($report->status_id == 2 ? 'warning text-dark' : 'success') }} px-3 py-2">
                                        {{ $report->status->name }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Agencies Involved</h5>
                                    <p>
                                        @foreach ($report->agencies as $agency)
                                            <span class="badge bg-primary px-3 py-2">{{ $agency->name }}</span>
                                        @endforeach
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="fw-bold text-muted">Attachments</h5>
                                    @if ($report->reportAttachments->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($report->reportAttachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $attachment->file_path) }}"
                                                        alt="Attachment" class="rounded shadow-sm border border-primary"
                                                        width="200" height="200" style="object-fit: cover;">
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No attachments available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('admin.bfp.reports') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form action="{{ route('bfp.reports.ongoing', $report->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="confirmOngoing(event)" class="btn btn-sm btn-warning">Mark
                                    as Ongoing</button>
                            </form>
                            <form action="{{ route('bfp.reports.resolve', $report->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="confirmResolve(event)" class="btn btn-sm btn-success">Mark
                                    as Resolved</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!--sweet alert-->
    <!--Mark as Ongoing-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successMessage = "{{ session('success') }}";
            let errorMessage = "{{ session('error') }}";

            if (successMessage) {
                Swal.fire({
                    title: "Success!",
                    text: successMessage,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: "Error!",
                    text: errorMessage,
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        function confirmOngoing(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as ongoing?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as ongoing!",
                customClass: {
                    confirmButton: 'text-dark' // Add this line to change the text color to black
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit(); // Submits the form normally
                }
            });
        }
    </script>
    <!--Mark as Resolved-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successMessage = "{{ session('success') }}";
            let errorMessage = "{{ session('error') }}";

            if (successMessage) {
                Swal.fire({
                    title: "Resolved!",
                    text: successMessage,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: "Error!",
                    text: errorMessage,
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        function confirmOngoing(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as ongoing?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as ongoing!",
                customClass: {
                    confirmButton: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit();
                }
            });
        }

        function confirmResolve(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as resolved?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as resolved!"
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit();
                }
            });
        }
    </script>
@endsection
