<?php if($attendance->data): ?>
    <?php
        // Ambil data hari dan jam dari jadwal
        $days = $attendance->days;
        $start_time = \Carbon\Carbon::parse($attendance->data->start_time);
        $batas_start_time = \Carbon\Carbon::parse($attendance->data->batas_start_time);
        $end_time = \Carbon\Carbon::parse($attendance->data->end_time);
        $batas_end_time = \Carbon\Carbon::parse($attendance->data->batas_end_time);
        $now = \Carbon\Carbon::now();
        $today = strtolower($now->locale('en')->dayName);
        
        // Cek apakah hari ini termasuk hari kerja
        $isWorkingDay = in_array($today, $days);
        
        // Cek apakah sedang dalam rentang waktu absen masuk
        $isEntranceTime = $now->between($start_time, $batas_start_time);

        // Cek apakah sedang dalam rentang waktu absen pulang
        $isOutTime = $now->between($end_time, $batas_end_time);
    ?>

    <?php if($attendance->data->is_holiday_today): ?>
        <span class="badge text-bg-success rounded-pill">Hari Libur</span>
    <?php elseif($isWorkingDay): ?>
        <?php if($isEntranceTime && $attendance->data->is_start): ?>
            <span class="badge bg-primary rounded-pill">Jam Masuk</span>
        <?php elseif($isOutTime && $attendance->data->is_end): ?>
            <span class="badge text-bg-warning rounded-pill">Jam Pulang</span>
        <?php else: ?>
            
        <?php endif; ?>
    <?php else: ?>
        
    <?php endif; ?>
<?php endif; ?><?php /**PATH D:\Kumpulan Skripsi Joki\skripsi Ophy\absensi-app-main\resources\views/partials/attendance-badges.blade.php ENDPATH**/ ?>