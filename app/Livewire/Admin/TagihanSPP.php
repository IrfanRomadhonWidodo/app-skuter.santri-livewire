<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\Periode;

class TagihanSPP extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->generateTagihanOtomatis();
    }

    /**
     * Generate tagihan otomatis untuk mahasiswa aktif sesuai periode terbaru
     */
    public function generateTagihanOtomatis()
    {
        $periodes = Periode::with('programStudi')->get();

        foreach ($periodes as $periode) {
            // Ambil mahasiswa aktif di program yang sama
            $mahasiswas = User::where('role', 'mahasiswa')
                ->where('program_studi_id', $periode->programStudi->id)
                ->with('mahasiswaStatus')
                ->get();

            foreach ($mahasiswas as $mahasiswa) {
                if (!$mahasiswa->mahasiswaStatus || !in_array($mahasiswa->mahasiswaStatus->status, ['aktif', 'cuti'])) {
                    continue;
                }

                $exists = Tagihan::where('mahasiswa_id', $mahasiswa->id)
                    ->where('periode_id', $periode->id)
                    ->exists();

                if (!$exists) {
                    Tagihan::create([
                        'mahasiswa_id' => $mahasiswa->id,
                        'periode_id' => $periode->id,
                        'nim' => $mahasiswa->nim, // ambil dari users
                        'nama_mahasiswa' => $mahasiswa->name,
                        'program' => $mahasiswa->program,
                        'total_tagihan' => $periode->nominal_awal,
                        'terbayar' => 0,
                        'status' => 'diproses',
                    ]);
                }
            }
        }
    }
}


    public function render()
    {
        $tagihans = Tagihan::with(['mahasiswa', 'periode'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.transaksi.tagihan-spp', [
            'tagihans' => $tagihans
        ]);
    }
}
