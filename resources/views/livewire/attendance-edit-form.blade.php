<div>
    <form wire:submit.prevent="save" method="post" novalidate>
        @include('partials.alerts')
        <div class="w-100">
            <div class="mb-3">
                <x-form-label id="title" label='Nama/Judul Absensi' />
                <x-form-input id="title" name="title" wire:model.defer="title" />
                <x-form-error key="title" />
            </div>
            <div class="mb-3">
                <x-form-label id="description" label='Keterangan' />
                <textarea id="description" name="description" class="form-control"
                    wire:model.defer="description"></textarea>
                <x-form-error key="description" />
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <x-form-label id="start_time" label='Waktu Absen Masuk' />
                        <x-form-input type="text" maxlength="5" id="start_time" name="start_time"
                            wire:model.defer="start_time" placeholder="07:00" />
                        <x-form-error key="start_time" />
                    </div>
                    <div class="col-md-6">
                        <x-form-label id="batas_start_time" label='Batas Waktu Absen Masuk' />
                        <x-form-input type="text" maxlength="5" id="batas_start_time" name="batas_start_time"
                            wire:model.defer="batas_start_time" />
                        <x-form-error key="batas_start_time" />
                    </div>
                </div>
                <small class="text-muted d-block mt-1">Masukan dengan format 24:00.</small>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <x-form-label id="end_time" label='Waktu Absen Pulang' />
                        <x-form-input type="text" maxlength="5" id="end_time" name="end_time"
                            wire:model.defer="end_time" />
                        <x-form-error key="end_time" />
                    </div>
                    <div class="col-md-6">
                        <x-form-label id="batas_end_time" label='Batas Waktu Absen Pulang' />
                        <x-form-input type="text" maxlength="5" id="batas_end_time" name="batas_end_time"
                            wire:model.defer="batas_end_time" />
                        <x-form-error key="batas_end_time" />
                    </div>
                </div>
                <small class="text-muted d-block mt-1">Masukan dengan format 24:00.</small>
            </div>

            <div class="mb-3">
                <x-form-label id="positions" label='Posisi Karyawaan' />
                <div class="row ms-1">
                    @foreach ($positions as $position)
                    <div class="form-check col-sm-4">
                        <input class="form-check-input" type="checkbox" value="{{ $position->id }}"
                            wire:model.defer="position_ids" id="flexCheckPosition{{ $loop->index }}">
                        <label class="form-check-label" for="flexCheckPosition{{ $loop->index }}">
                            {{ $position->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <small class="text-muted d-block mt-1">Pilih posisi karyawaan yang akan menggunakan absensi ini.</small>
                <x-form-error key="position_ids" />
            </div>

            <div class="mb-3">
                <label>Hari yang Harus Absen</label>
                <div class="d-flex flex-wrap">
                    @foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'] as $day)
                    <div class="form-check me-3">
                        <input wire:model.defer="days" class="form-check-input" type="checkbox" value="{{ $day }}"
                            id="flexCheckDay{{ $day }}">
                        <label class="form-check-label" for="flexCheckDay{{ $day }}">
                            {{ ucfirst($day) }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <x-form-error key="days" />
            </div>

            <div class="mb-3">
                <x-form-label id="flexCheckCode" label='Ingin Menggunakan QRCode (default menggunakan tombol)' />
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model.defer="qrcode_mode"
                        id="flexCheckCode">
                    <label class="form-check-label" for="flexCheckCode">
                        Menggunakan QRCode
                    </label>
                    <small class="text-muted d-block mt-1">Jika checkbox tersebut diubah maka kemungkinan kode qrcode
                        berubah.</small>
                    <x-form-error key="qrcode_mode" />
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5">
            <button class="btn btn-primary">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
