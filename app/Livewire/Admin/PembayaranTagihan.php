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
use Illuminate\Support\Facades\Log;

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

    // Approval fields
    public $approve_id = null;
    public $catatan_penolakan = '';
    public $showRejectModal = false;
    public $rejectPembayaranId = null;

    /**
     * Ketika NIM diubah, ambil data mahasiswa & tagihan
     */
    public function updatedNim($value)
    {
        $user = User::with(['programStudi', 'tagihans'])->where('nim', $value)->first();

        if ($user) {
            $this->user_id = $user->id;
            $this->nama_mahasiswa = $user->name;
            $this->program = $user->programStudi ? $user->programStudi->nama : '-';

            // Ambil semua tagihan mahasiswa ini yang belum lunas dan program studinya sesuai
            $this->tagihans = Tagihan::with(['periode.programStudi'])
                ->where('user_id', $user->id)
                ->whereHas('periode', function ($q) use ($user) {
                    $q->where('program_studi_id', $user->program_studi_id);
                })
                ->where(function ($q) {
                    $q->whereNull('status')
                        ->orWhere('status', '!=', 'lunas');
                })
                ->get();

            Log::info('Tagihan retrieved for user: ' . $user->id, [
                'tagihans' => $this->tagihans
            ]);
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
        $this->validate([
            'tanggal_bayar' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'tagihan_id' => 'required|exists:tagihans,id',
            'nominal_bayar' => 'required|numeric|min:1',
            'cara_bayar' => 'required|in:tunai,transfer,kartu',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

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

            DB::commit();

            $this->resetForm();
            session()->flash('success', 'Pembayaran berhasil ditambahkan dan menunggu persetujuan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Approve pembayaran
     */
    public function approvePembayaran($id)
    {
        DB::beginTransaction();

        try {
            $pembayaran = Pembayaran::findOrFail($id);
            $pembayaran->approve(Auth::id());

            DB::commit();
            session()->flash('success', 'Pembayaran berhasil disetujui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyetujui pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Reject pembayaran
     */
    public function rejectPembayaran($id)
    {
        $this->rejectPembayaranId = $id;
        $this->catatan_penolakan = '';
        $this->showRejectModal = true;

    }

    public function confirmReject()
    {
        DB::beginTransaction();
        
        try {
            $pembayaran = Pembayaran::findOrFail($this->rejectPembayaranId);
            $pembayaran->reject(Auth::id(), $this->catatan_penolakan);
            
            DB::commit();
            $this->showRejectModal = false;
            $this->catatan_penolakan = '';
            Log::info('Rejecting pembayaran ID: ' . $this->rejectPembayaranId, [
                'catatan_penolakan' => $this->catatan_penolakan
            ]);
            session()->flash('success', 'Pembayaran berhasil ditolak.');
        } catch (\Throwable $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menolak pembayaran: ' . $e->getMessage());
            Log::error('Error rejecting pembayaran ID: ' . $this->rejectPembayaranId, [
                'error' => $e->getMessage()
            ]);
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
        $query = Pembayaran::with(['user', 'penerima', 'tagihans.periode.programStudi']);

        if ($this->search) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('nim', 'like', '%' . $this->search . '%'));
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterTanggal) {
            $query->whereDate('tanggal_bayar', $this->filterTanggal);
        }

        $pembayarans = $query->orderBy('tanggal_bayar', 'desc')->paginate(10);

        return view('livewire.admin.transaksi.pembayaran-tagihan', [
            'pembayarans' => $pembayarans,
        ]);
    }
}
