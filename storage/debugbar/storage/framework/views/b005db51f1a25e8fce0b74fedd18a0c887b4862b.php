<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
            <?php
            $today = \Carbon\Carbon::now()->locale('id')->dayName;
            $isWorkingDay = in_array(strtolower($today), $attendance->days);
            ?>

            <?php if($isWorkingDay): ?>
            <h1 class="fs-2"><?php echo e($attendance->title); ?></h1>
            <p class="text-muted"><?php echo e($attendance->description); ?></p>

            <div class="mb-4">
                <span class="badge text-bg-light border shadow-sm">Masuk : <?php echo e(substr($attendance->data->start_time, 0 , -3)); ?> - <?php echo e(substr($attendance->data->batas_start_time,0,-3 )); ?></span>
                <span class="badge text-bg-light border shadow-sm">Pulang : <?php echo e(substr($attendance->data->end_time, 0 , -3)); ?> - <?php echo e(substr($attendance->data->batas_end_time,0,-3 )); ?></span>
            </div>
            
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('presence-form', ['attendance' => $attendance])->html();
} elseif ($_instance->childHasBeenRendered('moEDIpO')) {
    $componentId = $_instance->getRenderedChildComponentId('moEDIpO');
    $componentTag = $_instance->getRenderedChildComponentTagName('moEDIpO');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('moEDIpO');
} else {
    $response = \Livewire\Livewire::mount('presence-form', ['attendance' => $attendance]);
    $html = $response->html();
    $_instance->logRenderedChild('moEDIpO', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php else: ?>
            <div class="mb-2">
                <span class="badge text-bg-secondary">Tutup</span>
            </div>
            <h1 class="fs-2 text-danger">Absen Ditutup</h1>
            <p class="text-muted">Hari ini adalah hari <?php echo e($today); ?>. Absensi untuk jadwal ini tidak tersedia.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h5 class="mb-3">Histori 30 Hari Terakhir</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Pulang</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $priodDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row"><?php echo e($loop->iteration); ?></th>
                            <?php
                            $histo = $history->where('presence_date', $date)->first();
                            $histoDay = \Carbon\Carbon::parse($date)->locale('id')->dayName;
                            $isHistoWorkingDay = in_array(strtolower($histoDay), $attendance->days);

                            // Periksa apakah batas waktu absensi masuk sudah lewat
                            $isStartOver = (\Carbon\Carbon::parse($date)->lt(now()->toDateString())) || (\Carbon\Carbon::parse($date)->isToday() && now()->gt(\Carbon\Carbon::parse($attendance->batas_start_time)));
                            ?>

                            <?php if(!$histo): ?>
                            <td><?php echo e($date); ?></td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                <?php if($date == now()->toDateString() && $isHistoWorkingDay && !$isStartOver): ?>
                                <div class="badge text-bg-info">Belum Hadir</div>
                                <?php elseif(!$isHistoWorkingDay): ?>
                                <div class="badge text-bg-secondary">Absen Ditutup</div>
                                <?php else: ?>
                                <div class="badge text-bg-danger">Alfa</div>
                                <?php endif; ?>
                            </td>
                            <?php else: ?>
                            <td><?php echo e($histo->presence_date); ?></td>
                            <td><?php echo e($histo->presence_enter_time); ?></td>
                            <td><?php if($histo->presence_out_time): ?>
                                <?php echo e($histo->presence_out_time); ?>

                                <?php else: ?>
                                <span class="badge text-bg-danger">Belum Absensi Pulang</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($histo->is_permission): ?>
                                <div class="badge text-bg-warning">Izin</div>
                                <?php else: ?>
                                <div class="badge text-bg-success">Hadir</div>
                                <?php endif; ?>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/home/show.blade.php ENDPATH**/ ?>