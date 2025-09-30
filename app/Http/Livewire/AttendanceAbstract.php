<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Nama file yang sesuai dengan proyek Anda
abstract class Attendanceabstract extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'batas_start_time',
        'batas_end_time',
        'qrcode_mode',
        'code',
        'days',
    ];

    // Ini adalah perbaikan utamanya: menggunakan casting untuk mengubah
    // kolom 'days' dari JSON string menjadi array saat dibaca
    protected $casts = [
        'days' => 'array',
    ];
}
