<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Position;
use Livewire\Component;
use Illuminate\Support\Str;

class AttendanceCreateForm extends Component
{
    // --- Properti publik untuk mengikat data dari form ---
    public $title;
    public $description;
    public $start_time;
    public $end_time;
    public $batas_start_time;
    public $batas_end_time;
    public $qrcode_mode = false;
    public $days = [];
    public $position_ids = [];
    // ----------------------------------------------------

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_time' => 'required|date_format:H:i',
        'batas_start_time' => 'required|date_format:H:i|after:start_time',
        'end_time' => 'required|date_format:H:i|after:batas_start_time',
        'batas_end_time' => 'required|date_format:H:i|after:end_time',
        'qrcode_mode' => 'boolean',
        'days' => 'required|array|min:1',
        'days.*' => 'string|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
        'position_ids' => 'required|array|min:1',
        'position_ids.*' => 'numeric|exists:positions,id',
    ];

    public function save()
    {
        // Validasi data dari form
        $this->validate();

        // Menggabungkan semua properti menjadi satu array untuk pembuatan model
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'batas_start_time' => $this->batas_start_time,
            'batas_end_time' => $this->batas_end_time,
            'qrcode_mode' => $this->qrcode_mode,
            'days' => $this->days, // Model akan meng-cast ke JSON secara otomatis saat menyimpan
        ];
        
        // Menghasilkan kode QR jika qrcode_mode diaktifkan
        if ($this->qrcode_mode) {
             $data['code'] = Str::random(4);
        }

        $attendance = Attendance::create($data);

        // Menggunakan attach() untuk form create
        $attendance->positions()->attach($this->position_ids);

        // Mengirim pesan flash ke session untuk notifikasi
        session()->flash('success', 'Data absensi berhasil ditambahkan.');
        // Redirect ke halaman index setelah menyimpan
        return redirect()->route('attendances.index');
    }

    public function render()
    {
        return view('livewire.attendance-create-form', [
            'positions' => Position::all()
        ]);
    }
}
