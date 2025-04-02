@extends('layouts.bfp')
@section('styles')
    <style>
        /* Equal-sized buttons */
        .action-btn {
            width: 90px;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media screen and (max-width: 767px) {
            .table-responsive .table {
                border: 0;
            }

            .table-responsive .table thead {
                display: none;
            }

            .table-responsive .table tr {
                display: block;
                margin-bottom: 1.5rem;
                border: 1px solid #dee2e6;
                border-radius: 0.25rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }

            .table-responsive .table td {
                display: block;
                text-align: right;
                padding: 0.75rem;
                border-bottom: 1px solid #dee2e6;
            }

            .table-responsive .table td:last-child {
                border-bottom: 0;
            }

            .table-responsive .table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
            }

            .table-responsive .table td.text-center {
                text-align: center !important;
            }

            .table-responsive .table td.text-center::before {
                display: block;
                float: none;
                text-align: center;
                margin-bottom: 0.5rem;
            }

            .table-responsive .table td.action-btns {
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .table-responsive .table td.action-btns .d-flex {
                flex-direction: column;
                width: 100%;
            }

            .table-responsive .table td.action-btns .action-btn {
                width: 100px;
            }

        }
    </style>
@endsection
@section('content')
    <div class="container">

        <!--All Emergency Messages Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Cases</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Incident Case</th>
                                <th>Sender Contact</th>
                                <th>Message Content</th>
                                <th>Message Date</th>
                                <th>Status</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($messages as $message)
                                <tr>
                                    <td data-label="Incident Case">
                                        @if ($message->requests->isNotEmpty())
                                            @foreach ($message->requests as $request)
                                                {{ optional($request->incidentCase)->case_number ?? 'N/A' }}<br>
                                            @endforeach
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td data-label="Sender Contact">{{ $message->sender_contact }}</td>
                                    <td data-label="Message">{{ Str::limit($message->message_content, 50) }}</td>
                                    <td data-label="Message Date">{{ $message->created_at }}</td>
                                    <td data-label="Status">
                                        <span
                                            class="badge bg-{{ $message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success') }}">
                                            {{ $message->status->name }}
                                        </span>
                                    </td>
                                    <td class="action-btns" data-label="View">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <div class="d-inline">
                                                <a href="{{ route('bfp.emergencymessage.view', $message->id) }}"
                                                    class="btn btn-sm btn-danger action-btn">View</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-btns" data-label="Actions">
                                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                                            <form id="respondedForm-{{ $message->id }}"
                                                action="{{ route('bfp.emergencymessage.responded', $message->id) }}"
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
                                                action="{{ route('bfp.emergencymessage.complete', $message->id) }}"
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
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No emergency messages found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $messages->links('pagination::bootstrap-5', ['paginator' => $messages, 'elements' => [1 => $messages->getUrlRange(1, $messages->lastPage())], 'onEachSide' => 1]) }}
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
