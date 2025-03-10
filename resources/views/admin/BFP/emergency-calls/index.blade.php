@extends('layouts.bfp')

@section('content')
    <div class="container">

        <!--All Emergency Calls Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Emergency Calls</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Caller Contact</th>
                            <th>Date Received</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($calls as $call)
                            <tr>
                                <td>{{ $call->caller_contact }}</td>
                                <td>{{ $call->created_at }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $call->status_id == 1 ? 'danger' : ($call->status_id == 2 ? 'warning text-dark' : 'success') }}">
                                        {{ $call->status->name }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('bfp.emergencycall.view', $call->id) }}"
                                        class="btn btn-sm btn-primary">View</a>

                                </td>
                                <td>
                                    <form id="ongoingForm-{{ $call->id }}"
                                        action="{{ route('bfp.emergencycall.ongoing', $call->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="call_id" value="{{ $call->id }}">
                                        <button type="button"
                                            onclick="confirmOngoing(event, 'ongoingForm-{{ $call->id }}')"
                                            class="btn btn-sm btn-warning">Ongoing</button>
                                    </form>
                                </td>

                                <td>
                                    <form id="completeForm-{{ $call->id }}"
                                        action="{{ route('bfp.emergencycall.complete', $call->id) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                            onclick="confirmComplete(event, 'completeForm-{{ $call->id }}')"
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
