<?php

namespace App\Models;

use App\Services\KwitansiService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembayarans';

    protected $fillable = [
        'user_id',
        'penerima_id',
        'tanggal_bayar',
        'jumlah',
        'cara_bayar',
        'bukti_pembayaran',
        'kwitansi',
        'status',
        'approved_at',
        'catatan',
        'kelebihan_bayar', // Tambahan untuk tabungan
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'approved_at' => 'datetime',
    ];

    // Relasi ke User (mahasiswa yang bayar)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Untuk backward compatibility
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User (penerima/admin)
    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    // Relasi N-M ke Tagihan (via Pivot)
    public function tagihans()
    {
        return $this->belongsToMany(Tagihan::class, 'pembayaran_tagihan', 'pembayaran_id', 'tagihan_id')
            ->withPivot('nominal_teralokasi')
            ->withTimestamps();
    }

    // Method untuk approve pembayaran
    public function approve($adminId)
    {
        $this->update([
            'status' => 'disetujui',
            'approved_at' => now(),
            'penerima_id' => $adminId,
        ]);

        // Update status tagihan dan hitung kelebihan
        $totalJumlahBayar = $this->jumlah;
        $kelebihanBayar = 0;

        foreach ($this->tagihans as $tagihan) {
            $nominalTeralokasi = $tagihan->pivot->nominal_teralokasi;
            $tagihan->terbayar += $nominalTeralokasi;
            
            // Update sisa tagihan
            $tagihan->sisa = $tagihan->total_tagihan - $tagihan->terbayar;
            
            // Update status tagihan
            if ($tagihan->terbayar >= $tagihan->total_tagihan) {
                $tagihan->status = 'lunas';
                $tagihan->sisa = 0;
                
                // Hitung kelebihan jika ada
                if ($tagihan->terbayar > $tagihan->total_tagihan) {
                    $kelebihanBayar += $tagihan->terbayar - $tagihan->total_tagihan;
                }
            } elseif ($tagihan->terbayar > 0) {
                $tagihan->status = 'parsial';
            }
            
            $tagihan->save();
        }

        // Simpan kelebihan bayar jika ada
        if ($kelebihanBayar > 0) {
            $this->update(['kelebihan_bayar' => $kelebihanBayar]);
            
            // TODO: Bisa ditambahkan logika untuk simpan ke tabel tabungan mahasiswa
        }

        // Generate kwitansi
        $kwitansiService = new KwitansiService();
        $kwitansiPath = $kwitansiService->generateKwitansi($this);

        $this->update([
            'kwitansi' => $kwitansiPath
        ]);
    }

    // Method untuk reject pembayaran
    public function reject($adminId, $catatan = null)
    {
        $this->update([
            'status' => 'ditolak',
            'approved_at' => now(),
            'penerima_id' => $adminId,
            'catatan' => $catatan,
        ]);
    }
}