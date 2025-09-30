@extends('layouts.home')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
            @php
            $today = \Carbon\Carbon::now()->locale('id')->dayName;
            $isWorkingDay = in_array(strtolower($today), $attendance->days);
            @endphp

            @if ($isWorkingDay)
            <h1 class="fs-2">{{ $attendance->title }}</h1>
            <p class="text-muted">{{ $attendance->description }}</p>

            <div class="mb-4">
                <span class="badge text-bg-light border shadow-sm">Masuk : {{
                    substr($attendance->data->start_time, 0 , -3) }} - {{
                    substr($attendance->data->batas_start_time,0,-3 )}}</span>
                <span class="badge text-bg-light border shadow-sm">Pulang : {{
                    substr($attendance->data->end_time, 0 , -3) }} - {{
                    substr($attendance->data->batas_end_time,0,-3 )}}</span>
            </div>
            
            @livewire('presence-form', ['attendance' => $attendance])
            @else
            <div class="mb-2">
                <span class="badge text-bg-secondary">Tutup</span>
            </div>
            <h1 class="fs-2 text-danger">Absen Ditutup</h1>
            <p class="text-muted">Hari ini adalah hari {{ $today }}. Absensi untuk jadwal ini tidak tersedia.</p>
            @endif
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
                        @foreach ($priodDate as $date)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            @php
                            $histo = $history->where('presence_date', $date)->first();
                            $histoDay = \Carbon\Carbon::parse($date)->locale('id')->dayName;
                            $isHistoWorkingDay = in_array(strtolower($histoDay), $attendance->days);

                            // Periksa apakah batas waktu absensi masuk sudah lewat
                            $isStartOver = (\Carbon\Carbon::parse($date)->lt(now()->toDateString())) || (\Carbon\Carbon::parse($date)->isToday() && now()->gt(\Carbon\Carbon::parse($attendance->batas_start_time)));
                            @endphp

                            @if (!$histo)
                            <td>{{ $date }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>
                                @if($date == now()->toDateString() && $isHistoWorkingDay && !$isStartOver)
                                <div class="badge text-bg-info">Belum Hadir</div>
                                @elseif(!$isHistoWorkingDay)
                                <div class="badge text-bg-secondary">Absen Ditutup</div>
                                @else
                                <div class="badge text-bg-danger">Alfa</div>
                                @endif
                            </td>
                            @else
                            <td>{{ $histo->presence_date }}</td>
                            <td>{{ $histo->presence_enter_time }}</td>
                            <td>@if($histo->presence_out_time)
                                {{ $histo->presence_out_time }}
                                @else
                                <span class="badge text-bg-danger">Belum Absensi Pulang</span>
                                @endif
                            </td>
                            <td>
                                @if ($histo->is_permission)
                                <div class="badge text-bg-warning">Izin</div>
                                @else
                                <div class="badge text-bg-success">Hadir</div>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection