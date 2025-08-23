<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PembayaranTagihan extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    // Form fields
    public $tanggal_bayar, $nim, $user_id, $nama_mahasiswa, $program, $tagihan_id;
    public $sisa_tagihan, $nominal_bayar, $cara_bayar, $bukti_pembayaran;

    public $search = '', $filterStatus = '', $filterTanggal = '';

    // Edit state
    public $edit_id = null;

    // Tagihan yang bisa dipilih
    public $tagihans = [];

    /**
     * Ketika NIM diubah, ambil data mahasiswa & tagihan
     */
    public function updatedNim($value)
{
    $user = User::where('nim', $value)->first();

    if ($user) {
        $this->user_id = $user->id;
        $this->nama_mahasiswa = $user->name;
        $this->program = $user->program;

        // ambil semua tagihan mahasiswa ini yang belum lunas
        $this->tagihans = Tagihan::with(['periode' => function($q) {
        $q->select('id','kode','nominal_default');
    }])
    ->where('user_id', $user->id)
    ->where(function($q) {
        $q->whereNull('status')
          ->orWhere('status', '!=', 'lunas');
    })
    ->get();

    } else {
        $this->reset(['user_id', 'nama_mahasiswa', 'program']);
        $this->tagihans = collect();
    }
}




    /**
     * Ketika jenis tagihan dipilih, tampilkan sisa tagihan
     */
    public function updatedTagihanId($value)
{
    $tagihan = Tagihan::find($value);
    $this->sisa_tagihan = $tagihan?->sisa ?? 0;
}

    /**
     * Simpan pembayaran baru
     */
    public function savePembayaran()
{
    DB::beginTransaction();

    try {
        $pembayaran = Pembayaran::create([
            'user_id'       => $this->user_id,
            'penerima_id'   => Auth::id(),
            'tanggal_bayar' => $this->tanggal_bayar,
            'jumlah'        => $this->nominal_bayar,
            'cara_bayar'    => $this->cara_bayar,
            'bukti_pembayaran' => $this->bukti_pembayaran 
                ? $this->bukti_pembayaran->store('bukti_pembayaran', 'public') 
                : null,
            'status' => 'menunggu',
        ]);

        // Alokasi tagihan
        $tagihan = Tagihan::find($this->tagihan_id);
        $alokasi = min($this->nominal_bayar, $tagihan->total_tagihan - $tagihan->terbayar);

        $pembayaran->tagihans()->attach($tagihan->id, [
            'nominal_teralokasi' => $alokasi
        ]);

        $tagihan->terbayar += $alokasi;
        $tagihan->status = $tagihan->terbayar >= $tagihan->total_tagihan ? 'lunas' : 'parsial';
        $tagihan->save();

        DB::commit();

        $this->resetForm();
        session()->flash('success', 'Pembayaran berhasil ditambahkan.');

    } catch (\Throwable $e) {
        DB::rollBack();
        session()->flash('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage());
    }
}


    /**
     * Reset form input
     */
    public function resetForm()
    {
        $this->tanggal_bayar = null;
        $this->nim = null;
        $this->user_id = null;
        $this->nama_mahasiswa = '';
        $this->program = '';
        $this->tagihan_id = null;
        $this->sisa_tagihan = null;
        $this->nominal_bayar = null;
        $this->cara_bayar = null;
        $this->bukti_pembayaran = null;
        $this->tagihans = collect();
    }

    /**
     * Render table dengan filter
     */
    public function render()
    {
        $query = Pembayaran::with(['user','penerima','tagihans']);

        if ($this->search) {
            $query->whereHas('user', fn($q) => $q->where('name','like','%'.$this->search.'%')
                                                   ->orWhere('nim','like','%'.$this->search.'%'));
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterTanggal) {
            $query->whereDate('tanggal_bayar', $this->filterTanggal);
        }

        $pembayarans = $query->orderBy('tanggal_bayar','desc')->paginate(10);

        return view('livewire.admin.transaksi.pembayaran-tagihan', [
            'pembayarans' => $pembayarans,
        ]);
    }
}
