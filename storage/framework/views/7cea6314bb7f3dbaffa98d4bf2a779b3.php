<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $__env->yieldContent(section: 'title'); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">

    <link rel="stylesheet" href="<?php echo e(asset('asset/css/style.css')); ?>">
    <!--bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo e(asset('asset/css/Control.Geocoder.css')); ?>" />
    <link rel="icon" type="image/png" href="<?php echo e(asset('asset/image/logo.png')); ?>">
    <?php echo $__env->yieldContent('styles'); ?>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('welcome')); ?>">Heroes App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('welcome')); ?>">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('safetyguide')); ?>">Safety
                            Guide</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('aboutus')); ?>">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo e(route('contact')); ?>">Contact</a>
                    </li>

                </ul>
                <ul class="navbar-nav flex">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if(Auth::user()->profile && Auth::user()->profile->firstname): ?>
                                    <?php echo e(Auth::user()->profile->firstname); ?>

                                <?php else: ?>
                                    <?php echo e(Auth::user()->name ?? 'User'); ?>

                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php if(Auth::user()->role->name === 'user'): ?>
                                    <?php if(Auth::user()->agency->name === 'DEFAULT'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/')); ?>">User Dashboard</a></li>
                                    <?php endif; ?>
                                <?php elseif(Auth::user()->role->name === 'admin'): ?>
                                    <?php if(Auth::user()->agency->name === 'PNP'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/admin/pnp-dashboard')); ?>">PNP
                                                Dashboard</a></li>
                                    <?php elseif(Auth::user()->agency->name === 'BFP'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/admin/bfp-dashboard')); ?>">BFP
                                                Dashboard</a></li>
                                    <?php elseif(Auth::user()->agency->name === 'MDRRMO'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/admin/mdrrmo-dashboard')); ?>">MDRRMO
                                                Dashboard</a></li>
                                    <?php elseif(Auth::user()->agency->name === 'MHO'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/admin/mho-dashboard')); ?>">MHO
                                                Dashboard</a></li>
                                    <?php elseif(Auth::user()->agency->name === 'COAST GUARD'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/admin/coast-guard-dashboard')); ?>">Coast
                                                Guard Dashboard</a></li>
                                    <?php elseif(Auth::user()->agency->name === 'LGU'): ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/admin/lgu-dashboard')); ?>">LGU
                                                Dashboard</a></li>
                                    <?php else: ?>
                                        <li><a class="dropdown-item" href="<?php echo e(url('/')); ?>">Default Dashboard</a></li>
                                    <?php endif; ?>
                                <?php elseif(Auth::user()->role->name === 'super admin'): ?>
                                    <li><a class="dropdown-item" href="<?php echo e(url('/super-admin/dashboard')); ?>">Super Admin
                                            Dashboard</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo e(url('/')); ?>">Dashboard (Role:
                                            <?php echo e(Auth::user()->role ?? 'None'); ?>)</a></li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('login')); ?>" class="nav-link active">
                                Log in
                            </a>
                        </li>
                        <?php if(Route::has('register')): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('register')); ?>" class="nav-link active">
                                    Register
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>

    <?php echo $__env->yieldContent('content'); ?>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <!-- Logo and About -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Heroes App</h5>
                    <p class="text-light">Emergency response platform connecting citizens with first responders and
                        emergency services.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="text-light me-2"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-light me-2"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="text-light me-2"><i class="fa-brands fa-instagram"></i></a>

                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo e(route('welcome')); ?>"
                                class="text-decoration-none text-text-light">Home</a></li>
                        <li class="mb-2"><a href="<?php echo e(route('safetyguide')); ?>"
                                class="text-decoration-none text-text-light">Safety Guide</a></li>
                        <li class="mb-2"><a href="<?php echo e(route('aboutus')); ?>"
                                class="text-decoration-none text-text-light">About Us</a></li>
                        <li class="mb-2"><a href="<?php echo e(route('contact')); ?>"
                                class="text-decoration-none text-text-light">Contact</a></li>
                    </ul>
                </div>

                <!-- Emergency Services -->
                <div class="col-md-5 mb-4 mb-md-0">
                    <h5 class="mb-3">Emergency Services</h5>
                    <ul class="list-unstyled">
                        <div class="row">
                            <div class="col-md-6">
                                <li class="mb-2"><span class="text-danger">MDRRMO-APARRI EAST (RESCUE
                                        511):</span> <span class="text-light">09972404984</span>
                                </li>
                                <li class="mb-2"><span class="text-danger">MDRRMO-APARRI WEST:</span> <span
                                        class="text-light">09655845600</span>
                                </li>
                                <li class="mb-2"><span class="text-danger">MUNICIPAL HEALTH OFFICE
                                        (EAST):</span> <span class="text-light">09531908364</span></li>
                                <li class="mb-2"><span class="text-danger">MUNICIPAL HEALTH OFFICE
                                        (WEST):</span> <span class="text-light">09951868014</span></li>
                            </div>
                            <div class="col-md-6">

                                <li class="mb-2"><span class="text-danger">APARRI POLICE STATION:</span> <span
                                        class="text-light">09172032003</span></li>
                                <li class="mb-2"><span class="text-danger">APARRI FIRE STATION(BFP):</span>
                                    <span class="text-light">09164910946</span>
                                </li>
                                <li class="mb-2"><span class="text-danger">APARRI PROVINCIAL HOSPITAL:</span>
                                    <span class="text-light">09363748430</span>
                                </li>
                                <li class="mb-2"><span class="text-danger">MAYOR'S OFFICE HOTLINE:</span>
                                    <span class="text-light">09954316944</span>
                                </li>
                            </div>
                        </div>
                    </ul>
                </div>

                <!-- Newsletter -->
                
            </div>

            <hr class="my-4">

            <!-- Copyright -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-light">&copy; <?php echo e(date('Y')); ?> Heroes App. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#"
                                class="text-light text-decoration-none">Privacy Policy</a></li>
                        <li class="list-inline-item">•</li>
                        <li class="list-inline-item"><a href="#" class="text-decoration-none text-light">Terms
                                of Use</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


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
    <?php echo $__env->yieldContent('scripts'); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/layouts/landing.blade.php ENDPATH**/ ?>