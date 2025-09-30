@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $title }}</h2>
    <p>Hari ini adalah **{{ ucfirst($hari_ini) }}**.</p>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Guru</th>
                <th>Jabatan / Posisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->position->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada guru yang tidak memiliki jadwal hari ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection