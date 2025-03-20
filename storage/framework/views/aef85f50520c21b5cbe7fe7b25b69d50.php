<?php $__env->startSection('styles'); ?>
<style>
    .content {
        font-size: 3.5rem; /* Increase font size for better readability */
        font-family: 'Poppins', sans-serif; /* Modern and readable font */
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
    }

    .overlay {
        background: rgba(0, 0, 0, 0.5);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="position-relative text-white">
    <!-- Background Image -->
    <div class="bg-image">
        <!-- Overlay -->
        <div class="overlay d-flex align-items-center h-100">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Left Column -->
                    <div class="col-md-6 text-center text-md-start">
                        <h1 class="fw-bold content">HEROES APP</h1>
                        <p class="lead subtext">Harnessing Effective and Responsive Operation Enhanced by SMS Technology</p>
                    </div>

                    <!-- Right Column (Logo) -->
                    <div class="col-md-6 text-center">
                        <img src="<?php echo e(asset('asset/image/logo.png')); ?>" alt="Heroes App Logo" class="img-fluid" style="max-width: 300px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/website/welcome.blade.php ENDPATH**/ ?>