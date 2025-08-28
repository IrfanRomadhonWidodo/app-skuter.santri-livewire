<?php

namespace App\Services;

use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class KwitansiService
{
    public function generateKwitansi(Pembayaran $pembayaran)
    {
        // Tentukan status berdasarkan tagihan
        $status = $this->getStatusTagihan($pembayaran);
        
        // Data untuk kwitansi
        $data = [
            'pembayaran' => $pembayaran,
            'nomor_kwitansi' => $this->generateNomorKwitansi($pembayaran),
            'tanggal_cetak' => now()->format('d F Y'),
            'terbilang' => $this->terbilang($pembayaran->jumlah),
            'status_tagihan' => $status, // Tambahan status tagihan
        ];

        // Generate PDF
        $pdf = Pdf::loadView('kwitansi.template', $data);
        $pdf->setPaper('A4', 'portrait');
        
        // Nama file
        $fileName = 'kwitansi/' . $data['nomor_kwitansi'] . '.pdf';
        
        // Simpan ke storage
        Storage::disk('public')->put($fileName, $pdf->output());
        
        return $fileName;
    }

    private function getStatusTagihan($pembayaran)
    {
        $allLunas = true;
        $hasPayment = false;

        foreach ($pembayaran->tagihans as $tagihan) {
            $hasPayment = true;
            
            // Refresh data tagihan untuk memastikan status terbaru
            $tagihan->refresh();
            
            if ($tagihan->status !== 'lunas') {
                $allLunas = false;
            }
        }

        if (!$hasPayment) {
            return 'BELUM BAYAR';
        }

        return $allLunas ? 'LUNAS' : 'PARSIAL';
    }

    private function generateNomorKwitansi(Pembayaran $pembayaran)
    {
        return 'KWT-' . $pembayaran->id . '-' . now()->format('Ymd');
    }

    private function terbilang($angka)
    {
        $huruf = [
            '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan',
            'sepuluh', 'sebelas'
        ];

        if ($angka < 12) {
            return $huruf[$angka];
        } elseif ($angka < 20) {
            return $huruf[$angka - 10] . ' belas';
        } elseif ($angka < 100) {
            return $huruf[intval($angka / 10)] . ' puluh ' . $huruf[$angka % 10];
        } elseif ($angka < 200) {
            return 'seratus ' . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $huruf[intval($angka / 100)] . ' ratus ' . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'seribu ' . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilang(intval($angka / 1000)) . ' ribu ' . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilang(intval($angka / 1000000)) . ' juta ' . $this->terbilang($angka % 1000000);
        }
        
        return 'angka terlalu besar';
    }
}