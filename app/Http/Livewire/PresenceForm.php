<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Presence;
use App\Models\Permission;
use Livewire\Component;
use Carbon\Carbon;

class PresenceForm extends Component
{
    public Attendance $attendance;
    public $data = [
        'is_start' => false,
        'is_end' => false,
        'is_has_enter_today' => false,
        'is_not_out_yet' => false,
        'is_there_permission' => false,
        'is_permission_accepted' => false,
        'is_closed' => false, // Menambahkan status ditutup
        'is_end_over' => false, 
    ];

    public function mount(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function sendEnterPresence()
    {
        // Pengecekan hari kerja dan hari libur menggunakan atribut 'data' dari model
        $hari_ini = strtolower(Carbon::now()->locale('id')->dayName);
        if (!in_array($hari_ini, $this->attendance->days) || $this->attendance->data->is_holiday_today) {
            return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Absensi tidak berlaku untuk hari ini."]);
        }
        
        // Menggunakan properti 'is_start' dari atribut 'data'
        if ($this->attendance->data->is_start && !$this->attendance->data->is_using_qrcode) {
            
            $existingPresence = Presence::query()
                ->where('user_id', auth()->user()->id)
                ->where('attendance_id', $this->attendance->id)
                ->where('presence_date', now()->toDateString())
                ->first();
            
            if ($existingPresence) {
                return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Anda sudah melakukan absensi masuk hari ini."]);
            }

            Presence::create([
                "user_id" => auth()->user()->id,
                "attendance_id" => $this->attendance->id,
                "presence_date" => now()->toDateString(),
                "presence_enter_time" => now()->toTimeString(),
                "presence_out_time" => null
            ]);

            $this->data['is_has_enter_today'] = true;
            $this->data['is_not_out_yet'] = true;

            return $this->dispatchBrowserEvent('showToast', ['success' => true, 'message' => "Kehadiran atas nama '" . auth()->user()->name . "' berhasil dikirim."]);
        }

        return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Belum saatnya melakukan absensi masuk."]);
    }

    public function sendOutPresence()
    {
        // Pengecekan hari kerja dan hari libur menggunakan atribut 'data' dari model
        $hari_ini = strtolower(Carbon::now()->locale('id')->dayName);
        if (!in_array($hari_ini, $this->attendance->days) || $this->attendance->data->is_holiday_today) {
            return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Absensi tidak berlaku untuk hari ini."]);
        }

        // Menggunakan properti 'is_end' dari atribut 'data'
        if ($this->attendance->data->is_end && !$this->attendance->data->is_using_qrcode) {
            $presence = Presence::query()
                ->where('user_id', auth()->user()->id)
                ->where('attendance_id', $this->attendance->id)
                ->where('presence_date', now()->toDateString())
                ->where('presence_out_time', null)
                ->first();

            if (!$presence) {
                return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Terjadi masalah pada saat melakukan absensi, absensi masuk tidak ditemukan."]);
            }

            $this->data['is_not_out_yet'] = false;
            $presence->update(['presence_out_time' => now()->toTimeString()]);
            return $this->dispatchBrowserEvent('showToast', ['success' => true, 'message' => "Atas nama '" . auth()->user()->name . "' berhasil melakukan absensi pulang."]);
        }
        
        return $this->dispatchBrowserEvent('showToast', ['success' => false, 'message' => "Belum saatnya melakukan absensi pulang atau absensi ini menggunakan QR Code."]);
    }

     public function render()
    {
        $hari_ini = strtolower(Carbon::now()->locale('id')->dayName);
        $this->data['is_closed'] = !in_array($hari_ini, $this->attendance->days) || $this->attendance->data->is_holiday_today;

        if ($this->data['is_closed']) {
            return view('livewire.presence-form');
        }

        $todayPresence = Presence::query()
            ->where('user_id', auth()->user()->id)
            ->where('attendance_id', $this->attendance->id)
            ->where('presence_date', now()->toDateString())
            ->first();

        $todayPermission = Permission::query()
            ->where('user_id', auth()->user()->id)
            ->where('attendance_id', $this->attendance->id)
            ->where('permission_date', now()->toDateString())
            ->first();

        $this->data['is_has_enter_today'] = (bool) $todayPresence;
        $this->data['is_not_out_yet'] = (bool) ($todayPresence && $todayPresence->presence_out_time === null);
        $this->data['is_there_permission'] = (bool) $todayPermission;
        $this->data['is_permission_accepted'] = (bool) ($todayPermission && $todayPermission->is_accepted);
        
        $this->data['is_start'] = $this->attendance->data->is_start;
        $this->data['is_end'] = $this->attendance->data->is_end;
        
        $end_time = Carbon::parse($this->attendance->end_time);
        $batas_end_time = Carbon::parse($this->attendance->batas_end_time);
        $current_time = Carbon::now();
        $this->data['is_end_over'] = $current_time->greaterThan($batas_end_time);
        
        // >>> LOGIKA BARU DITAMBAHKAN DI SINI <<<
        $batas_start_time = Carbon::parse($this->attendance->batas_start_time);
        $now = Carbon::now();

        if ($todayPresence === null && $now->greaterThan($batas_start_time)) {
            $this->data['status_keterangan'] = 'Alfa';
        } elseif ($todayPresence === null) {
            $this->data['status_keterangan'] = 'Belum Hadir';
        } elseif ($todayPermission) {
            $this->data['status_keterangan'] = 'Izin';
        } else {
            $this->data['status_keterangan'] = 'Hadir';
        }

        $this->data['jam_masuk_tampil'] = $this->data['status_keterangan'] === 'Alfa' ? 'Alfa' : ($todayPresence->presence_enter_time ?? '-');
        $this->data['jam_pulang_tampil'] = $this->data['status_keterangan'] === 'Alfa' ? '-' : ($todayPresence->presence_out_time ?? 'Belum Absen Pulang');
        // >>> AKHIR LOGIKA BARU <<<

        return view('livewire.presence-form', [
            'todayPresence' => $todayPresence,
        ]);
    }
}
