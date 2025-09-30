{{-- File: resources/views/livewire/presence-form.blade.php --}}

<div>
    {{-- Tampilkan status absensi jika bukan hari libur dan hari kerja --}}
    @if (!$data['is_closed'])
        @if ($data['is_there_permission'])
            <div class="alert alert-warning text-center">
                <small class="fw-bold">Anda memiliki izin yang telah dikirim.</small>
            </div>
            @if ($data['is_permission_accepted'])
                <div class="alert alert-success text-center">
                    <small class="fw-bold">Izin Anda telah disetujui.</small>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    <small class="fw-bold">Izin Anda belum disetujui.</small>
                </div>
            @endif
        @else
            {{-- LOGIKA UTAMA ABSENSI --}}
            {{-- Jika sudah lewat jam masuk dan belum absen, tampilkan Alfa --}}
            @if (!$data['is_has_enter_today'] && !$data['is_start'])
                <div class="alert alert-danger text-center">
                    <small class="fw-bold">Absensi masuk telah berakhir.</small>
                </div>
            @elseif ($data['is_start'] && !$data['is_has_enter_today'])
                <div class="alert alert-info text-center">
                    <small class="fw-bold">Absensi masuk sedang berlangsung.</small>
                </div>
            @elseif ($data['is_has_enter_today'] && !$data['is_not_out_yet'])
                <div class="alert alert-success text-center">
                    <small class="fw-bold">Anda sudah melakukan absensi masuk.</small>
                </div>
            @elseif ($data['is_end_over'])
                <div class="alert alert-danger text-center">
                    <small class="fw-bold">Absensi pulang telah berakhir, harap hubungi Admin.</small>
                </div>
            @else
                <div class="alert alert-warning text-center">
                    <small class="fw-bold">Silakan tunggu jam absen pulang.</small>
                </div>
            @endif
        @endif
    @else
        {{-- Logika absensi ditutup --}}
        <div class="alert alert-secondary text-center">
            <small class="fw-bold">Absensi Ditutup untuk hari ini.</small>
        </div>
    @endif

    {{-- Tampilkan tombol absensi --}}
    @if (!$attendance->is_using_qrcode && !$data['is_closed'] && !$data['is_there_permission'])
        {{-- Tombol Absen Masuk --}}
        @if ($data['is_start'] && !$data['is_has_enter_today'])
            <div class="d-grid gap-2">
                <button wire:click.prevent="sendEnterPresence" class="btn btn-success fw-bold">Absen Masuk</button>
            </div>
        @endif

        {{-- Tombol Absen Pulang --}}
        @if ($data['is_end'] && $data['is_has_enter_today'] && $data['is_not_out_yet'])
            <div class="d-grid gap-2">
                <button wire:click.prevent="sendOutPresence" class="btn btn-warning fw-bold">Absen Pulang</button>
            </div>
        @endif
    @endif
</div>