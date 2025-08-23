<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\MahasiswaStatus;
use Livewire\WithPagination;

class StatusMahasiswa extends Component
{
    use WithPagination;

    // Properties for modal and form
    public $showModal = false;
    public $isEdit = false;
    public $editingId = null;
    
    // Form properties
    public $status;
    public $keterangan;
    public $search = '';
    
    // Status options
    public $statusOptions = ['aktif', 'cuti', 'keluar', 'lulus'];

    protected $rules = [
        'status' => 'required|in:aktif,cuti,keluar,lulus',
        'keterangan' => 'nullable|string|max:255',
    ];

    protected $listeners = [
        'closeModal' => 'closeModal',
        'deleteStatus' => 'deleteStatus'
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showEditModal($id)
    {
        $this->resetForm();
        $this->editingId = $id;
        $this->isEdit = true;
        
        $record = MahasiswaStatus::findOrFail($id);
        $this->status = $record->status;
        $this->keterangan = $record->keterangan;
        
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();
        
        try {
            $record = MahasiswaStatus::findOrFail($this->editingId);
            $record->update([
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);
            
            $this->closeModal();
            $this->dispatch('showSuccessMessage', ['message' => 'Status mahasiswa berhasil diperbarui!']);
            
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal memperbarui status mahasiswa!']);
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirmDelete', ['id' => $id]);
    }

    public function deleteStatus($id)
    {
        try {
            $record = MahasiswaStatus::findOrFail($id);
            $record->delete();
            
            $this->dispatch('showSuccessMessage', ['message' => 'Status mahasiswa berhasil dihapus!']);
            
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal menghapus status mahasiswa!']);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['status', 'keterangan', 'isEdit', 'editingId']);
        $this->resetErrorBag();
    }

    public function render()
    {
        $statuses = MahasiswaStatus::with('user')
            ->when($this->search, function($query) {
                $query->whereHas('user', function($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('nim', 'like', '%' . $this->search . '%')
                             ->orWhere('program', 'like', '%' . $this->search . '%');
                })
                ->orWhere('keterangan', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.administrasi.status-mahasiswa', compact('statuses'));
    }
}