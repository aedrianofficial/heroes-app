@extends('layouts.pnp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg mt-4">

                    <div class="card-body">
                        <!-- Caller contact row -->
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Caller Contact</h5>
                                    <p class="text-dark">{{ $call->caller_contact }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Date Received</h5>
                                    <p class="text-dark">{{ $call->created_at }}</p>
                                </div>


                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Status</h5>
                                    <span
                                        class="badge bg-{{ $call->status_id == 1 ? 'danger' : ($call->status_id == 2 ? 'warning text-dark' : 'success') }} px-3 py-2">
                                        {{ $call->status->name }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <h5 class="fw-bold text-muted">Caller Profile</h5>
                                @if ($profile)
                                    <div class="mb-3">
                                        <p><strong>Name:</strong> {{ $profile->first_name }} {{ $profile->middle_name }}
                                            {{ $profile->last_name }} {{ $profile->suffix }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Date of Birth:</strong> {{ $profile->dob }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Sex:</strong> {{ $profile->sex }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Marital Status:</strong> {{ $profile->marital_status }}</p>
                                    </div>
                                @else
                                    <p class="text-muted">No profile information available.</p>
                                @endif
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                @if ($profile)
                                    <div class="mb-3">
                                        <p><strong>Religion:</strong> {{ $profile->religion }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Ethnicity:</strong> {{ $profile->ethnicity }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Birth Place:</strong> {{ $profile->birth_place }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Zone:</strong> {{ $profile->zone }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <p><strong>Barangay:</strong> {{ $profile->nameofbarangay }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        @if ($call->requests->isNotEmpty())
                            @foreach ($call->requests as $index => $request)
                                <div class="border rounded p-3 mb-4 shadow-sm">
                                    <h5 class="fw-bold text-muted">Request {{ $index + 1 }}</h5>
                                    <div class="row">
                                        <!-- Left Column -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <p><strong>Name:</strong> {{ $request->name }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Address:</strong> {{ $request->address }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Description:</strong> {{ $request->description }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <p><strong>Time:</strong> {{ $request->created_at }}</p>
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="col-md-6">
                                            <h5 class="fw-bold text-muted">Assigned Agencies</h5>
                                            @if ($request->agencies->isNotEmpty())
                                                <div class="mb-3">
                                                    <ul>
                                                        @foreach ($request->agencies as $agency)
                                                            <li>{{ $agency->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <p class="text-muted">No assigned agencies</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No requests found for this call.</p>
                        @endif

                        <hr>
                        <div class="mb-3">
                            <h5 class="fw-bold text-muted">Status Log</h5>
                            @if ($call->statusLogCalls->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($call->statusLogCalls as $log)
                                        <li class="list-group-item">
                                            <strong>{{ $log->user->profile->firstname ?? 'Unknown User' }}
                                                {{ $log->user->profile->lastname ?? 'Unknown User' }}

                                            </strong> marked this call as
                                            <span
                                                class="badge bg-{{ $log->status_id == 1 ? 'danger' : ($log->status_id == 2 ? 'warning text-dark' : 'success') }}">
                                                {{ $log->status->name }}
                                            </span>
                                            on {{ $log->created_at->format('F j, Y g:i A') }}.
                                            <br>
                                            <small class="text-muted">Log Details: {{ $log->log_details }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No status logs available.</p>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('pnp.emergencycall.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="ongoingForm-{{ $call->id }}"
                                action="{{ route('pnp.emergencycall.ongoing', $call->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="call_id" value="{{ $call->id }}">
                                <button type="button" onclick="confirmOngoing(event, 'ongoingForm-{{ $call->id }}')"
                                    class="btn btn-sm btn-warning">Ongoing</button>
                            </form>
                            <form id="completeForm-{{ $call->id }}"
                                action="{{ route('pnp.emergencycall.complete', $call->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="confirmComplete(event, 'completeForm-{{ $call->id }}')"
                                    class="btn btn-sm btn-success">
                                    Complete
                                </button>
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

        function confirmOngoing(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this call as ongoing?",
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
                confirmButtonText: "Yes, mark as ongoing!",
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
                text: "Do you want to mark this call as completed?",
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
