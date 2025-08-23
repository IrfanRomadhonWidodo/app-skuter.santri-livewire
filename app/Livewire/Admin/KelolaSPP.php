<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\JenisTagihan;

class KelolaSPP extends Component
{
    use WithPagination;

    public $kode, $program, $nominal_default, $periode_mulai, $periode_selesai;
    public $selectedId = null;
    public $isEdit = false;

    protected $rules = [
        'kode'            => 'required|string|max:50',
        'program'         => 'required|string|max:100',
        'nominal_default' => 'required|numeric|min:0',
        'periode_mulai'   => 'nullable|date',
        'periode_selesai' => 'nullable|date|after_or_equal:periode_mulai',
    ];

    public function resetForm()
    {
        $this->reset([
            'kode',
            'program',
            'nominal_default',
            'periode_mulai',
            'periode_selesai',
            'selectedId',
            'isEdit'
        ]);
    }

    public function store()
    {
        $this->validate();

        JenisTagihan::create([
            'kode'            => $this->kode,
            'program'         => $this->program,
            'nominal_default' => $this->nominal_default,
            'periode_mulai'   => $this->periode_mulai,
            'periode_selesai' => $this->periode_selesai,
        ]);

        session()->flash('success', 'Jenis Tagihan berhasil ditambahkan.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $record = JenisTagihan::findOrFail($id);
        $this->selectedId     = $id;
        $this->kode           = $record->kode;
        $this->program        = $record->program;
        $this->nominal_default = $record->nominal_default;
        $this->periode_mulai  = $record->periode_mulai;
        $this->periode_selesai = $record->periode_selesai;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->selectedId) {
            $record = JenisTagihan::findOrFail($this->selectedId);
            $record->update([
                'kode'            => $this->kode,
                'program'         => $this->program,
                'nominal_default' => $this->nominal_default,
                'periode_mulai'   => $this->periode_mulai,
                'periode_selesai' => $this->periode_selesai,
            ]);

            session()->flash('success', 'Jenis Tagihan berhasil diperbarui.');
            $this->resetForm();
        }
    }

    public function destroy($id)
    {
        JenisTagihan::findOrFail($id)->delete();
        session()->flash('success', 'Jenis Tagihan berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.administrasi.kelola-spp', [
            'jenisTagihans' => JenisTagihan::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
