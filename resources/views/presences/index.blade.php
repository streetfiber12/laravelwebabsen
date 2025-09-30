@extends('layouts.app')

@section('content')
@include('partials.alerts')

<div class="row">
    <div class="col-md-7">
        <ul class="list-group">
            @foreach ($attendances as $attendance)
                {{-- Di sini tidak ada filter, semua jadwal akan ditampilkan --}}
                <a href="{{ route('presences.show', $attendance->id) }}"
                    class="list-group-item d-flex justify-content-between align-items-start py-3">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">{{ $attendance->title }}</div>
                        <p class="mb-0">{{ $attendance->description }}</p>
                    </div>
                    {{-- Badge status akan ditampilkan di sini --}}
                    @include('partials.attendance-badges', ['attendance' => $attendance])
                </a>
            @endforeach
        </ul>
    </div>
</div>
@endsection