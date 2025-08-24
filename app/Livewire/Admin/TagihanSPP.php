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
            // Hapus tagihan yang programnya sudah tidak sesuai lagi
            Tagihan::where('periode_id', $periode->id)
                ->where('program_studi_id', '!=', $periode->programStudi->id)
                ->delete();

            // Ambil semua mahasiswa di program periode ini
            $mahasiswas = User::where('role', 'mahasiswa')
                ->where('program_studi_id', $periode->programStudi->id)
                ->with('mahasiswaStatus')
                ->get();

            foreach ($mahasiswas as $mahasiswa) {
                if (!$mahasiswa->mahasiswaStatus || !in_array($mahasiswa->mahasiswaStatus->status, ['aktif', 'cuti'])) {
                    continue;
                }

                $tagihan = Tagihan::where('user_id', $mahasiswa->id)
                    ->where('periode_id', $periode->id)
                    ->first();

                if ($tagihan) {
                    // Update semua field yang bisa berubah
                    $tagihan->update([
                        'total_tagihan' => $periode->nominal_awal,
                    ]);
                } else {
                    // Buat baru kalau belum ada
                    Tagihan::create([
                        'user_id' => $mahasiswa->id,
                        'periode_id' => $periode->id,
                        'total_tagihan' => $periode->nominal_awal,
                        'terbayar' => 0,
                        'status' => null,
                    ]);
                }
            }
        }
    }

    public function render()
    {
        $tagihans = Tagihan::with(['mahasiswa', 'periode.programStudi'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.transaksi.tagihan-spp', [
            'tagihans' => $tagihans
        ]);
    }
}
