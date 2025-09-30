<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'batas_start_time',
        'end_time',
        'batas_end_time',
        'code',
        'days',
    ];

    protected $casts = [
        'days' => 'array',
    ];

    protected $appends = ['data'];

    protected function data(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $now = now();
                $hari_ini = strtolower($now->locale('id')->dayName);
                $isWorkDay = in_array($hari_ini, $this->days);
                
                $isHolidayToday = Holiday::query()
                    ->where('holiday_date', $now->toDateString())
                    ->exists();

                $startTime = Carbon::parse($this->start_time);
                $batasStartTime = Carbon::parse($this->batas_start_time);
                $endTime = Carbon::parse($this->end_time);
                $batasEndTime = Carbon::parse($this->batas_end_time);
                
                // Cek apakah user telah melewati batas waktu absensi masuk
                $isStartOver = $now->gt($batasStartTime);
                
                // Perhitungan is_start dan is_end yang benar
                $isStart = $now->between($startTime, $batasStartTime);
                $isEnd = $now->between($endTime, $batasEndTime);

                return (object) [
                    "start_time" => $this->start_time,
                    "batas_start_time" => $this->batas_start_time,
                    "end_time" => $this->end_time,
                    "batas_end_time" => $this->batas_end_time,
                    "now" => $now->format("H:i:s"),
                    "is_start" => $isStart,
                    "is_end" => $isEnd,
                    "is_end_over" => $now->gt($batasEndTime),
                    'is_using_qrcode' => $this->code ? true : false,
                    'is_holiday_today' => $isHolidayToday,
                    'is_closed' => !$isWorkDay || $isHolidayToday,
                    'is_start_over' => $isStartOver
                ];
            },
        );
    }

    public function scopeForCurrentUser($query, $userPositionId)
    {
        $query->whereHas('positions', function ($query) use ($userPositionId) {
            $query->where('position_id', $userPositionId);
        });
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}