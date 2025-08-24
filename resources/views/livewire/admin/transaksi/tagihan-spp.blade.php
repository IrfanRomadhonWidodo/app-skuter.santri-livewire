<div>
    {{-- Header --}}
    <div
        class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 
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
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">NIM</th>
                    <th class="border p-2">Nama Mahasiswa</th>
                    <th class="border p-2">Program Studi</th>
                    <th class="border p-2">Periode</th>
                    <th class="border p-2">Total Tagihan</th>
                    <th class="border p-2">Terbayar</th>
                    <th class="border p-2">Sisa</th>
                    <th class="border p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tagihans as $tagihan)
                    <tr>
                        <td class="border p-2">{{ $tagihan->created_at->format('d/m/Y') }}</td>
                        <td class="border p-2">{{ $tagihan->nim }}</td>
                        <td class="border p-2">{{ $tagihan->nama_mahasiswa }}</td>
                        <td class="border p-2">{{ $tagihan->program }}</td>
                        <td class="border p-2">{{ $tagihan->periode->kode ?? '-' }}</td>
                        <td class="border p-2">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
                        <td class="border p-2">Rp {{ number_format($tagihan->terbayar, 0, ',', '.') }}</td>
                        <td class="border p-2">
                            <span
                                class="@if ($tagihan->sisa > 0) text-red-600 font-semibold @else text-green-600 @endif">
                                Rp {{ number_format($tagihan->sisa, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="border p-2">
                            @if ($tagihan->status == 'lunas')
                                <span
                                    class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Lunas</span>
                            @elseif($tagihan->status == 'parsial')
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Parsial</span>
                            @else
                                <span class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Belum
                                    Bayar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center p-4">Belum ada tagihan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $tagihans->links() }}
    </div>
</div>
