@extends('layouts.coastguard')
@section('content')
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column: Call and Caller Information -->
                            <div class="col-md-6 border-end">
                                <div class="px-4">
                                    <h3 class="mb-4 text-primary">Call Details</h3>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <h5 class="text-muted">Caller Contact</h5>
                                            <p class="text-dark">{{ $call->caller_contact }}</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-muted">Date Received</h5>
                                            <p class="text-dark">{{ $call->created_at->format('F j, Y g:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-muted">Status</h5>
                                        <span
                                            class="badge bg-{{ $call->status_id == 1 ? 'danger' : ($call->status_id == 2 ? 'warning text-dark' : 'success') }} px-3 py-2">
                                            {{ $call->status->name }}
                                        </span>
                                    </div>

                                    <hr>

                                    <h3 class="mb-4 text-primary">Caller Profile</h3>
                                    @if ($profile)
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Name:</strong> {{ $profile->first_name }}
                                                    {{ $profile->middle_name }} {{ $profile->last_name }}
                                                    {{ $profile->suffix }}</p>
                                                <p><strong>Sex:</strong> {{ $profile->sex }}</p>
                                                <p><strong>Marital Status:</strong> {{ $profile->marital_status }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p><strong>Zone:</strong> {{ $profile->zone }}</p>
                                                <p><strong>Barangay:</strong> {{ $profile->nameofbarangay }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted">No profile information available.</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Right Column: Requests and Status Log -->
                            <div class="col-md-6">
                                <div class="px-4">
                                    <h3 class="mb-4 text-primary">Requests</h3>
                                    @if ($call->requests->isNotEmpty())
                                        @foreach ($call->requests as $index => $request)
                                            <div class="card mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title text-muted">Request {{ $index + 1 }}</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p><strong>Name:</strong> {{ $request->name }}</p>
                                                            <p><strong>Address:</strong> {{ $request->address }}</p>
                                                            <p><strong>Description:</strong> {{ $request->description }}
                                                            </p>
                                                            <p><strong>Time:</strong>
                                                                {{ $request->created_at->format('F j, Y g:i A') }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <h6 class="text-muted">Assigned Agencies</h6>
                                                            @if ($request->agencies->isNotEmpty())
                                                                <ul class="list-unstyled">
                                                                    @foreach ($request->agencies as $agency)
                                                                        <li>{{ $agency->name }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p class="text-muted">No assigned agencies</p>
                                                            @endif

                                                            @if ($request->incidentCase)
                                                                <h6 class="text-muted mt-3">Incident Case</h6>
                                                                <p><strong>Case Number:</strong>
                                                                    {{ $request->incidentCase->case_number }}</p>
                                                            @else
                                                                <p class="text-muted">No Incident Case Assigned</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No requests found for this call.</p>
                                    @endif

                                    <hr>

                                    <h3 class="mb-4 text-primary">Status Log</h3>
                                    @if ($call->statusLogCalls->isNotEmpty())
                                        <div class="list-group">
                                            @foreach ($call->statusLogCalls as $log)
                                                <div class="list-group-item list-group-item-action mb-2">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h5 class="mb-1">
                                                            {{ $log->user->profile->firstname ?? 'Unknown User' }}
                                                            {{ $log->user->profile->lastname ?? 'Unknown User' }}
                                                        </h5>
                                                        <small>{{ $log->created_at->format('F j, Y g:i A') }}</small>
                                                    </div>
                                                    <p class="mb-1">
                                                        Marked as
                                                        <span
                                                            class="badge bg-{{ $log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning text-dark' : 'success') }}">
                                                            {{ $log->status->name }}
                                                        </span>
                                                    </p>
                                                    <small><strong>Log Details:</strong> {{ $log->log_details }}</small>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No status logs available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('coastguard.emergencycall.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="respondedForm-{{ $call->id }}"
                                action="{{ route('coastguard.emergencycall.responded', $call->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <input type="hidden" name="call_id" value="{{ $call->id }}">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="{{ $call->status_id == 3 ? 'This case is already completed' : ($call->requests->isNotEmpty() ? 'Mark as responded' : 'No requests to respond to') }}">
                                    <button type="button"
                                        onclick="confirmResponded(event, 'respondedForm-{{ $call->id }}')"
                                        class="btn btn-sm btn-warning action-btn"
                                        {{ $call->status_id == 3 || $call->requests->isEmpty() ? 'disabled' : '' }}>
                                        Responded
                                    </button>
                                </span>
                            </form>
                        
                            <form id="completeForm-{{ $call->id }}"
                                action="{{ route('coastguard.emergencycall.complete', $call->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="{{ $call->status_id == 3 ? 'This case is already completed' : ($call->requests->isEmpty() ? 'No requests to complete' : ($call->can_complete ? 'Mark as Complete' : 'Required agencies must respond first')) }}">
                                    <button type="button"
                                        onclick="confirmComplete(event, 'completeForm-{{ $call->id }}')"
                                        class="btn btn-sm btn-success action-btn"
                                        {{ $call->status_id == 3 || $call->requests->isEmpty() ? 'disabled' : ($call->can_complete ? '' : 'disabled') }}>
                                        Complete
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!--Initialize tooltips-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <!--sweet alert-->
    <!--Mark as Responded-->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successCall = "{{ session('success') }}";
            let errorCall = "{{ session('error') }}";

            if (successCall) {
                Swal.fire({
                    title: "Success!",
                    text: successCall,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorCall) {
                Swal.fire({
                    title: "Error!",
                    text: errorCall,
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        function confirmResponded(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this case as responded?",
                icon: "warning",
                input: "textarea",
                inputLabel: "Log Details",
                inputPlaceholder: "Enter log details here...",
                inputAttributes: {
                    required: true
                },
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as responded!",
                customClass: {
                    confirmButton: 'text-dark'
                },
                preConfirm: (logDetails) => {
                    if (!logDetails) {
                        Swal.showValidationCall("Log details are required!");
                    }
                    return logDetails;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById(formId);
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "log_details";
                    input.value = result.value;
                    form.appendChild(input);

                    form.submit();
                }
            });
        }
    </script>

    <!--Mark as Completed-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successCall = "{{ session('success') }}";
            let errorCall = "{{ session('error') }}";

            if (successCall) {
                Swal.fire({
                    title: "Success!",
                    text: successCall,
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorCall) {
                Swal.fire({
                    title: "Error!",
                    text: errorCall,
                    icon: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });


        function confirmComplete(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this case as completed?",
                icon: "warning",
                input: "textarea",
                inputLabel: "Log Details",
                inputPlaceholder: "Enter log details here...",
                inputAttributes: {
                    required: true
                },
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as completed!",
                preConfirm: (logDetails) => {
                    if (!logDetails) {
                        Swal.showValidationCall("Log details are required!");
                    }
                    return logDetails;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById(formId);
                    let input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "log_details";
                    input.value = result.value;
                    form.appendChild(input);

                    form.submit();
                }
            });
        }
    </script>
@endsection
