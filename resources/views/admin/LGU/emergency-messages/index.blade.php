@extends('layouts.lgu')

@section('content')
    <div class="container">

        <!--All Emergency Messages Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Emergency Messages</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sender Contact</th>
                            <th>Message Content</th>
                            <th>Date Recieved</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td>{{ $message->sender_contact }}</td>
                                <td>{{ $message->message_content }}</td>
                                <td>{{ $message->created_at }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $message->status_id == 1 ? 'danger' : ($message->status_id == 2 ? 'warning text-dark' : 'success') }}">
                                        {{ $message->status->name }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('lgu.emergencymessage.view', $message->id) }}"
                                        class="btn btn-sm btn-primary">View</a>

                                </td>
                                <td>
                                    <form id="ongoingForm-{{ $message->id }}"
                                        action="{{ route('lgu.emergencymessage.ongoing', $message->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="message_id" value="{{ $message->id }}">
                                        <button type="button"
                                            onclick="confirmOngoing(event, 'ongoingForm-{{ $message->id }}')"
                                            class="btn btn-sm btn-warning">Ongoing</button>
                                    </form>
                                </td>

                                <td>
                                    <form id="completeForm-{{ $message->id }}"
                                        action="{{ route('lgu.emergencymessage.complete', $message->id) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                            onclick="confirmComplete(event, 'completeForm-{{ $message->id }}')"
                                            class="btn btn-sm btn-success">
                                            Complete
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
