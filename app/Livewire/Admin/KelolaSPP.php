<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Periode;
use App\Models\ProgramStudi;

class KelolaSPP extends Component
{
    use WithPagination;

    public $kode, $program_studi_id, $nominal_default, $periode_mulai, $periode_selesai;
    public $selectedId = null;
    public $isEdit = false;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'kode'              => 'required|string|max:50',
        'program_studi_id'  => 'required|exists:program_studis,id',
        'nominal_default'   => 'required|numeric|min:0',
        'periode_mulai'     => 'nullable|date',
        'periode_selesai'   => 'nullable|date|after_or_equal:periode_mulai',
    ];

    protected $listeners = [
        'deleteData' => 'delete',
        'closeModal' => 'closeModal'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->isEdit = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'kode',
            'program_studi_id',
            'nominal_default',
            'periode_mulai',
            'periode_selesai',
            'selectedId',
            'isEdit'
        ]);
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();

        try {
            Periode::create([
                'kode'              => $this->kode,
                'program_studi_id'  => $this->program_studi_id,
                'nominal_default'   => $this->nominal_default,
                'periode_mulai'     => $this->periode_mulai,
                'periode_selesai'   => $this->periode_selesai,
            ]);

            $this->dispatch('showSuccessMessage', ['message' => 'Periode SPP berhasil ditambahkan.']);
            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal menambahkan periode SPP.']);
        }
    }

    public function edit($id)
    {
        try {
            $record = Periode::findOrFail($id);
            $this->selectedId     = $id;
            $this->kode           = $record->kode;
            $this->program_studi_id        = $record->program_studi_id;
            $this->nominal_default = $record->nominal_default;
            $this->periode_mulai  = $record->periode_mulai ? $record->periode_mulai->format('Y-m-d') : null;
            $this->periode_selesai = $record->periode_selesai ? $record->periode_selesai->format('Y-m-d') : null;
            $this->isEdit = true;
            $this->showModal = true;
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Data tidak ditemukan.']);
        }
    }

    public function update()
    {
        $this->validate();

        try {
            if ($this->selectedId) {
                $record = Periode::findOrFail($this->selectedId);
                $record->update([
                    'kode'              => $this->kode,
                    'program_studi_id'  => $this->program_studi_id,
                    'nominal_default'   => $this->nominal_default,
                    'periode_mulai'     => $this->periode_mulai,
                    'periode_selesai'   => $this->periode_selesai,
                ]);

                $this->dispatch('showSuccessMessage', ['message' => 'Periode SPP berhasil diperbarui.']);
                $this->closeModal();
            }
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal memperbarui periode SPP.']);
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirmDelete', ['id' => $id]);
    }

    public function delete($id)
    {
        try {
            Periode::findOrFail($id)->delete();
            $this->dispatch('showSuccessMessage', ['message' => 'Periode SPP berhasil dihapus.']);
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal menghapus periode SPP.']);
        }
    }

    public function render()
    {
        $query = Periode::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('kode', 'like', '%' . $this->search . '%')
                    ->orWhere('program_studi_id', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.admin.administrasi.kelola-spp', [
            'periodes' => $query->orderBy('created_at', 'desc')->paginate(10),
            'program_studis' => ProgramStudi::all(),
        ]);
    }
}
