@extends('layouts.bfp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg mt-4">

                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Sender Contact</h5>
                                    <p class="text-dark">{{ $message->sender_contact }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Message Content</h5>
                                    <p class="text-dark">{{ $message->message_content }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Date recieve</h5>
                                    <p class="text-dark">{{ $message->created_at }}</p>
                                </div>
                                {{-- <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Address</h5>
                                    <p class="text-dark">{{ $message->location->address }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Contact Number</h5>
                                    <p class="text-dark">{{ $message->contact_number }}</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Coordinates</h5>
                                    <p>({{ $message->location->latitude }},
                                        {{ $message->location->longitude }})
                                    </p>
                                </div> --}}

                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Status</h5>
                                    <span
                                        class="badge bg-{{ $message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success') }} px-3 py-2">
                                        {{ $message->status->name }}
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Incident Type</h5>
                                    {{-- <p>
                                      @foreach ($message->agencies as $agency)
                                          <span class="badge bg-primary px-3 py-2">{{ $agency->name }}</span>
                                      @endforeach
                                  </p> --}}
                                    <p>Test</p>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-muted">Agencies Involved</h5>
                                    {{-- <p>
                                        @foreach ($message->agencies as $agency)
                                            <span class="badge bg-primary px-3 py-2">{{ $agency->name }}</span>
                                        @endforeach
                                    </p> --}}
                                    <p>Test</p>
                                </div>
                                {{-- <div class="mb-4">
                                    <h5 class="fw-bold text-muted">Attachments</h5>
                                    @if ($message->messageAttachments->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach ($message->messageAttachments as $attachment)
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
                        <div class="mb-3">
                            <h5 class="fw-bold text-muted">Status Log</h5>
                            @if ($message->statusLogMessages->isNotEmpty())
                                <ul class="list-group">
                                    @foreach ($message->statusLogMessages as $log)
                                        <li class="list-group-item">
                                            <strong>{{ $log->user->profile->firstname ?? 'Unknown User' }}
                                                {{ $log->user->profile->lastname ?? 'Unknown User' }}

                                            </strong> marked this message as
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
                        <a href="{{ route('bfp.emergencymessage.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div class="d-flex gap-2">
                            <form id="ongoingForm-{{ $message->id }}"
                                action="{{ route('bfp.emergencymessage.ongoing', $message->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="message_id" value="{{ $message->id }}">
                                <button type="button" onclick="confirmOngoing(event, 'ongoingForm-{{ $message->id }}')"
                                    class="btn btn-sm btn-warning">Ongoing</button>
                            </form>
                            <form id="completeForm-{{ $message->id }}"
                                action="{{ route('bfp.emergencymessage.complete', $message->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="confirmComplete(event, 'completeForm-{{ $message->id }}')"
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

        function confirmOngoing(event, formId) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this message as ongoing?",
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
                text: "Do you want to mark this message as completed?",
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