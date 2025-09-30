<?php $__env->startSection('buttons'); ?>
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="<?php echo e(route('presences.show', $attendance->id)); ?>" class="btn btn-sm btn-light">
            <span data-feather="arrow-left-circle" class="align-text-bottom"></span>
            Kembali
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <h5 class="card-title"><?php echo e($attendance->title); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo e($attendance->description); ?></h6>
                <div class="d-flex align-items-center gap-2">
                    <span href="" class="badge text-bg-warning">Tidak Hadir</span>
                </div>
            </div>
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="mb-3">
                        <label for="filterDate" class="form-label fw-bold">Tampilkan Berdasarkan Tanggal</label>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" id="filterDate" name="display-by-date"
                                value="<?php echo e(request('display-by-date')); ?>">
                            <button class="btn btn-primary" type="submit" id="button-addon1">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(count($notPresentData) === 0): ?>
<small class="text-danger fw-bold">Tidak ada data yang bisa ditampilkan, <a href="">Tampilkan data berdasarkan hari
        ini.</a></small>
<?php endif; ?>


<div>
    <?php $__currentLoopData = $notPresentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="p-3 rounded bg-light border my-3 d-flex align-items-center justify-content-between">
        <div>Hari : <span class="fw-bold">
                <?php echo e(\Carbon\Carbon::parse($data['not_presence_date'])->dayName); ?>

                <?php echo e(\Carbon\Carbon::parse($data['not_presence_date'])->isCurrentDay() ? '(Hari ini)' : ''); ?>

            </span>
        </div>
        <div>Tanggal : <span class="fw-bold"><?php echo e($data['not_presence_date']); ?></span></div>
        <div>Jumlah : <span class="fw-bold"><?php echo e(count($data['users'])); ?></span></div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Pegawai</th>
                    <th scope="col">Kontak</th>
                    <th scope="col">Posisi</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['users']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                    <td><?php echo e($user['name']); ?></td>
                    <td>
                        <a href="mailto:<?php echo e($user['email']); ?>"><?php echo e($user['email']); ?></a>
                        <span class="fw-bold"> / </span>
                        <a href="tel:<?php echo e($user['phone']); ?>"><?php echo e($user['phone']); ?></a>
                    </td>
                    <td><?php echo e($user['position']['name']); ?></td>
                    <td>
                        <form action="<?php echo e(route('presences.present', $attendance->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="user_id" value="<?php echo e($user['id']); ?>">
                            <input type="hidden" name="presence_date" value="<?php echo e($data['not_presence_date']); ?>">
                            <button class="badge text-bg-primary border-0" type="submit">Hadir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/presences/not-present.blade.php ENDPATH**/ ?>