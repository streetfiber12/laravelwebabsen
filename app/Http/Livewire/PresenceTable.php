<?php

namespace App\Http\Livewire;

use App\Models\Attendance;
use App\Models\Presence;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use Illuminate\Support\Facades\DB;

final class PresenceTable extends PowerGridComponent
{
    use ActionButton;

    // Properti publik untuk menerima attendanceId dari parent component
    public $attendanceId;
    // Properti untuk menyimpan model Attendance, diinisialisasi null agar tidak error
    public ?Attendance $attendance = null;
    // Field default untuk pengurutan tabel
    public string $sortField = 'presences.created_at';
    public string $sortDirection = 'desc';

    /**
     * Method ini dipanggil setelah komponen Livewire terpasang.
     */
    public function booted()
    {
        if ($this->attendanceId) {
            $this->attendance = Attendance::find($this->attendanceId);
        }
    }

    /**
     * Mengatur fitur-fitur umum tabel seperti export, pencarian, dan pagination.
     *
     * @return array
     */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput()->showToggleColumns(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /**
     * PowerGrid datasource.
     * Memberikan data ke tabel menggunakan Eloquent Builder.
     * KALI INI KITA AKAN MEMFILTER DATA DI SINI.
     *
     * @return Builder<\App\Models\Presence>
     */
    public function datasource(): Builder
{
    if (!$this->attendance) {
        return Presence::query()->where('id', null);
    }

    // NONAKTIFKAN FILTER HARI UNTUK UJI COBA
    // $validDays = $this->attendance->days ?? [];

    return Presence::query()
        ->where('attendance_id', $this->attendanceId)
        ->join('users', 'presences.user_id', '=', 'users.id')
        ->select('presences.*', 'users.name as user_name');
        // HILANGKAN BARIS FILTER INI UNTUK UJI COBA
        // ->whereIn(DB::raw('LOWER(DAYNAME(presences.created_at))'), $validDays);
}

    /**
     * Menambahkan kolom-kolom data dan melakukan transformasi data.
     *
     * @return PowerGridEloquent
     */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('user_name')
            ->addColumn("presence_date")
            // Kolom 'Jam Absen Masuk' tanpa logika kondisional karena data sudah difilter
            ->addColumn("presence_enter_time")
            // Kolom 'Jam Absen Pulang' tanpa logika kondisional
            ->addColumn("presence_out_time", fn (Presence $model) => $model->presence_out_time ?? '<span class="badge text-bg-danger">Belum Absensi Pulang</span>')
            // Kolom Status
            ->addColumn("is_permission", fn (Presence $model) => $model->is_permission ?
                '<span class="badge text-bg-warning">Izin</span>' : '<span class="badge text-bg-success">Hadir</span>')
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', fn (Presence $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan di tabel.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),

            Column::make('Nama', 'user_name')
                ->searchable()
                ->makeInputText('users.name')
                ->sortable(),

            Column::make('Tanggal Hadir', 'presence_date')
                ->makeInputDatePicker()
                ->searchable()
                ->sortable(),

            Column::make('Jam Absen Masuk', 'presence_enter_time')
                ->searchable()
                ->makeInputText('presence_enter_time')
                ->sortable(),

            Column::make('Jam Absen Pulang', 'presence_out_time')
                ->searchable()
                ->makeInputText('presence_out_time')
                ->sortable(),

            Column::make('Status', 'is_permission')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->hidden(),

            Column::make('Created at', 'created_at_formatted')
                ->makeInputDatePicker()
                ->searchable()
                ->sortable(),
        ];
    }
}
