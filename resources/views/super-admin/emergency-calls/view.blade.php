@extends('layouts.superadmin')

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
                                    <p class="text-dark">{{ $call->created_at->format('F j, Y g:i A') }}</p>
                                </div>
                                {{-- <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Date recieve</h5>
                                    <p class="text-dark">{{ $call->created_at }}</p>
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Address</h5>
                                    <p class="text-dark">{{ $call->location->address }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Contact Number</h5>
                                    <p class="text-dark">{{ $call->contact_number }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Coordinates</h5>
                                    <p>({{ $call->location->latitude }},
                                        {{ $call->location->longitude }})
                                    </p>
                                </div> --}}

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
                                {{-- <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Incident Type</h5>
                                    <p>
                                      @foreach ($call->agencies as $agency)
                                          <span class="badge bg-primary px-3 py-2">{{ $agency->name }}</span>
                                      @endforeach
                                  </p> 
                                    <p>Test</p>
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Agencies Involved</h5>
                                    <p>
                                        @foreach ($call->agencies as $agency)
                                            <span class="badge bg-primary px-3 py-2">{{ $agency->name }}</span>
                                        @endforeach
                                    </p> 
                                    <p>Test</p>
                                </div> --}}
                                {{-- <div class="mb-4">
                                    <h5 class="fw-bold text-muted">Attachments</h5>
                                    @if ($call->callAttachments->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($call->callAttachments as $attachment)
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
                                </div> --}}
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
                                                <p><strong>Time:</strong>
                                                    {{ $request->created_at ? $request->created_at->format('F j, Y g:i A') : 'N/A' }}
                                                </p>
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
                            <h3 class="mb-4 text-primary">Status Log</h3>
                            @if ($call->statusLogCalls->isNotEmpty())
                                <div class="list-group">
                                    @foreach ($call->statusLogCalls as $log)
                                        <div class="list-group-item list-group-item-action mb-2">
                                            <div class="d-flex w-100 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @if($log->user && $log->user->agency_id)
                                                        @php
                                                            $agencyLogoPath = '';
                                                            switch($log->user->agency_id) {
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
                                                        
                                                        @if($agencyLogoPath)
                                                            <img src="{{ asset('asset/image/logo/' . $agencyLogoPath) }}" 
                                                                 alt="Agency Logo" 
                                                                 class="me-2" 
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
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('superadmin.emergencycall.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="respondedForm-{{ $call->id }}"
                                action="{{ route('superadmin.emergencycall.responded', $call->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="call_id" value="{{ $call->id }}">
                                <button type="button" onclick="confirmResponded(event, 'respondedForm-{{ $call->id }}')"
                                    class="btn btn-sm btn-warning">Responded</button>
                            </form>
                            <form id="completeForm-{{ $call->id }}"
                                action="{{ route('superadmin.emergencycall.complete', $call->id) }}" method="POST">
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
