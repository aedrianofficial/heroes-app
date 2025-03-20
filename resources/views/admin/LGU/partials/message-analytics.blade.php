@extends('layouts.lgu')
@section('content')
    <!-- Date Range Selector -->
    <div class="card my-4">
        <div class="card-header">Filter Message Analytics</div>
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="dropdown mb-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dashboardTypeDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request()->is('*/message-analytics') ? 'Message Analytics' : 'Call Analytics' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dashboardTypeDropdown">
                        <li><a class="dropdown-item {{ !request()->is('*/message-analytics') ? 'active' : '' }}"
                                href="{{ route('admin.lgu') }}">Call Analytics</a></li>
                        <li><a class="dropdown-item {{ request()->is('*/message-analytics') ? 'active' : '' }}"
                                href="{{ route('admin.lgu') }}/message-analytics">Message Analytics</a></li>
                    </ul>
                </div>

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
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Messages</h5>
                    <h2 class="card-text" id="total-messages">Loading...</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Requests</h5>
                    <h2 class="card-text" id="total-requests">Loading...</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Volume Chart -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Daily Message Volume</div>
                <div class="card-body">
                    <canvas id="messageVolumeChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Message Status Distribution</div>
                <div class="card-body">
                    <canvas id="statusDistributionChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Agencies and Activity Section -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top Agencies by Message Requests</div>
                <div class="card-body">
                    <canvas id="topAgenciesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Top Agencies by Message Activity</div>
                <div class="card-body">
                    <canvas id="topAgenciesActivityChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Agency Performance Table -->
    <div class="card mb-4">
        <div class="card-header">Agency Performance (Messages)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="agencyPerformanceTable">
                    <thead>
                        <tr>
                            <th>Agency</th>
                            <th>Total Requests</th>
                            <th>Request Views</th>
                            <th>Last Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Chart.js library before your script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            let messageVolumeChart = null;
            let statusDistributionChart = null;
            let topAgenciesChart = null;
            let topAgenciesActivityChart = null;

            // Load initial data
            loadMessageAllData();

            // Handle filter form submission
            document.getElementById('filterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                loadMessageAllData();
            });

            function loadMessageAllData() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const agencyId = document.getElementById('agency_id').value;

                loadMessageAgencyPerformance(startDate, endDate, agencyId);
                loadDailyMessageVolume();
                loadMessagesStatusDistribution(startDate, endDate);
                loadTopMessageAgencies(startDate, endDate);
            }

            function loadMessageAgencyPerformance(startDate, endDate, agencyId) {
                fetch(
                        `/api/analytics/message-agency-performance?start_date=${startDate}&end_date=${endDate}${agencyId ? `&agency_id=${agencyId}` : ''}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        updateAgencyMessagePerformanceTable(data.agencies);

                        // Update summary cards
                        let totalRequests = 0;
                        let totalProcessed = 0;

                        data.agencies.forEach(agency => {
                            totalRequests += agency.total_requests;
                            totalProcessed += agency.processed_messages;
                        });

                        document.getElementById('total-requests').textContent = totalRequests;
                    })
                    .catch(error => console.error('Error loading agency performance:', error));
            }

            function updateAgencyMessagePerformanceTable(agencies) {
                const tbody = document.querySelector('#agencyPerformanceTable tbody');
                tbody.innerHTML = '';

                if (agencies.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="4" class="text-center">No data available</td>';
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
                <td>${lastActivity}</td>
            `;
                    tbody.appendChild(row);
                });
            }

            function loadDailyMessageVolume() {
                fetch('/api/analytics/daily-message-volume')
                    .then(response => response.json())
                    .then(data => {
                        const dates = data.daily_messages.map(item => item.date);
                        const messageCounts = data.daily_messages.map(item => item.count);
                        const requestCounts = data.daily_requests.map(item => item.count);

                        // Process the processed vs unprocessed messages data
                        const processedMessages = [];
                        const unprocessedMessages = [];

                        dates.forEach(date => {
                            if (data.messages_by_status[date]) {
                                processedMessages.push(data.messages_by_status[date].processed || 0);
                                unprocessedMessages.push(data.messages_by_status[date].unprocessed ||
                                    0);
                            } else {
                                processedMessages.push(0);
                                unprocessedMessages.push(0);
                            }
                        });

                        // Update total messages summary card
                        const totalMessages = messageCounts.reduce((sum, count) => sum + count, 0);
                        document.getElementById('total-messages').textContent = totalMessages;

                        if (messageVolumeChart) {
                            messageVolumeChart.destroy();
                        }

                        const ctx = document.getElementById('messageVolumeChart').getContext('2d');
                        messageVolumeChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: dates,
                                datasets: [{
                                        label: 'Total Messages',
                                        data: messageCounts,
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
                    .catch(error => console.error('Error loading message volume data:', error));
            }

            function loadMessagesStatusDistribution(startDate, endDate) {
                fetch(`/api/analytics/messages-status-distribution?start_date=${startDate}&end_date=${endDate}`)
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

            function loadTopMessageAgencies(startDate, endDate) {
                fetch(`/api/analytics/message-top-agencies?start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        // Top agencies by requests
                        if (topAgenciesChart) {
                            topAgenciesChart.destroy();
                        }

                        const requestLabels = data.top_by_requests.map(item => item.name);
                        const requestCounts = data.top_by_requests.map(item => item.request_count);

                        const ctxRequests = document.getElementById('topAgenciesChart').getContext('2d');
                        topAgenciesChart = new Chart(ctxRequests, {
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
                        if (topAgenciesActivityChart) {
                            topAgenciesActivityChart.destroy();
                        }

                        const viewLabels = data.top_by_views.map(item => item.name);
                        const viewCounts = data.top_by_views.map(item => item.view_count);

                        const ctxViews = document.getElementById('topAgenciesActivityChart').getContext('2d');
                        topAgenciesActivityChart = new Chart(ctxViews, {
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
        });
    </script>
@endsection
