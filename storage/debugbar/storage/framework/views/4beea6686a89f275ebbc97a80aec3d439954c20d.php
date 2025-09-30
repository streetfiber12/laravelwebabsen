<?php $__env->startPush('style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/auth/login.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="w-100">

    <main class="form-signin w-100 m-auto">
        <form method="POST" action="<?php echo e(route('auth.login')); ?>" id="login-form">
            <h1 class="h3 mb-3 fw-normal">Silahkan masuk untuk absensi</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="floatingInputEmail" name="email"
                    placeholder="name@example.com">
                <label for="floatingInputEmail">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name="password"
                    placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="flexCheckRemember">
                <label class="form-check-label" for="flexCheckRemember">
                    Ingatkan Saya di Perangkat ini
                </label>
            </div>

            <button class="w-100 btn btn-primary" type="submit" id="login-form-button">Masuk</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </main>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script type="module" src="<?php echo e(asset('js/auth/login.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/auth/login.blade.php ENDPATH**/ ?>