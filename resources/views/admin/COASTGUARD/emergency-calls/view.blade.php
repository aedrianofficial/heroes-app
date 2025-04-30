<!--call-->
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

                                    @if ($call->caller_description)
                                        <div class="mb-3">
                                            <h5 class="text-muted">Caller Description</h5>
                                            <p class="text-dark">{{ $call->caller_description }}</p>
                                        </div>
                                    @endif

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
                                    title="{{ $call->status_id == 3 ? 'This case is already completed' : ($call->requests->isEmpty() ? 'No requests to complete' : ($call->can_complete ? 'Mark as Complete' : 'Required agencies must respond first' . (!empty($call->missing_agencies) ? ' (' . implode(', ', $call->missing_agencies) . ')' : ''))) }}">
                                    <button type="button"
                                        onclick="confirmComplete(event, 'completeForm-{{ $call->id }}')"
                                        class="btn btn-sm btn-success action-btn"
                                        {{ $call->status_id == 3 || $call->requests->isEmpty() ? 'disabled' : ($call->can_complete ? '' : 'disabled') }}>
                                        Complete
                                    </button>
                                </span>
                            </form>
                            @if ($call->status_id == 3)
                                @php
                                    $allCasesHaveReports = true;
                                    $caseIds = [];
                                    $reportsInfo = [];

                                    // Collect all incident case IDs for this call
                                    foreach ($call->requests as $request) {
                                        if ($request->incidentCase) {
                                            $caseIds[] = $request->incidentCase->id;

                                            // Check if this case has a report and store report info
                                            $report = \App\Models\IncidentReport::where(
                                                'incident_case_id',
                                                $request->incidentCase->id,
                                            )->first();
                                            if ($report) {
                                                $reportsInfo[] = [
                                                    'id' => $report->id,
                                                    'case_number' => $request->incidentCase->case_number,
                                                ];
                                            }
                                        }
                                    }

                                    // Check if each case already has a report
                                    if (!empty($caseIds)) {
                                        foreach ($caseIds as $caseId) {
                                            $reportExists = \App\Models\IncidentReport::where(
                                                'incident_case_id',
                                                $caseId,
                                            )->exists();
                                            if (!$reportExists) {
                                                $allCasesHaveReports = false;
                                                break;
                                            }
                                        }
                                    } else {
                                        // No cases, so can't generate report
                                        $allCasesHaveReports = true;
                                    }
                                @endphp

                                <span class="d-inline-block">
                                    @if (!$allCasesHaveReports)
                                        <button type="button" class="btn btn-sm btn-primary action-btn"
                                            data-bs-toggle="modal" data-bs-target="#generateReportModal">
                                            Generate Report
                                        </button>

                                        <!-- Generate Report Modal -->
                                        <div class="modal fade" id="generateReportModal" tabindex="-1"
                                            aria-labelledby="generateReportModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ route('coastguard.incident_reports.generate.with_source', ['id' => $call->id, 'source_type' => 'call']) }}"
                                                        method="GET">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="generateReportModalLabel">Generate
                                                                Incident Report</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-4">
                                                                <h6 class="text-muted mb-3">Call Information</h6>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p><strong>Caller Contact:</strong>
                                                                            {{ $call->caller_contact }}</p>
                                                                        <p><strong>Date Received:</strong>
                                                                            {{ $call->created_at->format('F j, Y g:i A') }}
                                                                        </p>
                                                                    </div>
                                                                    <div class="col-md-6">

                                                                        <p><strong>Case Number(s):</strong>
                                                                            @foreach ($call->requests as $request)
                                                                                @if ($request->incidentCase)
                                                                                    <span
                                                                                        class="badge bg-info">{{ $request->incidentCase->case_number }}</span>
                                                                                @endif
                                                                            @endforeach
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="resolution_details"
                                                                    class="form-label">Resolution
                                                                    Details <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" id="resolution_details" name="resolution_details" rows="5" required
                                                                    placeholder="Provide detailed information about how this incident was resolved..."></textarea>
                                                                <small class="form-text text-muted">
                                                                    Include actions taken, resources deployed, outcomes, and
                                                                    any
                                                                    follow-up requirements.
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Generate
                                                                Report</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-secondary action-btn" disabled
                                                title="Reports already generated for all cases">
                                                Reports Generated
                                            </button>


                                            @if (!empty($reportsInfo))
                                                <button type="button"
                                                    class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="visually-hidden">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @foreach ($reportsInfo as $reportInfo)
                                                        <li class="dropdown-item-text">
                                                            <small class="text-muted">Case
                                                                #{{ $reportInfo['case_number'] }}</small>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('coastguard.incident_reports.view', $reportInfo['id']) }}"
                                                                target="_blank">
                                                                <i class="fas fa-eye me-1"></i> View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('coastguard.incident_reports.download', $reportInfo['id']) }}">
                                                                <i class="fas fa-download me-1"></i> Download
                                                            </a>
                                                        </li>
                                                        @if (!$loop->last)
                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endif
                                </span>
                            @endif
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
