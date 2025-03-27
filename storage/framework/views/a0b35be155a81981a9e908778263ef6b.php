<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent(section: 'title'); ?></title>
    <meta name="description" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">

    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/Control.Geocoder.css')); ?>" />

    <?php echo $__env->yieldContent(section: 'styles'); ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="#">Heroes App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('admin.pnp')); ?>">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Reports
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('pnp.reports.create')); ?>">Create a Report</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?php echo e(route('pnp.reports.index')); ?>">All Reports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                            href="<?php echo e(route('pnp.emergencymessage.index')); ?>">Emergency
                            Messages</a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Emergency Calls
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo e(route('pnp.emergencycall.index')); ?>">Call logs</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?php echo e(route('pnp.cases.index')); ?>">Cases</a></li>
                        </ul>
                    </li>
                    <!--<li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('pnp.reports.index')); ?>">Activity
                            Logs</a>
                    </li>-->
                </ul>

                <ul class="navbar-nav d-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, <?php echo e(auth()->user()->profile->firstname); ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">My Account</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="container">
        <?php echo $__env->yieldContent(section: 'content'); ?>
    </div>


    <!--scripts-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!--leaflet-->
    <script src="<?php echo e(asset('asset/js/leaflet.js')); ?>" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="<?php echo e(asset('asset/js/Control.Geocoder.js')); ?>"></script>

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--sweetalert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!--pusher-->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!--call-->
    <script>
        // Check if we already have an active SSE connection
        if (typeof window.callEventSource === 'undefined') {

            // Function to mark a call as seen by this user
            function markCallAsSeen(callId) {
                fetch('/mark-call-as-seen', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        call_id: callId
                    })
                });
            }

            function connectCallSSE() {
                // Store the EventSource in a global variable so it persists
                window.callEventSource = new EventSource("/sse/calls");

                window.callEventSource.addEventListener("call-submit", (event) => {
                    const data = JSON.parse(event.data);

                    // Mark this call as seen by this user to prevent future notifications
                    markCallAsSeen(data.id);

                    // Show SweetAlert notification
                    Swal.fire({
                        title: "📞 Incoming Call Alert",
                        html: `<b>Caller:</b> ${data.caller_name} (${data.caller_contact}) <br>
                                <b>Time:</b> ${new Date(data.created_at).toLocaleString('en-US', { 
        month: 'long', day: 'numeric', year: 'numeric', 
        hour: 'numeric', minute: 'numeric', hour12: true 
    })} <br>
                               <b>Address:</b> ${data.address}`,
                        icon: "info",
                        showCancelButton: true,
                        cancelButtonText: "Close",
                        confirmButtonText: "📄 View for more details",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/admin/pnp/emergency-call/${data.id}/view`;
                        }
                    });
                });

                window.callEventSource.onerror = () => {
                    console.error("SSE connection lost. Retrying in 5 seconds...");
                    window.callEventSource.close();

                    // Reconnect after 5 seconds
                    setTimeout(connectCallSSE, 5000);
                };
            }

            // Initialize connection when the page loads for the first time
            connectCallSSE();

            // Handle page navigation in SPA or Turbolinks if you're using it
            document.addEventListener('turbolinks:load', function() {
                // If connection was closed during navigation, reconnect
                if (window.callEventSource.readyState === 2) {
                    connectCallSSE();
                }
            });
        }
    </script>

    <script>
        // Check if we already have an active Message SSE connection
        if (typeof window.messageEventSource === 'undefined') {
            // Function to mark a message as seen by this user
            function markMessageAsSeen(messageId) {
                fetch('/mark-message-as-seen', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message_id: messageId
                    })
                });
            }

            function connectMessageSSE() {
                // Store the EventSource in a global variable so it persists
                window.messageEventSource = new EventSource("/sse/messages");

                window.messageEventSource.addEventListener("message-submit", (event) => {
                    const data = JSON.parse(event.data);

                    // Mark this message as seen by this user to prevent future notifications
                    markMessageAsSeen(data.id);

                    // Show SweetAlert notification
                    Swal.fire({
                        title: "📩 New Message Alert",
                        html: `<b>From:</b> ${data.sender_name} (${data.sender_contact}) <br> 
                           <b>Message:</b> ${data.message_content} <br>
                           <b>Address:</b> ${data.address} <br>
                            <b>Time:</b> ${new Date(data.created_at).toLocaleString('en-US', { 
        month: 'long', day: 'numeric', year: 'numeric', 
        hour: 'numeric', minute: 'numeric', hour12: true 
    })}`,
                        icon: "info",
                        showCancelButton: true,
                        cancelButtonText: "Close",
                        confirmButtonText: "📄 View for more details",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/admin/pnp/emergency-message/${data.id}/view`;
                        }
                    });
                });

                window.messageEventSource.onerror = () => {
                    console.error("Message SSE connection lost. Retrying in 5 seconds...");
                    window.messageEventSource.close();

                    // Reconnect after 5 seconds
                    setTimeout(connectMessageSSE, 5000);
                };
            }

            // Initialize connection when the page loads for the first time
            connectMessageSSE();

            // Handle page navigation in SPA or Turbolinks if you're using it
            document.addEventListener('turbolinks:load', function() {
                // If connection was closed during navigation, reconnect
                if (window.messageEventSource.readyState === 2) {
                    connectMessageSSE();
                }
            });
        }
    </script>
    <!--request call-->
    <script>
        if (typeof window.requestEventSource === 'undefined') {

            function markRequestAsSeen(requestId, requestCallId) {
                fetch('/mark-request-call-as-seen', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        request_call_id: requestCallId
                    })
                });
            }

            function connectRequestSSE() {
                window.requestEventSource = new EventSource("/sse/request-call");

                window.requestEventSource.addEventListener("request-submit", (event) => {
                    const data = JSON.parse(event.data);

                    markRequestAsSeen(data.id, data.request_call_id);

                    Swal.fire({
                        title: "🚨 New Emergency Call Request",
                        html: `<b>Name:</b> ${data.name} <br>
                           <b>Address:</b> ${data.address} <br>
                           <b>Description:</b> ${data.description} <br>
                            <b>Time:</b> ${new Date(data.created_at).toLocaleString('en-US', { 
        month: 'long', day: 'numeric', year: 'numeric', 
        hour: 'numeric', minute: 'numeric', hour12: true 
    })}`,
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Close",
                        confirmButtonText: "📄 View Details",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/admin/pnp/emergency-call/${data.id}/view`;
                        }
                    });
                });

                window.requestEventSource.onerror = () => {
                    console.error("SSE connection lost. Retrying in 5 seconds...");
                    window.requestEventSource.close();

                    setTimeout(connectRequestSSE, 5000);
                };
            }

            connectRequestSSE();

            document.addEventListener('turbolinks:load', function() {
                if (window.requestEventSource.readyState === 2) {
                    connectRequestSSE();
                }
            });
        }
    </script>
    <!--request message-->
    <script>
        if (typeof window.messageEventSource === 'undefined') {
            function markMessageAsSeen(messageId, requestMessageId) {
                fetch('/mark-request-message-as-seen', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        request_message_id: requestMessageId
                    })
                });
            }

            function connectMessageSSE() {
                window.messageEventSource = new EventSource("/sse/request-message");

                window.messageEventSource.addEventListener("message-submit", (event) => {
                    const data = JSON.parse(event.data);

                    markMessageAsSeen(data.id, data.request_message_id);

                    Swal.fire({
                        title: "📩 New Message Emergency Request",
                        html: `<b>Name:</b> ${data.name} <br>
                       <b>Address:</b> ${data.address} <br>
                       <b>Description:</b> ${data.description} <br>
                        <b>Time:</b> ${new Date(data.created_at).toLocaleString('en-US', { 
        month: 'long', day: 'numeric', year: 'numeric', 
        hour: 'numeric', minute: 'numeric', hour12: true 
    })}`,
                        icon: "info",
                        showCancelButton: true,
                        cancelButtonText: "Close",
                        confirmButtonText: "📄 View Details",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/admin/pnp/emergency-message/${data.id}/view`;
                        }
                    });
                });

                window.messageEventSource.onerror = () => {
                    console.error("Message SSE connection lost. Retrying in 5 seconds...");
                    window.messageEventSource.close();

                    setTimeout(connectMessageSSE, 5000);
                };
            }

            connectMessageSSE();

            document.addEventListener('turbolinks:load', function() {
                if (window.messageEventSource.readyState === 2) {
                    connectMessageSSE();
                }
            });
        }
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/layouts/pnp.blade.php ENDPATH**/ ?>