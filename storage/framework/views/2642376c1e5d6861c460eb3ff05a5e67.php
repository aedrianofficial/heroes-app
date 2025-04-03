<?php $__env->startSection('title', 'About Us - Heroes App'); ?>

<?php $__env->startSection('styles'); ?>
    <style>
        .about-hero {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .agency-card {
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .agency-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .agency-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #dc3545;
        }

        .team-member-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #f8f9fa;
        }

        .mission-vision-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .about-section {
            padding: 80px 0;
        }

        .section-title {
            position: relative;
            margin-bottom: 45px;
        }

        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -15px;
            width: 60px;
            height: 3px;
            background-color: #dc3545;
        }

        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: #dc3545;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
        }

        .timeline-container {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .timeline-container::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -12px;
            background-color: white;
            border: 4px solid #dc3545;
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        .left {
            left: 0;
        }

        .right {
            left: 50%;
        }

        .left::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            right: 30px;
            border: medium solid #f8f9fa;
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent #f8f9fa;
        }

        .right::before {
            content: " ";
            height: 0;
            position: absolute;
            top: 22px;
            width: 0;
            z-index: 1;
            left: 30px;
            border: medium solid #f8f9fa;
            border-width: 10px 10px 10px 0;
            border-color: transparent #f8f9fa transparent transparent;
        }

        .right::after {
            left: -13px;
        }

        .timeline-content {
            padding: 20px 30px;
            background-color: #f8f9fa;
            position: relative;
            border-radius: 6px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        @media screen and (max-width: 600px) {
            .timeline::after {
                left: 31px;
            }

            .timeline-container {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            .timeline-container::before {
                left: 60px;
                border: medium solid #f8f9fa;
                border-width: 10px 10px 10px 0;
                border-color: transparent #f8f9fa transparent transparent;
            }

            .left::after,
            .right::after {
                left: 18px;
            }

            .right {
                left: 0%;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card bg-danger text-white about-hero mb-5 hero-image" style="height: 400px;">
                    <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                        <h1 class="card-title fw-bold">About Heroes App</h1>
                        <p class="card-text fs-5">Connecting citizens with emergency services to save lives</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Story Section -->
        <section class="about-section bg-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="section-title">Our Story</h2>
                        <p>Heroes App was born from a vision to revolutionize emergency response in Aparri. We recognized
                            the
                            critical need for a platform that could connect citizens directly with emergency services during
                            crucial moments when every second counts.</p>
                        <p>Developed in collaboration with local government units and emergency agencies, our platform
                            serves as
                            a vital link between those in need and those trained to help. We're committed to leveraging
                            technology to create safer communities and save lives.</p>
                        <p>Since our inception, we've continuously evolved our services based on feedback from users and
                            emergency professionals to ensure we provide the most effective emergency response solution
                            possible.</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="<?php echo e(asset('asset/image/logo.png')); ?>" alt="Heroes App Team" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision Section -->
        <section class="about-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="mission-vision-card bg-danger text-white h-100 p-4">
                            <div class="card-body">
                                <h3 class="card-title mb-4"><i class="fas fa-bullseye me-2"></i> Our Mission</h3>
                                <p class="card-text">To provide immediate and efficient emergency response by connecting
                                    citizens with the right emergency services through innovative technology, ultimately
                                    saving
                                    lives and creating safer communities.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="mission-vision-card bg-dark text-white h-100 p-4">
                            <div class="card-body">
                                <h3 class="card-title mb-4"><i class="fas fa-eye me-2"></i> Our Vision</h3>
                                <p class="card-text">To be the leading emergency response platform that transforms how
                                    communities handle emergencies, empowering citizens and first responders with the tools
                                    they
                                    need to act quickly and effectively during critical situations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partner Agencies Section -->
        <section class="about-section bg-light">
            <div class="container">
                <h2 class="section-title text-center mb-5">Our Partner Agencies</h2>
                <div class="row g-4">
                    <div class="col-md-4 col-sm-6">
                        <div class="card agency-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="agency-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h4>PNP</h4>
                                <p>The Philippine National Police responds to criminal incidents and maintains public safety
                                    and
                                    order during emergencies.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card agency-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="agency-icon">
                                    <i class="fas fa-fire-extinguisher"></i>
                                </div>
                                <h4>BFP</h4>
                                <p>The Bureau of Fire Protection handles fire emergencies, rescue operations, and fire
                                    prevention education across the community.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card agency-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="agency-icon">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <h4>MHO</h4>
                                <p>The Municipal Health Office provides medical emergency services and coordinates
                                    healthcare
                                    responses during disasters.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card agency-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="agency-icon">
                                    <i class="fas fa-life-ring"></i>
                                </div>
                                <h4>MDRRMO</h4>
                                <p>The Municipal Disaster Risk Reduction and Management Office coordinates disaster
                                    preparedness
                                    and emergency response efforts.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card agency-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="agency-icon">
                                    <i class="fas fa-ship"></i>
                                </div>
                                <h4>Coast Guard</h4>
                                <p>The Coast Guard handles maritime emergencies, water search and rescue, and coastal
                                    security
                                    operations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="card agency-card h-100">
                            <div class="card-body text-center p-4">
                                <div class="agency-icon">
                                    <i class="fas fa-city"></i>
                                </div>
                                <h4>LGU</h4>
                                <p>The Local Government Unit oversees and coordinates all emergency response activities
                                    within
                                    the municipality.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Our Journey Timeline -->
        <section class="about-section">
            <div class="container">
                <h2 class="section-title text-center mb-5">Our Journey</h2>
                <div class="timeline">
                    <div class="timeline-container left">
                        <div class="timeline-content">
                            <h3>Conceptualization</h3>
                            <p>The initial idea for Heroes App was developed, focusing on creating a unified emergency
                                response
                                system.</p>
                        </div>
                    </div>
                    <div class="timeline-container right">
                        <div class="timeline-content">
                            <h3>Agency Partnerships</h3>
                            <p>Strategic partnerships were formed with PNP, BFP, MDRRMO, MHO, Coast Guard, and local LGUs.
                            </p>
                        </div>
                    </div>
                    <div class="timeline-container left">
                        <div class="timeline-content">
                            <h3>Platform Development</h3>
                            <p>Our team developed the core technology platform, integrating mapping capabilities and
                                emergency
                                communication systems.</p>
                        </div>
                    </div>
                    <div class="timeline-container right">
                        <div class="timeline-content">
                            <h3>Pilot Launch</h3>
                            <p>Heroes App was successfully piloted in selected communities with positive feedback.</p>
                        </div>
                    </div>
                    <div class="timeline-container left">
                        <div class="timeline-content">
                            <h3>Full Deployment</h3>
                            <p>Following the successful pilot, Heroes App was fully deployed across Aparri to serve the
                                entire
                                community.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Values Section -->
        <section class="about-section bg-light">
            <div class="container">
                <h2 class="section-title text-center mb-5">Our Core Values</h2>
                <div class="row g-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <div class="display-4 mb-3 text-danger">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <h4>Rapid Response</h4>
                                <p>We prioritize speed and efficiency in every emergency situation.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <div class="display-4 mb-3 text-danger">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <h4>Compassion</h4>
                                <p>We approach every situation with empathy and understanding.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <div class="display-4 mb-3 text-danger">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h4>Reliability</h4>
                                <p>We commit to being there when people need us most.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card text-center h-100">
                            <div class="card-body">
                                <div class="display-4 mb-3 text-danger">
                                    <i class="fas fa-sync"></i>
                                </div>
                                <h4>Innovation</h4>
                                <p>We continuously improve our systems and processes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="about-section bg-danger text-white text-center">
            <div class="container">
                <h2 class="mb-4">Ready to Join Our Mission?</h2>
                <p class="lead mb-4">Be prepared for any emergency situation.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-light btn-lg px-4">Register Now</a>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/website/about_us.blade.php ENDPATH**/ ?>