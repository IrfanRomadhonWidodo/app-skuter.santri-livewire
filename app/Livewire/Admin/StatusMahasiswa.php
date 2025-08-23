<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\MahasiswaStatus;
use Livewire\WithPagination;

class StatusMahasiswa extends Component
{
    use WithPagination;

    public $statusOptions = ['aktif', 'cuti', 'lulus'];
    public $editingId = null;
    public $status;
    public $keterangan;

    protected $rules = [
        'status' => 'required|in:aktif,cuti,lulus',
        'keterangan' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        // Sync otomatis mahasiswa dari tabel users ke status mahasiswa
        $mahasiswas = User::where('role', 'mahasiswa')->get();
        foreach ($mahasiswas as $mhs) {
            MahasiswaStatus::firstOrCreate(
                ['user_id' => $mhs->id],
                ['status' => 'aktif', 'keterangan' => null]
            );
        }
    }

    public function edit($id)
    {
        $this->editingId = $id;
        $record = MahasiswaStatus::findOrFail($id);
        $this->status = $record->status;
        $this->keterangan = $record->keterangan;
    }

    public function update()
    {
        $this->validate();
        $record = MahasiswaStatus::findOrFail($this->editingId);
        $record->update([
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ]);
        $this->reset(['editingId', 'status', 'keterangan']);
    }

    public function render()
    {
        $statuses = MahasiswaStatus::with('user')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.administrasi.status-mahasiswa', compact('statuses'));
    }
}
