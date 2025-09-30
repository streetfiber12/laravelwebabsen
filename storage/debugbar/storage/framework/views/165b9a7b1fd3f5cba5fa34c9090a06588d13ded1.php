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
                    <span href="" class="badge text-bg-warning">Izin</span>
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

<div>
    <div class="p-3 rounded bg-light border my-3 d-flex align-items-center justify-content-between">
        <div>Hari : <span class="fw-bold">
                <?php echo e(\Carbon\Carbon::parse($date)->dayName); ?>

                <?php echo e(\Carbon\Carbon::parse($date)->isCurrentDay() ? '(Hari ini)' : ''); ?>

            </span>
        </div>
        <div>Tanggal : <span class="fw-bold"><?php echo e($date); ?></span></div>
        <div>Jumlah : <span class="fw-bold"><?php echo e($permissions->count()); ?></span></div>
    </div>
    <?php if(count($permissions) === 0): ?>
    <small class="text-danger fw-bold">Tidak ada data yang bisa ditampilkan, <a href="">Tampilkan data berdasarkan hari
            ini.</a></small>
    <?php else: ?>
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
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                    <td><?php echo e($permission->user->name); ?></td>
                    <td>
                        <a href="mailto:<?php echo e($permission->user->email); ?>"><?php echo e($permission->user->email); ?></a>
                        <span class="fw-bold"> / </span>
                        <a href="tel:<?php echo e($permission->user->phone); ?>"><?php echo e($permission->user->phone); ?></a>
                    </td>
                    <td><?php echo e($permission->user->position->name); ?></td>
                    <?php if($permission->is_accepted): ?>
                    <td>
                        <span class="badge text-bg-success border-0">Sudah Diterima</span>
                        <button class="badge text-bg-info border-0 permission-detail-modal-triggers"
                            data-permission-id="<?php echo e($permission->id); ?>" data-bs-toggle="modal"
                            data-bs-target="#permission-detail-modal">Lihat
                            Alasan</button>
                    </td>
                    <?php else: ?>
                    <td>
                        <form action="<?php echo e(route('presences.acceptPermission', $attendance->id)); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="user_id" value="<?php echo e($permission->user->id); ?>">
                            <input type="hidden" name="permission_date" value="<?php echo e($permission->permission_date); ?>">
                            <button class="badge text-bg-primary border-0" type="submit">Terima</button>
                        </form>
                        <button class="badge text-bg-info border-0 permission-detail-modal-triggers"
                            data-permission-id="<?php echo e($permission->id); ?>" data-bs-toggle="modal"
                            data-bs-target="#permission-detail-modal">Lihat
                            Alasan</button>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php if(count($permissions) !== 0): ?>
<div class="modal fade" id="permission-detail-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul>
                    <li>Judul Izin : <span id="permission-title"></span></li>
                    <li>Keterangan Izin : <p id="permission-description"></p>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <form action="<?php echo e(route('presences.acceptPermission', $attendance->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="user_id" value="<?php echo e($permission->user->id); ?>">
                    <input type="hidden" name="permission_date" value="<?php echo e($permission->permission_date); ?>">
                    <button class="btn btn-primary border-0" type="submit">Terima</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    const permissionUrl = "<?php echo e(route('api.permissions.show')); ?>";
</script>
<script src="<?php echo e(asset('js/presences/permissions.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/presences/permissions.blade.php ENDPATH**/ ?>