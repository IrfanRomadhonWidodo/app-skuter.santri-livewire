<?php
// filepath: app/Livewire/Users/PembayaranUser.php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranUser extends Component
{
    use WithFileUploads;

    // Form fields
    public $tanggal_bayar, $tagihan_id, $nominal_bayar, $cara_bayar, $bukti_pembayaran;
    public $sisa_tagihan, $max_bayar = 0;

    // Tagihan yang bisa dipilih oleh user yang sedang login
    public $tagihans = [];

    // Success state
    public $showSuccess = false;
    public $successMessage = '';

    public function mount()
    {
        // Set default tanggal bayar ke hari ini
        $this->tanggal_bayar = now()->format('Y-m-d');
        // Ambil tagihan user yang belum lunas
        $this->loadTagihans();
    }

    /**
     * Load tagihan milik user yang sedang login
     */
    public function loadTagihans()
    {
        $user = Auth::user();
        
        $this->tagihans = Tagihan::with(['periode'])
            ->where('user_id', $user->id)
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', '!=', 'lunas');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Ketika jenis tagihan dipilih, tampilkan sisa tagihan dan set maksimal bayar
     */
    public function updatedTagihanId($value)
    {
        $tagihan = Tagihan::find($value);
        if ($tagihan) {
            $this->sisa_tagihan = $tagihan->sisa;
            $this->max_bayar = $tagihan->sisa;
            // Reset nominal bayar ketika ganti tagihan
            $this->nominal_bayar = null;
        } else {
            $this->sisa_tagihan = 0;
            $this->max_bayar = 0;
            $this->nominal_bayar = null;
        }
    }

    /**
     * Validasi nominal bayar tidak melebihi sisa tagihan
     */
    public function updatedNominalBayar($value)
    {
        if ($value > $this->max_bayar) {
            $this->nominal_bayar = $this->max_bayar;
            session()->flash('warning', 'Nominal bayar tidak boleh melebihi sisa tagihan (Rp ' . number_format($this->max_bayar, 0, ',', '.') . ')');
        }
    }

    /**
     * Simpan pembayaran baru
     */
public function savePembayaran()
{
    $this->validate([
        'tanggal_bayar' => 'required|date|before_or_equal:today',
        'tagihan_id'    => 'required|exists:tagihans,id',
        'nominal_bayar' => [
            'required',
            'integer',
            'min:1',
            'max:' . $this->max_bayar, // Validasi maksimal sesuai sisa tagihan
        ],
        'cara_bayar' => 'required|in:transfer,cash',
        'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'tanggal_bayar.before_or_equal' => 'Tanggal bayar tidak boleh lebih dari hari ini',
        'nominal_bayar.max' => 'Nominal bayar tidak boleh melebihi sisa tagihan (Rp ' 
                                . number_format($this->max_bayar, 0, ',', '.') . ')',
        'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload',
        'bukti_pembayaran.mimes' => 'File harus berformat JPG, JPEG, PNG, atau PDF',
        'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB',
    ]);

    // Pastikan tagihan milik user yang login
    $tagihan = Tagihan::where('id', $this->tagihan_id)
        ->where('user_id', Auth::id())
        ->first();

    if (!$tagihan) {
        session()->flash('error', 'Tagihan tidak valid atau bukan milik Anda.');
        return;
    }

    // Validasi sisa tagihan mencukupi
    if ($this->nominal_bayar > $tagihan->sisa) {
        session()->flash('error', 'Nominal pembayaran melebihi sisa tagihan.');
        return;
    }

    DB::beginTransaction();

    try {
        $pembayaran = Pembayaran::create([
            'user_id'       => Auth::id(),
            'penerima_id'   => null, // biarkan null, nanti diisi admin saat verifikasi
            'tanggal_bayar' => $this->tanggal_bayar,
            'jumlah'        => $this->nominal_bayar,
            'cara_bayar'    => $this->cara_bayar,
            'bukti_pembayaran' => $this->bukti_pembayaran->store('bukti_pembayaran', 'public'),
            'status'        => 'menunggu',
        ]);

        // Alokasi ke tagihan
        $alokasi = min($this->nominal_bayar, $tagihan->sisa);
        $pembayaran->tagihans()->attach($tagihan->id, [
            'nominal_teralokasi' => $alokasi
        ]);

        DB::commit();

        // Reset form
        $this->resetForm();
        $this->loadTagihans(); // refresh list tagihan

        // Show success message
        $this->showSuccess = true;
        $this->successMessage = 'Pembayaran berhasil diajukan dan sedang menunggu verifikasi admin. Anda akan mendapat notifikasi setelah pembayaran diverifikasi.';
        
    } catch (\Throwable $e) {
        DB::rollBack();
        session()->flash('error', 'Gagal menyimpan pembayaran: ' . $e->getMessage());
    }
}


    /**
     * Reset form dan kembali ke form pembayaran
     */
    public function resetAndContinue()
    {
        $this->showSuccess = false;
        $this->successMessage = '';
        $this->resetForm();
        $this->loadTagihans();
    }

    /**
     * Reset form input
     */
    public function resetForm()
    {
        $this->tanggal_bayar = now()->format('Y-m-d');
        $this->tagihan_id = null;
        $this->sisa_tagihan = null;
        $this->nominal_bayar = null;
        $this->max_bayar = 0;
        $this->cara_bayar = null;
        $this->bukti_pembayaran = null;
        $this->resetValidation();
    }

    /**
     * Get summary data untuk display
     */
    public function getSummaryProperty()
    {
        $user = Auth::user();
        
        $tagihans = Tagihan::where('user_id', $user->id)->get();
        
        return [
             'total_tagihan' => $tagihans->sum('total_tagihan'),
            'total_dibayar' => $tagihans->sum('terbayar'),
            'total_sisa' => $tagihans->sum('sisa'),
            'lunas' => $tagihans->where('status', 'lunas')->count(),
            'belum_lunas' => $tagihans->where('status', '!=', 'lunas')->count(),
        ];
    }

    /**
     * Render view
     */
    public function render()
    {
        return view('livewire.users.pembayaran-user');
    }
}