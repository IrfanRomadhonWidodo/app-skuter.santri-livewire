<div>
    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 
                relative overflow-hidden flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Tagihan SPP</h1>
            <p class="text-sm opacity-90">Kelola data tagihan mahasiswa dan status pembayarannya</p>
        </div>
        <div class="flex-shrink-0">
            <img src="{{ asset('image/keuangan.png') }}" alt="Kas" class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>

    {{-- Table Tagihan --}}
    <table class="w-full border-collapse border border-gray-300">
        <thead>
    <tr class="bg-gray-100">
        <th class="border p-2">Tanggal</th>
        <th class="border p-2">NIM</th> <!-- Kolom NIM baru -->
        <th class="border p-2">Nama Mahasiswa</th>
        <th class="border p-2">Program Studi</th>
        <th class="border p-2">Periode</th>
        <th class="border p-2">Jenis Tagihan</th>
        <th class="border p-2">Nominal</th>
        <th class="border p-2">Note</th>
    </tr>
</thead>
<tbody>
    @forelse ($tagihans as $tagihan)
        <tr>
            <td class="border p-2">{{ $tagihan->created_at->format('d/m/Y') }}</td>
            <td class="border p-2">{{ $tagihan->mahasiswa->nim }}</td> <!-- NIM ditampilkan -->
            <td class="border p-2">{{ $tagihan->mahasiswa->name }}</td>
            <td class="border p-2">{{ $tagihan->mahasiswa->programStudi->nama ?? '-' }}</td>
            <td class="border p-2">{{ $tagihan->periode->kode ?? '-' }}</td>
            <td class="border p-2">SPP</td>
            <td class="border p-2">Rp {{ number_format($tagihan->total_tagihan,0,',','.') }}</td>
            <td class="border p-2">{{ ucfirst($tagihan->status) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center p-4">Belum ada tagihan</td>
        </tr>
    @endforelse
</tbody>

    </table>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $tagihans->links() }}
    </div>
</div>
