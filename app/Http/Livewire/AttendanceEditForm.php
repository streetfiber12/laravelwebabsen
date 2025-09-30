<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Position;
use Livewire\Component;
use Illuminate\Support\Str;

class AttendanceEditForm extends Component
{
    // Properti publik untuk mengikat data dari form
    public $attendanceId;
    public $title;
    public $description;
    public $start_time;
    public $end_time;
    public $batas_start_time;
    public $batas_end_time;
    public $qrcode_mode;
    public $days = [];
    public $position_ids = [];

    // Properti tambahan untuk menyimpan kode awal
    public $initialCode;

    // Aturan validasi
    // Catatan: Aturan untuk qrcode_mode dihapus karena seringkali
    // bermasalah dengan Livewire, dan akan divalidasi secara manual.
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'batas_start_time' => 'required|date_format:H:i|after:start_time',
        'end_time' => 'required|date_format:H:i|after:batas_start_time',
        'batas_end_time' => 'required|date_format:H:i|after:end_time',
        // 'qrcode_mode' => 'boolean', // Aturan ini dihapus
        'days' => 'required|array|min:1',
        'days.*' => 'string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
        'position_ids' => 'required|array|min:1',
        'position_ids.*' => 'numeric|exists:positions,id',
    ];

    public function mount(Attendance $attendance)
    {
        $this->attendanceId = $attendance->id;
        $this->title = $attendance->title;
        $this->description = $attendance->description;
        $this->start_time = substr($attendance->start_time, 0, 5);
        $this->batas_start_time = substr($attendance->batas_start_time, 0, 5);
        $this->end_time = substr($attendance->end_time, 0, 5);
        $this->batas_end_time = substr($attendance->batas_end_time, 0, 5);
        $this->days = $attendance->days;
        $this->position_ids = $attendance->positions->pluck('id')->toArray();
        $this->initialCode = $attendance->code;
        $this->qrcode_mode = (bool) $attendance->qrcode_mode;
    }

    public function save()
    {
        $this->validate();

        $attendance = Attendance::findOrFail($this->attendanceId);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'batas_start_time' => $this->batas_start_time,
            'batas_end_time' => $this->batas_end_time,
            'days' => $this->days,
            // Perbaikan: Pastikan nilai qrcode_mode adalah boolean yang valid
            'qrcode_mode' => (bool) $this->qrcode_mode,
        ];
        
        // Perbaikan: Logika untuk kode QR
        if ($data['qrcode_mode']) {
            // Jika mode QR diaktifkan dan belum ada kode, buat kode baru
            if (!$this->initialCode) {
                 $data['code'] = Str::random(4);
            } else {
                 // Jika sudah ada kode, gunakan kode yang sudah ada
                 $data['code'] = $this->initialCode;
            }
        } else {
            // Jika mode QR dinonaktifkan, set kode menjadi null
             $data['code'] = null;
        }

        $attendance->update($data);

        $attendance->positions()->sync($this->position_ids);

        session()->flash('success', 'Data absensi berhasil diubah.');
        return redirect()->route('attendances.index');
    }

    public function render()
    {
        return view('livewire.attendance-edit-form', [
            'positions' => Position::all()
        ]);
    }
}
