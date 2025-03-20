<?php $__env->startSection('content'); ?>
    <div class="container-fluid">

        <!-- Date Range Selector -->
        <div class="card my-4">
            <div class="card-header">Filter Analytics</div>
            <div class="card-body">
                <div class="dropdown mb-3">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dashboardTypeDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo e(request()->is('*/message-analytics') ? 'Message Analytics' : 'Call Analytics'); ?>

                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dashboardTypeDropdown">
                        <li><a class="dropdown-item <?php echo e(!request()->is('*/message-analytics') ? 'active' : ''); ?>"
                                href="<?php echo e(route('superadmin.dashboard')); ?>">Call Analytics</a></li>
                        <li><a class="dropdown-item <?php echo e(request()->is('*/message-analytics') ? 'active' : ''); ?>"
                                href="<?php echo e(route('superadmin.dashboard')); ?>/message-analytics">Message Analytics</a></li>
                    </ul>
                </div>

                <form id="filterForm" class="row g-3">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="<?php echo e(\Carbon\Carbon::now()->subMonth()->format('Y-m-d')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="agency_id" class="form-label">Agency</label>
                        <select class="form-select" id="agency_id" name="agency_id">
                            <option value="">All Agencies</option>
                            <?php $__currentLoopData = $agencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($agency->id); ?>"><?php echo e($agency->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

        <!-- Call Volume Chart -->
        <div class="row mb-4">
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
        <div class="row mb-4">

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                const isMessageAnalytics = <?php echo e(request()->is('*/message-analytics') ? 'true' : 'false'); ?>;

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
    <script></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/super-admin/dashboard.blade.php ENDPATH**/ ?>