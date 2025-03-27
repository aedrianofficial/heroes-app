@extends('layouts.pnp')

@section('content')
    <div class="container">

        <!--All Reports Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>Reports</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Incident Type</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->name }}</td>
                                    <td>{{ $report->incidentType->name }}</td>
                                    <td>{{ $report->description }}</td>
                                    <td>{{ $report->location->address }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $report->status_id == 1 ? 'danger' : ($report->status_id == 2 ? 'warning text-dark' : 'success') }}">
                                            {{ $report->status->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pnp.reports.view', $report->id) }}"
                                            class="btn btn-sm btn-primary">View</a>

                                    </td>
                                    <td>
                                        <form action="{{ route('pnp.reports.responded', $report->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="confirmResponded(event)"
                                                class="btn btn-sm btn-warning ">Responded</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('pnp.reports.complete', $report->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="confirmComplete(event)"
                                                class="btn btn-sm btn-success ">Complete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $reports->links('pagination::bootstrap-5', ['paginator' => $reports, 'elements' => [1 => $reports->getUrlRange(1, $reports->lastPage())], 'onEachSide' => 1]) }}
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

        function confirmResponded(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as responded?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as responded!",
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

        function confirmResponded(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as responded?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ffc107",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as responded!",
                customClass: {
                    confirmButton: 'text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit();
                }
            });
        }

        function confirmComplete(event) {
            event.preventDefault();

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to mark this report as completed?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Yes, mark as completed!"
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.closest("form").submit();
                }
            });
        }
    </script>
@endsection
