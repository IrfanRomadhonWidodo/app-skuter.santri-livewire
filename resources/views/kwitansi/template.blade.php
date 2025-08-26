{{-- filepath: resources/views/kwitansi/template.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        
        .kwitansi-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        
        .header p {
            margin: 2px 0;
            font-size: 11px;
        }
        
        .kwitansi-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .kwitansi-info div {
            width: 48%;
        }
        
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .detail-table td {
            padding: 8px;
            vertical-align: top;
        }
        
        .detail-table .label {
            width: 150px;
            font-weight: bold;
        }
        
        .detail-table .colon {
            width: 20px;
            text-align: center;
        }
        
        .amount-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 20px 0;
            background-color: #f9f9f9;
        }
        
        .amount-box .nominal {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .amount-box .terbilang {
            font-style: italic;
            text-transform: capitalize;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        
        .signature-box {
            width: 30%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(0, 0, 0, 0.1);
            z-index: -1;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="watermark">LUNAS</div>
    
    <div class="kwitansi-container">
        <!-- Header -->
        <div class="header">
            <h1>Kwitansi Pembayaran</h1>
            <h2>Universitas Nahdlatul Ulama</h2>
            <p>Jl. Taman Siswa No. 09, Tahunan, Jepara, Jawa Tengah 59427</p>
            <p>Telp: (0291) 591717 | Email: info@unu.ac.id</p>
        </div>

        <!-- Info Kwitansi -->
        <div style="display: table; width: 100%; margin-bottom: 20px;">
            <div style="display: table-cell; width: 50%;">
                <strong>No. Kwitansi:</strong> {{ $nomor_kwitansi }}<br>
                <strong>Tanggal:</strong> {{ $tanggal_cetak }}
            </div>
            <div style="display: table-cell; width: 50%; text-align: right;">
                <strong>Status:</strong> <span style="color: green; font-weight: bold;">LUNAS</span>
            </div>
        </div>

        <!-- Detail Pembayaran -->
        <table class="detail-table">
            <tr>
                <td class="label">Sudah terima dari</td>
                <td class="colon">:</td>
                <td><strong>{{ $pembayaran->user->name }}</strong></td>
            </tr>
            <tr>
                <td class="label">NIM</td>
                <td class="colon">:</td>
                <td>{{ $pembayaran->user->nim }}</td>
            </tr>
            <tr>
                <td class="label">Program Studi</td>
                <td class="colon">:</td>
                <td>{{ $pembayaran->user->programStudi->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Untuk pembayaran</td>
                <td class="colon">:</td>
                <td>
                    @foreach($pembayaran->tagihans as $tagihan)
                        SPP {{ $tagihan->periode->kode }}
                        @if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="label">Cara Pembayaran</td>
                <td class="colon">:</td>
                <td style="text-transform: capitalize;">{{ $pembayaran->cara_bayar }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Bayar</td>
                <td class="colon">:</td>
                <td>{{ $pembayaran->tanggal_bayar->format('d F Y') }}</td>
            </tr>
        </table>

        <!-- Nominal -->
        <div class="amount-box">
            <div class="nominal">
                Jumlah: Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
            </div>
            <div class="terbilang">
                Terbilang: {{ $terbilang }} rupiah
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div style="display: table; width: 100%; margin-top: 40px;">
            <div style="display: table-cell; width: 33%; text-align: center;">
                <div>Yang Menerima,</div>
                <div style="margin-top: 60px; border-top: 1px solid #000; padding-top: 5px;">
                    <strong>{{ $pembayaran->penerima->name ?? 'Admin' }}</strong><br>
                    <small>Petugas Keuangan</small>
                </div>
            </div>
            <div style="display: table-cell; width: 33%; text-align: center;">
                <!-- Kosong -->
            </div>
            <div style="display: table-cell; width: 33%; text-align: center;">
                <div>Yang Membayar,</div>
                <div style="margin-top: 60px; border-top: 1px solid #000; padding-top: 5px;">
                    <strong>{{ $pembayaran->user->name }}</strong><br>
                    <small>{{ $pembayaran->user->nim }}</small>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Kwitansi ini sah dan dikeluarkan secara otomatis oleh sistem.</p>
            <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>