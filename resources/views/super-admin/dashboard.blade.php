@extends('layouts.superadmin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">SUPER ADMIN Dashboard</h1>
        </div>
        <!-- Table -->
        <div class="card my-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Vehicle Requests</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vehicleRequestModal">
                    <i class="bi bi-plus-circle me-1"></i> New Request
                </button>
            </div>
            <div class="card-body">
                <!-- Vehicle Requests Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Requestor</th>
                                <th>Vehicle Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Requested On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicleRequests as $request)
                                <tr>
                                    <td>{{ $request->full_name }}</td>
                                    <td>{{ $request->vehicle_type }}</td>
                                    <td>
                                        @if ($request->priority == 'Low')
                                            <span class="badge bg-success">Low</span>
                                        @elseif($request->priority == 'Medium')
                                            <span class="badge bg-warning text-dark">Medium</span>
                                        @else
                                            <span class="badge bg-danger">High</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($request->status == 'Pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($request->status == 'Approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($request->status == 'Rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-info">Completed</span>
                                        @endif
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary text-white view-request-btn"
                                            data-bs-toggle="modal" data-bs-target="#viewRequestModal"
                                            data-id="{{ $request->id }}" data-name="{{ $request->full_name }}"
                                            data-vehicle="{{ $request->vehicle_type }}"
                                            data-location="{{ $request->location }}"
                                            data-quantity="{{ $request->quantity }}" data-reason="{{ $request->reason }}"
                                            data-priority="{{ $request->priority }}" data-status="{{ $request->status }}"
                                            data-created="{{ $request->created_at->format('M d, Y h:i A') }}">
                                            <i class="bi bi-eye-fill"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No vehicle requests found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $vehicleRequests->links() }}
                </div>
            </div>
        </div>

        <!-- View Request Modal -->
        <div class="modal fade" id="viewRequestModal" tabindex="-1" aria-labelledby="viewRequestModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="viewRequestModalLabel">Vehicle Request Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Request Information</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Requestor Name:</label>
                                    <p id="modal-name"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Vehicle Type:</label>
                                    <p id="modal-vehicle"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Number of vehicles:</label>
                                    <p id="modal-quantity"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-2">Additional Details</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Location:</label>
                                    <p id="modal-location"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Priority:</label>
                                    <p id="modal-priority"></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Requested On:</label>
                                    <p id="modal-created"></p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Purpose/Reason:</label>
                            <p id="modal-reason"></p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Current Status:</label>
                            <p id="modal-status"></p>
                        </div>

                        <div class="mt-4 border-top pt-4">
                            <h6 class="mb-3">Update Request Status</h6>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success status-action-modal-btn"
                                    data-status="Approved">
                                    <i class="bi bi-check-circle me-1"></i> Approve
                                </button>
                                <button type="button" class="btn btn-danger status-action-modal-btn"
                                    data-status="Rejected">
                                    <i class="bi bi-x-circle me-1"></i> Reject
                                </button>
                                <button type="button" class="btn btn-primary status-action-modal-btn"
                                    data-status="Completed">
                                    <i class="bi bi-flag-fill me-1"></i> Completed
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden forms for submitting actions -->
        <form id="status-form-Approved" action="" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Approved">
        </form>
        <form id="status-form-Rejected" action="" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Rejected">
        </form>
        <form id="status-form-Completed" action="" method="POST" style="display: none;">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="Completed">
        </form>



        <!-- Vehicle Request Modal -->
        <div class="modal fade" id="vehicleRequestModal" tabindex="-1" aria-labelledby="vehicleRequestModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="vehicleRequestModalLabel">Request Vehicle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="vehicleRequestForm" action="{{ route('superadmin.request_vehicle.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="vehicle_type" class="form-label">Vehicle Type</label>
                                <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                                    <option value="">Select Vehicle Type</option>
                                    <option value="Ambulance">Ambulance</option>
                                    <option value="Fire Truck">Fire Truck</option>
                                    <option value="Rescue Vehicle">Rescue Vehicle</option>
                                    <option value="Transportation Vehicle">Transportation Vehicle</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Number of Vehicles</label>
                                <input type="number" class="form-control" id="quantity" name="quantity"
                                    min="1" value="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason/Purpose</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select" id="priority" name="priority" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="confirmRequest" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Date Range Selector -->
        <div class="card my-4">
            <div class="card-header">Filter Call Analytics</div>
            <div class="card-body">
                <div class="dropdown mb-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dashboardTypeDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request()->is('*/message-analytics') ? 'Message Analytics' : 'Call Analytics' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dashboardTypeDropdown">
                        <li><a class="dropdown-item {{ !request()->is('*/message-analytics') ? 'active' : '' }}"
                                href="{{ route('superadmin.dashboard') }}">Call Analytics</a></li>
                        <li><a class="dropdown-item {{ request()->is('*/message-analytics') ? 'active' : '' }}"
                                href="{{ route('superadmin.dashboard') }}/message-analytics">Message Analytics</a></li>
                    </ul>
                </div>

                <form id="filterForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="agency_id" class="form-label">Agency</label>
                        <select class="form-select" id="agency_id" name="agency_id">
                            <option value="">All Agencies</option>
                            @foreach ($agencies as $agency)
                                <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Calls</h5>
                        <h2 class="card-text" id="total-calls">Loading...</h2>
                    </div>
                </div>
            </div>



            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Requests</h5>
                        <h2 class="card-text" id="total-requests">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Request Views</h5>
                        <h2 class="card-text" id="total-request-views">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Call Views</h5>
                        <h2 class="card-text" id="total-call-views">Loading...</h2>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="mb-4">Incident Case Summary</h2>
        <!--Incident Case Summary -->
        <div class="row mb-4 g-3">
            <div class="col-md-4 col-lg-2">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">CRIME</h5>
                        <h2 class="card-text">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">ROAD</h5>
                        <h2 class="card-text">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">HEALTH</h5>
                        <h2 class="card-text">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">DISASTER</h5>
                        <h2 class="card-text">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">SEA</h5>
                        <h2 class="card-text">Loading...</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-2">
                <div class="card bg-orange text-white h-100" style="background-color: #fd7e14;">
                    <div class="card-body">
                        <h5 class="card-title">FIRE</h5>
                        <h2 class="card-text">Loading...</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Call Volume Chart -->
        <div class="row mb-4 g-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Daily Call Volume</div>
                    <div class="card-body">
                        <canvas id="callVolumeChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Call Status Distribution</div>
                    <div class="card-body">
                        <canvas id="statusDistributionChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Agencies and Activity Section -->
        <div class="row mb-4 g-3">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Top Agencies Activity by Creating Requests</div>
                    <div class="card-body">
                        <canvas id="topAgenciesRequestChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Top Agencies Activity by Request Views</div>
                    <div class="card-body">
                        <canvas id="topAgenciesActivityRequest" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Top Agencies Activity by Call Views</div>
                    <div class="card-body">
                        <canvas id="topAgenciesCallViewChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Agency Performance Table -->
        <div class="card mb-4">
            <div class="card-header">Agency Performance</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="agencyPerformanceTable">
                        <thead>
                            <tr>
                                <th>Agency</th>
                                <th>Total Requests</th>
                                <th>Request Views</th>
                                <th>Call Views</th>
                                <th>Last Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="text-center">Loading data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch incident counts from the API
            fetch('/api/incident-counts')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Update each incident type card
                    updateCardValue('CRIME', data.CRIME || 0);
                    updateCardValue('ROAD', data.ROAD || 0);
                    updateCardValue('HEALTH', data.HEALTH || 0);
                    updateCardValue('DISASTER', data.DISASTER || 0);
                    updateCardValue('SEA', data.SEA || 0);
                    updateCardValue('FIRE', data.FIRE || 0);

                    // Update total incidents card
                    updateCardValue('TOTAL INCIDENTS', data.TOTAL || 0);
                })
                .catch(error => {
                    console.error('Error fetching incident counts:', error);
                    document.querySelectorAll('.card-text').forEach(element => {
                        element.textContent = 'Error loading data';
                    });
                });

            // Helper function to update card values
            function updateCardValue(title, value) {
                const cards = document.querySelectorAll('.card-title');
                for (let i = 0; i < cards.length; i++) {
                    if (cards[i].textContent === title) {
                        cards[i].nextElementSibling.textContent = value;
                        break;
                    }
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            let callVolumeChart = null;
            let statusDistributionChart = null;
            let topAgenciesRequestChart = null;
            let topAgenciesActivityRequest = null;

            // Load initial data
            loadAllData();

            // Handle filter form submission
            document.getElementById('filterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                loadAllData();
            });

            function loadAllData() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const agencyId = document.getElementById('agency_id').value;

                loadAgencyPerformance(startDate, endDate, agencyId);
                loadDailyCallVolume();
                loadCallsStatusDistribution(startDate, endDate);
                loadTopAgenciesRequest(startDate, endDate);
                loadTopAgenciesCallView(startDate, endDate);
            }

            function loadAgencyPerformance(startDate, endDate, agencyId) {
                fetch(
                        `/analytics/agency-performance?start_date=${startDate}&end_date=${endDate}${agencyId ? `&agency_id=${agencyId}` : ''}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        updateAgencyPerformanceTable(data.agencies);

                        // Update summary cards
                        let totalRequests = 0;
                        let totalProcessed = 0;
                        let totalCallViews = 0;
                        let totalRequestViews = 0;
                        data.agencies.forEach(agency => {
                            totalRequests += agency.total_requests;
                            totalRequestViews += agency.request_views;
                            totalCallViews += agency.call_views;
                        });

                        document.getElementById('total-requests').textContent = totalRequests;
                        document.getElementById('total-request-views').textContent = totalRequestViews;
                        document.getElementById('total-call-views').textContent = totalCallViews;
                    })
                    .catch(error => console.error('Error loading agency performance:', error));
            }

            function updateAgencyPerformanceTable(agencies) {
                const tbody = document.querySelector('#agencyPerformanceTable tbody');
                tbody.innerHTML = '';

                if (agencies.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="3" class="text-center">No data available</td>';
                    tbody.appendChild(row);
                    return;
                }

                agencies.forEach(agency => {
                    const row = document.createElement('tr');
                    const lastActivity = agency.last_activity ?
                        new Date(agency.last_activity).toLocaleString() :
                        'No activity';

                    row.innerHTML = `
            <td>${agency.agency_name}</td>
            <td>${agency.total_requests}</td>
            <td>${agency.request_views}</td>
             <td>${agency.call_views}</td>
            <td>${lastActivity}</td>
        `;
                    tbody.appendChild(row);
                });
            }

            function loadDailyCallVolume() {
                fetch('/api/analytics/daily-call-volume')
                    .then(response => response.json())
                    .then(data => {
                        const dates = data.daily_calls.map(item => item.date);
                        const callCounts = data.daily_calls.map(item => item.count);
                        const requestCounts = data.daily_requests.map(item => item.count);

                        // Process the processed vs unprocessed calls data
                        const processedCalls = [];
                        const unprocessedCalls = [];

                        dates.forEach(date => {
                            if (data.calls_by_status[date]) {
                                processedCalls.push(data.calls_by_status[date].processed || 0);
                                unprocessedCalls.push(data.calls_by_status[date].unprocessed || 0);
                            } else {
                                processedCalls.push(0);
                                unprocessedCalls.push(0);
                            }
                        });

                        // Update total calls summary card
                        const totalCalls = callCounts.reduce((sum, count) => sum + count, 0);
                        document.getElementById('total-calls').textContent = totalCalls;

                        if (callVolumeChart) {
                            callVolumeChart.destroy();
                        }

                        const ctx = document.getElementById('callVolumeChart').getContext('2d');
                        callVolumeChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: dates,
                                datasets: [{
                                        label: 'Total Calls',
                                        data: callCounts,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        tension: 0.4
                                    },
                                    {
                                        label: 'Requests Created',
                                        data: requestCounts,
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                        tension: 0.4
                                    },
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Count'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error loading call volume data:', error));
            }

            function loadCallsStatusDistribution(startDate, endDate) {
                fetch(`/api/analytics/calls-status-distribution?start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        if (statusDistributionChart) {
                            statusDistributionChart.destroy();
                        }

                        const labels = data.status_distribution.map(item => item.name);
                        const counts = data.status_distribution.map(item => item.count);
                        const backgroundColors = generateColors(labels.length);

                        const ctx = document.getElementById('statusDistributionChart').getContext('2d');
                        statusDistributionChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: counts,
                                    backgroundColor: backgroundColors,
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'right'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.raw || 0;
                                                const percentage = (value / data.total * 100)
                                                    .toFixed(1);
                                                return `${label}: ${value} (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error loading status distribution data:', error));
            }

            function loadTopAgenciesRequest(startDate, endDate) {
                fetch(`/api/analytics/top-agencies?start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        // Top agencies by requests
                        if (topAgenciesRequestChart) {
                            topAgenciesRequestChart.destroy();
                        }

                        const requestLabels = data.top_by_requests.map(item => item.name);
                        const requestCounts = data.top_by_requests.map(item => item.request_count);

                        const ctxRequests = document.getElementById('topAgenciesRequestChart').getContext('2d');
                        topAgenciesRequestChart = new Chart(ctxRequests, {
                            type: 'bar',
                            data: {
                                labels: requestLabels,
                                datasets: [{
                                    label: 'Number of Requests',
                                    data: requestCounts,
                                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Request Count'
                                        }
                                    }
                                },
                                indexAxis: 'y'
                            }
                        });

                        // Top agencies by activity
                        if (topAgenciesActivityRequest) {
                            topAgenciesActivityRequest.destroy();
                        }

                        const viewLabels = data.top_by_request_views.map(item => item.name);
                        const viewCounts = data.top_by_request_views.map(item => item.view_count);

                        const ctxViews = document.getElementById('topAgenciesActivityRequest').getContext('2d');
                        topAgenciesActivityRequest = new Chart(ctxViews, {
                            type: 'bar',
                            data: {
                                labels: viewLabels,
                                datasets: [{
                                    label: 'Number of Views',
                                    data: viewCounts,
                                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                                    borderColor: 'rgba(153, 102, 255, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'View Count'
                                        }
                                    }
                                },
                                indexAxis: 'y'
                            }
                        });
                    })
                    .catch(error => console.error('Error loading top agencies data:', error));
            }

            function loadTopAgenciesCallView(startDate, endDate) {
                fetch(`/api/analytics/top-agencies?start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {

                        // Extract agency names and call view counts
                        const callViewLabels = data.top_by_call_views.map(item => item.name);
                        const callViewCounts = data.top_by_call_views.map(item => item.call_view_count);

                        // Get chart canvas
                        const ctxCallViews = document.getElementById('topAgenciesCallViewChart').getContext(
                            '2d');

                        // Create the new Call View Chart
                        topAgenciesCallViewChart = new Chart(ctxCallViews, {
                            type: 'bar',
                            data: {
                                labels: callViewLabels,
                                datasets: [{
                                    label: 'Number of Call Views',
                                    data: callViewCounts,
                                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Call View Count'
                                        }
                                    }
                                },
                                indexAxis: 'y'
                            }
                        });
                    })
                    .catch(error => console.error('Error loading top agencies call view data:', error));
            }

            // Helper function to generate colors for charts
            function generateColors(count) {
                const colorPalette = [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#5a5c69', '#6f42c1', '#fd7e14', '#20c9a6', '#858796'
                ];

                const colors = [];
                for (let i = 0; i < count; i++) {
                    colors.push(colorPalette[i % colorPalette.length]);
                }

                return colors;
            }
            // Load appropriate scripts based on which dashboard is active
            document.addEventListener('DOMContentLoaded', function() {
                const isMessageAnalytics = {{ request()->is('*/message-analytics') ? 'true' : 'false' }};

                if (isMessageAnalytics) {
                    loadMessageAnalytics();
                } else {
                    loadCallAnalytics();
                }
            });

            function loadMessageAnalytics() {
                // Initialize message analytics code
                // This should be the content of your message-analytics.js file
                let messageVolumeChart = null;
                let statusDistributionChart = null;
                let topAgenciesRequestChart = null;
                let topAgenciesActivityRequest = null;

                // Load data
                loadMessageAllData();

                // Handle filter form submission
                document.getElementById('filterForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    loadMessageAllData();
                });

                // Your existing message analytics functions here...
                // The rest of the message analytics script follows
            }

            function loadCallAnalytics() {
                // Initialize call analytics code
                // This should be the content of your call-analytics.js file
                let callVolumeChart = null;
                let statusDistributionChart = null;
                let topAgenciesRequestChart = null;
                let topAgenciesActivityRequest = null;

                // Load data
                loadAllData();

                // Handle filter form submission
                document.getElementById('filterForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    loadAllData();
                });

                // Your existing call analytics functions here...
                // The rest of the call analytics script follows
            }
        });
    </script>
    <!-- Combined JavaScript for the View Modal and SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle existing messages
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

            // Current request data being viewed
            let currentRequestData = {
                id: null,
                vehicle: null,
                quantity: null
            };

            // Setup view button click handlers
            const viewButtons = document.querySelectorAll('.view-request-btn');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get data attributes
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const vehicle = this.getAttribute('data-vehicle');
                    const location = this.getAttribute('data-location');
                    const quantity = this.getAttribute('data-quantity');
                    const reason = this.getAttribute('data-reason');
                    const priority = this.getAttribute('data-priority');
                    const status = this.getAttribute('data-status');
                    const created = this.getAttribute('data-created');

                    // Store current request data
                    currentRequestData = {
                        id: id,
                        vehicle: vehicle,
                        quantity: quantity
                    };

                    // Set modal content
                    document.getElementById('modal-name').textContent = name;
                    document.getElementById('modal-vehicle').textContent = vehicle;
                    document.getElementById('modal-location').textContent = location;
                    document.getElementById('modal-quantity').textContent = quantity;
                    document.getElementById('modal-reason').textContent = reason;

                    // Set priority with badge
                    let priorityHtml = '';
                    if (priority === 'Low') {
                        priorityHtml = '<span class="badge bg-success">Low</span>';
                    } else if (priority === 'Medium') {
                        priorityHtml = '<span class="badge bg-warning text-dark">Medium</span>';
                    } else {
                        priorityHtml = '<span class="badge bg-danger">High</span>';
                    }
                    document.getElementById('modal-priority').innerHTML = priorityHtml;

                    // Set status with badge
                    let statusHtml = '';
                    if (status === 'Pending') {
                        statusHtml = '<span class="badge bg-warning text-dark">Pending</span>';
                    } else if (status === 'Approved') {
                        statusHtml = '<span class="badge bg-success">Approved</span>';
                    } else if (status === 'Rejected') {
                        statusHtml = '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        statusHtml = '<span class="badge bg-info">Completed</span>';
                    }
                    document.getElementById('modal-status').innerHTML = statusHtml;

                    document.getElementById('modal-created').textContent = created;

                    // Update button visibility based on status
                    updateButtonVisibility(status);
                });
            });

            // Function to update button visibility based on status
            function updateButtonVisibility(status) {
                const approveBtn = document.querySelector('.status-action-modal-btn[data-status="Approved"]');
                const rejectBtn = document.querySelector('.status-action-modal-btn[data-status="Rejected"]');
                const completeBtn = document.querySelector('.status-action-modal-btn[data-status="Completed"]');

                // Show/hide buttons based on current status
                if (status === 'Pending') {
                    approveBtn.style.display = 'inline-block';
                    rejectBtn.style.display = 'inline-block';
                    completeBtn.style.display = 'none';
                } else if (status === 'Approved') {
                    approveBtn.style.display = 'none';
                    rejectBtn.style.display = 'inline-block';
                    completeBtn.style.display = 'inline-block';
                } else if (status === 'Rejected') {
                    approveBtn.style.display = 'inline-block';
                    rejectBtn.style.display = 'none';
                    completeBtn.style.display = 'none';
                } else if (status === 'Completed') {
                    approveBtn.style.display = 'none';
                    rejectBtn.style.display = 'none';
                    completeBtn.style.display = 'none';
                }
            }

            // Setup action buttons in modal with SweetAlert confirmation
            const actionButtons = document.querySelectorAll('.status-action-modal-btn');
            actionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!currentRequestData.id) return;

                    const status = this.getAttribute('data-status');
                    const form = document.getElementById(`status-form-${status}`);

                    // Set the form action dynamically
                    form.action = `/vehicle-requests/${currentRequestData.id}/status`;

                    // Configure SweetAlert based on status
                    let title, confirmText, buttonColor;

                    if (status === 'Approved') {
                        title = 'Approve Request';
                        confirmText = 'Yes, approve it';
                        buttonColor = '#28a745'; // green
                    } else if (status === 'Rejected') {
                        title = 'Reject Request';
                        confirmText = 'Yes, reject it';
                        buttonColor = '#dc3545'; // red
                    } else {
                        title = 'Mark as Completed';
                        confirmText = 'Yes, mark as completed';
                        buttonColor = '#007bff'; // blue
                    }

                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: title,
                        html: `Are you sure you want to <b>${status.toLowerCase()}</b> the request for <b>${currentRequestData.quantity} ${currentRequestData.vehicle}</b>?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: buttonColor,
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Hide modal before submitting
                            const modal = bootstrap.Modal.getInstance(document
                                .getElementById('viewRequestModal'));
                            modal.hide();

                            // Submit the form
                            form.submit();
                        }
                    });
                });
            });

            // Add confirmation for vehicle request form submission (if exists)
            if (document.getElementById("confirmRequest")) {
                document.getElementById("confirmRequest").addEventListener("click", function() {
                    // Get form values for confirmation message
                    const vehicleType = document.getElementById("vehicle_type").value;
                    const quantity = document.getElementById("quantity").value;
                    const priority = document.getElementById("priority").value;

                    Swal.fire({
                        title: 'Confirm Vehicle Request',
                        html: `Are you sure you want to request <b>${quantity} ${vehicleType}</b> with <b>${priority}</b> priority?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, submit request',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form if confirmed
                            document.getElementById("vehicleRequestForm").submit();
                        }
                    });
                });
            }
        });
    </script>
@endsection
