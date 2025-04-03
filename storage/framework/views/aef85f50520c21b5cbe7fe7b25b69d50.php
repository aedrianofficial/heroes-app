<?php $__env->startSection('title', 'Heroes App - Emergency Response Platform'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        /* Hero Section Styles */
        .content {
            font-size: 3.5rem;
            /* Increase font size for better readability */
            font-family: 'Poppins', sans-serif;
            /* Modern and readable font */
        }

        .subtext {
            font-size: 1.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .bg-image {
            background-image: url('<?php echo e(asset('asset/image/aparri1.jpg')); ?>');
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.5);
            height: 100%;
            width: 100%;
        }

        /* Services Section Styles */
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        /* Emergency Guide Styles */
        .emergency-step {
            padding: 2rem;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .emergency-step:hover {
            transform: scale(1.03);
        }

        .step-number {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 1rem;
        }

        /* Testimonial Styles */
        .testimonial-card {
            background-color: #f8f9fa;
            border-radius: 1rem;
            overflow: hidden;
        }

        .testimonial-text {
            font-style: italic;
        }

        .quote-icon {
            font-size: 2rem;
            opacity: 0.3;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="position-relative text-white">
        <!-- Background Image -->
        <div class="bg-image">
            <!-- Overlay -->
            <div class="overlay d-flex align-items-center">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- Left Column -->
                        <div class="col-md-6 text-center text-md-start">
                            <h1 class="fw-bold content">HEROES APP</h1>
                            <p class="lead subtext">Harnessing Effective and Responsive Operation Enhanced by SMS Technology
                            </p>
                            <div class="mt-4">
                                <a href="<?php echo e(route('register')); ?>" class="btn btn-danger btn-lg me-3">Get Started</a>
                                <a href="<?php echo e(route('safetyguide')); ?>" class="btn btn-outline-light btn-lg">Safety Guide</a>
                            </div>
                        </div>

                        <!-- Right Column (Logo) -->
                        <div class="col-md-6 text-center">
                            <img src="<?php echo e(asset('asset/image/logo.png')); ?>" alt="Heroes App Logo" class="img-fluid"
                                style="max-width: 300px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Services Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">Our Emergency Services</h2>
                    <p class="lead text-muted">Connecting you with lifesaving services when seconds matter</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Police Service -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-primary text-white">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h4 class="mt-4">Police Response</h4>
                            <p class="text-muted">Immediate police response to security threats, crimes in progress, and
                                emergency situations.</p>
                            <div class="mt-3">
                                <span class="badge bg-primary">PNP</span>
                                <span class="badge bg-secondary ms-2">Security</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fire Service -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-danger text-white">
                                <i class="fa-solid fa-fire-extinguisher"></i>
                            </div>
                            <h4 class="mt-4">Fire Emergency</h4>
                            <p class="text-muted">Rapid fire response, rescue operations, and fire prevention guidance from
                                trained personnel.</p>
                            <div class="mt-3">
                                <span class="badge bg-danger">BFP</span>
                                <span class="badge bg-secondary ms-2">Fire Rescue</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Service -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-success text-white">
                                <i class="fa-solid fa-kit-medical"></i>
                            </div>
                            <h4 class="mt-4">Medical Emergency</h4>
                            <p class="text-muted">Quick medical assistance for health emergencies with ambulance service and
                                medical professionals.</p>
                            <div class="mt-3">
                                <span class="badge bg-success">MHO</span>
                                <span class="badge bg-secondary ms-2">Health</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disaster Response -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-warning text-white">
                                <i class="fa-solid fa-house-tsunami"></i>
                            </div>
                            <h4 class="mt-4">Disaster Response</h4>
                            <p class="text-muted">Coordination during natural disasters, evacuations, and post-disaster
                                recovery operations.</p>
                            <div class="mt-3">
                                <span class="badge bg-warning text-dark">MDRRMO</span>
                                <span class="badge bg-secondary ms-2">Disaster</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coast Guard -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-info text-white">
                                <i class="fa-solid fa-ship"></i>
                            </div>
                            <h4 class="mt-4">Maritime Response</h4>
                            <p class="text-muted">Search and rescue operations at sea, maritime safety, and coastal
                                emergency response.</p>
                            <div class="mt-3">
                                <span class="badge bg-info">Coast Guard</span>
                                <span class="badge bg-secondary ms-2">Maritime</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LGU Support -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm service-card">
                        <div class="card-body text-center p-4">
                            <div class="service-icon bg-secondary text-white">
                                <i class="fa-solid fa-city"></i>
                            </div>
                            <h4 class="mt-4">LGU Services</h4>
                            <p class="text-muted">Local government coordination for various emergencies and community safety
                                concerns.</p>
                            <div class="mt-3">
                                <span class="badge bg-secondary">LGU</span>
                                <span class="badge bg-secondary ms-2">Public Service</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold">How Heroes App Works</h2>
                    <p class="lead text-muted">Quick emergency assistance in three simple steps</p>
                </div>
            </div>

            <div class="row">
                <!-- Step 1 -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="emergency-step bg-light text-center h-100 p-4">
                        <div class="step-number text-danger">01</div>
                        <h4>Register & Set Up</h4>
                        <p class="text-muted">Create an account.</p>
                        <i class="fas fa-user-plus text-danger mt-3" style="font-size: 60px;"></i>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="emergency-step bg-light text-center h-100 p-4">
                        <div class="step-number text-danger">02</div>
                        <h4>Report Emergency</h4>
                        <p class="text-muted">Send an SMS or Call to quickly report emergencies with your location.
                        </p>
                        <i class="fas fa-exclamation-triangle text-danger mt-3" style="font-size: 60px;"></i>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-4">
                    <div class="emergency-step bg-light text-center h-100 p-4">
                        <div class="step-number text-danger">03</div>
                        <h4>Get Help</h4>
                        <p class="text-muted">The nearest appropriate emergency service will be dispatched to your
                            location.</p>
                        <i class="fas fa-ambulance text-danger mt-3" style="font-size: 60px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-danger text-white">
        <div class="container">
            <div class="row text-center">
                

                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <div class="display-4 fw-bold mb-2">100+</div>
                    <p class="h5">Emergencies Handled</p>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="display-4 fw-bold mb-2">95%</div>
                    <p class="h5">Response Rate</p>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="display-4 fw-bold mb-2">12</div>
                    <p class="h5">Min Avg Response Time</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Ready to be prepared for emergencies?</h2>
                    <p class="lead text-muted mb-4">Join Heroes App today and connect with Aparri's emergency services.</p>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-danger btn-lg px-5">Sign Up Now</a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        // Add any custom JavaScript here
        $(document).ready(function() {
            // Example: Smooth scrolling for anchor links
            $('a.smooth-scroll').click(function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {
                        window.location.hash = hash;
                    });
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/website/welcome.blade.php ENDPATH**/ ?>