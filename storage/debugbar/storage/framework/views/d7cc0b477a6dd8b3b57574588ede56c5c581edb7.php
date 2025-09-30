<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <?php if(auth()->user()->isAdmin() or auth()->user()->isOperator()): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('dashboard.*') ? 'active' : ''); ?>" aria-current="page"
                    href="<?php echo e(route('dashboard.index')); ?>">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('positions.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('positions.index')); ?>">
                    <span data-feather="tag" class="align-text-bottom"></span>
                    Jabatan / Posisi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('employees.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('employees.index')); ?>">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Pegawai
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('holidays.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('holidays.index')); ?>">
                    <span data-feather="calendar" class="align-text-bottom"></span>
                    Hari Libur
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('attendances.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('attendances.index')); ?>">
                    <span data-feather="clipboard" class="align-text-bottom"></span>
                    Absensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(request()->routeIs('presences.*') ? 'active' : ''); ?>"
                    href="<?php echo e(route('presences.index')); ?>">
                    <span data-feather="clipboard" class="align-text-bottom"></span>
                    Data Kehadiran
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <form action="<?php echo e(route('auth.logout')); ?>" method="post"
            onsubmit="return confirm('Apakah anda yakin ingin keluar?')">
            <?php echo method_field('DELETE'); ?>
            <?php echo csrf_field(); ?>
            <button class="w-full mt-4 d-block bg-transparent border-0 fw-bold text-danger px-3">Keluar</button>
        </form>
    </div>
</nav><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>