<?php
namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class TagihanUser extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'tailwind';
    public $search = '';
    public $statusFilter = '';
    
    // Properties untuk modal detail
    public $showDetailModal = false;
    public $selectedTagihan = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**
     * Tampilkan detail tagihan
     */
    public function showDetail($tagihanId)
    {
        $this->selectedTagihan = Tagihan::with(['periode.programStudi', 'mahasiswa'])
            ->where('id', $tagihanId)
            ->where('user_id', Auth::id())
            ->first();
        
        if ($this->selectedTagihan) {
            $this->showDetailModal = true;
        }
    }

    /**
     * Tutup modal detail
     */
    public function closeDetail()
    {
        $this->showDetailModal = false;
        $this->selectedTagihan = null;
    }

    /**
     * Hitung total semua tagihan
     */
    public function getTotalTagihan()
    {
        return Tagihan::where('user_id', Auth::id())
            ->sum('total_tagihan');
    }

    /**
     * Hitung total yang sudah terbayar
     */
    public function getTotalTerbayar()
    {
        return Tagihan::where('user_id', Auth::id())
            ->sum('terbayar');
    }

    /**
     * Hitung sisa tagihan
     */
    public function getSisaTagihan()
    {
        return $this->getTotalTagihan() - $this->getTotalTerbayar();
    }

    /**
     * Get status dengan warna
     */
    public function getStatusBadge($tagihan)
    {
        $sisa = $tagihan->total_tagihan - $tagihan->terbayar;
        
        if ($sisa <= 0) {
            return ['text' => 'Lunas', 'class' => 'bg-green-100 text-green-800'];
        } elseif ($tagihan->terbayar > 0) {
            return ['text' => 'Sebagian', 'class' => 'bg-yellow-100 text-yellow-800'];
        } else {
            return ['text' => 'Belum Bayar', 'class' => 'bg-red-100 text-red-800'];
        }
    }

    public function render()
    {
        $userId = Auth::id();
        
        // Ambil tagihan dengan relasi yang dibutuhkan
        $tagihan = Tagihan::with(['periode.programStudi', 'mahasiswa'])
            ->where('user_id', $userId)
            ->when($this->search, function ($query) {
    $search = $this->search;

    $query->whereHas('periode', function ($q) use ($search) {
        $q->where('nama_periode', 'like', "%{$search}%")
          ->orWhere('tahun_ajaran', 'like', "%{$search}%")
          ->orWhere('semester', 'like', "%{$search}%");
    })
    ->orWhereHas('periode.programStudi', function ($q) use ($search) {
        $q->where('nama_program_studi', 'like', "%{$search}%");
    });
})

            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter == 'lunas') {
                    $query->whereRaw('terbayar >= total_tagihan');
                } elseif ($this->statusFilter == 'belum_bayar') {
                    $query->where('terbayar', 0);
                } elseif ($this->statusFilter == 'sebagian') {
                    $query->where('terbayar', '>', 0)
                          ->whereRaw('terbayar < total_tagihan');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Data ringkasan untuk dashboard
        $ringkasan = [
            'total_tagihan' => $this->getTotalTagihan(),
            'total_terbayar' => $this->getTotalTerbayar(),
            'sisa_tagihan' => $this->getSisaTagihan(),
            'jumlah_periode' => Tagihan::where('user_id', $userId)->count()
        ];

        return view('livewire.users.tagihan-user', [
            'tagihan' => $tagihan,
            'ringkasan' => $ringkasan
        ]);
    }
}