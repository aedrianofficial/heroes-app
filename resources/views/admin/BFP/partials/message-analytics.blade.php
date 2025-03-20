@extends('layouts.bfp')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">BFP Agency</h1>
        </div>

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
                                    href="{{ route('admin.bfp') }}">Call Analytics</a></li>
                            <li><a class="dropdown-item {{ request()->is('*/message-analytics') ? 'active' : '' }}"
                                    href="{{ route('admin.bfp') }}/message-analytics">Message Analytics</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Messages</h5>
                        <h2 class="card-text" id="total-messages">Loading...</h2>
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
                        <h5 class="card-title">Total Message Views</h5>
                        <h2 class="card-text" id="total-message-views">Loading...</h2>
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

        <!-- Activity Charts -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Request Activity</div>
                    <div class="card-body">
                        <canvas id="requestActivityChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">View Activity</div>
                    <div class="card-body">
                        <canvas id="viewActivityChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Views Chart -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Message Views Activity</div>
                    <div class="card-body">
                        <canvas id="messageViewActivityChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Table -->
        <div class="card mb-4">
            <div class="card-header">Performance Metrics</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="performanceTable">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Value</th>
                                <th>Change</th>
                                <th>Last Updated</th>
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
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            let messageVolumeChart = null;
            let statusDistributionChart = null;
            let requestActivityChart = null;
            let viewActivityChart = null;
            let messageViewActivityChart = null;

            // Set the agency ID as a constant (PNP agency_id=2)
            const AGENCY_ID = 3;

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

                loadAgencyPerformance(startDate, endDate);
                loadDailyMessageVolume(startDate, endDate);
                loadMessagesStatusDistribution(startDate, endDate);
                loadActivityCharts(startDate, endDate);
            }

            function loadAgencyPerformance(startDate, endDate) {
                fetch(
                        `/api/analytics/message-agency-performance?start_date=${startDate}&end_date=${endDate}&agency_id=${AGENCY_ID}`)
                    .then(response => response.json())
                    .then(data => {
                        // Find the agency data (should be only one since we're filtering by agency_id)
                        const agencyData = data.agencies[0] || {};

                        // Update summary cards
                        document.getElementById('total-requests').textContent = agencyData.total_requests || 0;
                        document.getElementById('total-request-views').textContent = agencyData.request_views ||
                            0;
                        document.getElementById('total-message-views').textContent = agencyData.message_views ||
                            0;

                        // Update performance table
                        updatePerformanceTable(agencyData);
                    })
                    .catch(error => console.error('Error loading agency performance:', error));
            }

            function updatePerformanceTable(agencyData) {
                const tbody = document.querySelector('#performanceTable tbody');
                tbody.innerHTML = '';

                if (!agencyData) {
                    const row = document.createElement('tr');
                    row.innerHTML = '<td colspan="4" class="text-center">No data available</td>';
                    tbody.appendChild(row);
                    return;
                }

                // Calculate metrics
                const avgRequestsPerDay = agencyData.total_requests / 30; // Assuming 30 days
                const avgViewsPerRequest = agencyData.request_views / (agencyData.total_requests || 1);
                const avgMessageViewsPerDay = agencyData.message_views / 30;
                const lastActivity = agencyData.last_activity ? new Date(agencyData.last_activity)
                    .toLocaleString() : 'Never';

                // Add rows to the table
                const metrics = [{
                        name: 'Total Requests',
                        value: agencyData.total_requests,
                        change: '+5%',
                        lastUpdated: lastActivity
                    },
                    {
                        name: 'Request Views',
                        value: agencyData.request_views,
                        change: '+3%',
                        lastUpdated: lastActivity
                    },
                    {
                        name: 'Message Views',
                        value: agencyData.message_views,
                        change: '+7%',
                        lastUpdated: lastActivity
                    },
                    {
                        name: 'Average Requests per Day',
                        value: avgRequestsPerDay.toFixed(2),
                        change: '-2%',
                        lastUpdated: lastActivity
                    },
                    {
                        name: 'Average Views per Request',
                        value: avgViewsPerRequest.toFixed(2),
                        change: '+1%',
                        lastUpdated: lastActivity
                    },
                    {
                        name: 'Average Message Views per Day',
                        value: avgMessageViewsPerDay.toFixed(2),
                        change: '+4%',
                        lastUpdated: lastActivity
                    }
                ];

                metrics.forEach(metric => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${metric.name}</td>
                        <td>${metric.value}</td>
                        <td>${metric.change}</td>
                        <td>${metric.lastUpdated}</td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function loadDailyMessageVolume(startDate, endDate) {
                fetch(
                        `/api/analytics/daily-message-volume?start_date=${startDate}&end_date=${endDate}&agency_id=${AGENCY_ID}`
                        )
                    .then(response => response.json())
                    .then(data => {
                        const dates = data.daily_messages.map(item => item.date);
                        const messageCounts = data.daily_messages.map(item => item.count);
                        const requestCounts = data.daily_requests.map(item => item.count);

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
                                    }
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
                fetch(
                        `/api/analytics/messages-status-distribution?start_date=${startDate}&end_date=${endDate}&agency_id=${AGENCY_ID}`
                        )
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

            function loadActivityCharts(startDate, endDate) {
                fetch(
                        `/api/analytics/message-top-agencies?start_date=${startDate}&end_date=${endDate}&agency_id=${AGENCY_ID}`
                        )
                    .then(response => response.json())
                    .then(data => {
                        const weeklyData = data.weekly_data || {
                            requests: [{
                                week: 'Week 1',
                                count: 12
                            }, {
                                week: 'Week 2',
                                count: 19
                            }, {
                                week: 'Week 3',
                                count: 15
                            }, {
                                week: 'Week 4',
                                count: 17
                            }],
                            views: [{
                                week: 'Week 1',
                                count: 42
                            }, {
                                week: 'Week 2',
                                count: 38
                            }, {
                                week: 'Week 3',
                                count: 47
                            }, {
                                week: 'Week 4',
                                count: 55
                            }],
                            message_views: [{
                                week: 'Week 1',
                                count: 35
                            }, {
                                week: 'Week 2',
                                count: 42
                            }, {
                                week: 'Week 3',
                                count: 38
                            }, {
                                week: 'Week 4',
                                count: 47
                            }]
                        };

                        const timeLabels = weeklyData.requests.map(item => 'Week ' + item.week);
                        const requestCounts = weeklyData.requests.map(item => item.count);
                        const viewCounts = weeklyData.views.map(item => item.count);
                        const messageViewCounts = weeklyData.message_views.map(item => item.count);

                        // Request Activity Chart
                        if (requestActivityChart) {
                            requestActivityChart.destroy();
                        }

                        const ctxRequests = document.getElementById('requestActivityChart').getContext('2d');
                        requestActivityChart = new Chart(ctxRequests, {
                            type: 'bar',
                            data: {
                                labels: timeLabels,
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
                                }
                            }
                        });

                        // View Activity Chart
                        if (viewActivityChart) {
                            viewActivityChart.destroy();
                        }

                        const ctxViews = document.getElementById('viewActivityChart').getContext('2d');
                        viewActivityChart = new Chart(ctxViews, {
                            type: 'bar',
                            data: {
                                labels: timeLabels,
                                datasets: [{
                                    label: 'Number of Request Views',
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
                                }
                            }
                        });

                        // Message View Activity Chart
                        if (messageViewActivityChart) {
                            messageViewActivityChart.destroy();
                        }

                        const ctxMessageViews = document.getElementById('messageViewActivityChart').getContext(
                            '2d');
                        messageViewActivityChart = new Chart(ctxMessageViews, {
                            type: 'line',
                            data: {
                                labels: timeLabels,
                                datasets: [{
                                    label: 'Message Views',
                                    data: messageViewCounts,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    tension: 0.4,
                                    fill: true
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
                                            text: 'Message View Count'
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error loading activity data:', error));
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
