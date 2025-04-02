@extends('layouts.mho')

@section('content')
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column: Message and Sender Information -->
                            <div class="col-md-6 border-end">
                                <div class="px-4">
                                    <h3 class="mb-4 text-primary">Message Details</h3>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <h5 class="text-muted">Sender Contact</h5>
                                            <p class="text-dark">{{ $message->sender_contact }}</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="text-muted">Date Received</h5>
                                            <p class="text-dark">{{ $message->created_at->format('F j, Y g:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-muted">Status</h5>
                                        <span
                                            class="badge bg-{{ $message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success') }} px-3 py-2">
                                            {{ $message->status->name }}
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <h5 class="text-muted">Message Content</h5>
                                        <p class="text-dark">{{ $message->message_content }}</p>
                                    </div>

                                    <hr>

                                    <h3 class="mb-4 text-primary">Sender Profile</h3>
                                    @if ($profile)
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Name:</strong> {{ $profile->first_name }}
                                                    {{ $profile->middle_name }} {{ $profile->last_name }}
                                                    {{ $profile->suffix }}</p>
                                                <p><strong>Sex:</strong> {{ $profile->sex }}</p>
                                                <p><strong>Marital Status:</strong> {{ $profile->marital_status }}</p>
                                                <p><strong>Date of Birth:</strong> {{ $profile->dob }}</p>
                                            </div>
                                            <div class="col-6">
                                                <p><strong>Zone:</strong> {{ $profile->zone }}</p>
                                                <p><strong>Barangay:</strong> {{ $profile->nameofbarangay }}</p>
                                                <p><strong>Religion:</strong> {{ $profile->religion }}</p>
                                                <p><strong>Birth Place:</strong> {{ $profile->birth_place }}</p>
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
                                    @if ($message->requests->isNotEmpty())
                                        @foreach ($message->requests as $index => $request)
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
                                                                @if ($request->created_at)
                                                                    {{ $request->created_at->format('F j, Y g:i A') }}
                                                                @else
                                                                    <em>No date available</em>
                                                                @endif
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
                                        <p class="text-muted">No requests found for this message.</p>
                                    @endif

                                    <hr>

                                    <h3 class="mb-4 text-primary">Status Log</h3>
                                    @if ($message->statusLogMessages->isNotEmpty())
                                        <div class="list-group">
                                            @foreach ($message->statusLogMessages as $log)
                                                <div class="list-group-item list-group-item-action mb-2">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            @if ($log->user && $log->user->agency_id)
                                                                @php
                                                                    $agencyLogoPath = '';
                                                                    switch ($log->user->agency_id) {
                                                                        case 2:
                                                                            $agencyLogoPath = 'pnp-logo.png';
                                                                            break;
                                                                        case 3:
                                                                            $agencyLogoPath = 'bfp-logo.png';
                                                                            break;
                                                                        case 4:
                                                                            $agencyLogoPath = 'mdrrmo-logo.jpg';
                                                                            break;
                                                                        case 5:
                                                                            $agencyLogoPath = 'mho-logo.jpg';
                                                                            break;
                                                                        case 6:
                                                                            $agencyLogoPath = 'coastguard-logo.png';
                                                                            break;
                                                                        case 7:
                                                                            $agencyLogoPath = 'lgu-logo.jpg';
                                                                            break;
                                                                        default:
                                                                            $agencyLogoPath = '';
                                                                    }
                                                                @endphp

                                                                @if ($agencyLogoPath)
                                                                    <img src="{{ asset('asset/image/logo/' . $agencyLogoPath) }}"
                                                                        alt="Agency Logo" class="me-2"
                                                                        style="height: 24px; width: auto;">
                                                                @endif
                                                            @endif
                                                            <h5 class="mb-0">
                                                                {{ $log->user->profile->firstname ?? 'Unknown User' }}
                                                                {{ $log->user->profile->lastname ?? 'Unknown User' }}
                                                            </h5>
                                                        </div>
                                                        <small>{{ $log->created_at->format('F j, Y g:i A') }}</small>
                                                    </div>
                                                    <p class="mb-1 mt-2">
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
                        <a href="{{ route('bfp.emergencymessage.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="respondedForm-{{ $message->id }}"
                                action="{{ route('mho.emergencymessage.responded', $message->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="message_id" value="{{ $message->id }}">
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="{{ $message->status_id == 3 ? 'This case is already completed' : ($message->requests->isNotEmpty() ? 'Mark as responded' : 'No requests to respond to') }}">
                                    <button type="button"
                                        onclick="confirmResponded(event, 'respondedForm-{{ $message->id }}')"
                                        class="btn btn-sm btn-warning action-btn"
                                        {{ $message->status_id == 3 || $message->requests->isEmpty() ? 'disabled' : '' }}>
                                        Responded
                                    </button>
                                </span>
                            </form>

                            <form id="completeForm-{{ $message->id }}"
                                action="{{ route('mho.emergencymessage.complete', $message->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                    title="{{ $message->status_id == 3 ? 'This case is already completed' : ($message->requests->isEmpty() ? 'No requests to complete' : ($message->can_complete ? 'Mark as Complete' : 'Required agencies must respond first' . (!empty($message->missing_agencies) ? ' (' . implode(', ', $message->missing_agencies) . ')' : ''))) }}">
                                    <button type="button"
                                        onclick="confirmComplete(event, 'completeForm-{{ $message->id }}')"
                                        class="btn btn-sm btn-success action-btn"
                                        {{ $message->status_id == 3 || $message->requests->isEmpty() ? 'disabled' : ($message->can_complete ? '' : 'disabled') }}>
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
            var tooltipTriggerList = [].slice.message(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <!--sweet alert-->
    <!--Mark as Responded-->
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
                        Swal.showValidationMessage("Log details are required!");
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
                        Swal.showValidationMessage("Log details are required!");
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
