<div>
    <div class="p-4">
        <div
            class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-1">Tagihan SPP</h1>
                <p class="text-sm opacity-90">Kelola data tagihan mahasiswa dan status pembayarannya</p>
            </div>

            <div class="flex-shrink-0">
                <img src="{{ asset('image/keuangan.png') }}" alt="Tagihan SPP"
                    class="h-32 w-auto object-contain drop-shadow-md">
            </div>
        </div>

        <!-- Summary Cards (Optional Enhancement) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Tagihan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $tagihans->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Lunas</p>
                        <p class="text-lg font-semibold text-green-600">
                            {{ $tagihans->where('status', 'lunas')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Belum Bayar</p>
                        <p class="text-lg font-semibold text-red-600">
                            {{ $tagihans->where('status', '')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card untuk Tabel -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header Tabel -->
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Tagihan SPP</h2>
                <p class="text-sm text-gray-600 mt-1">Informasi lengkap tagihan dan status pembayaran mahasiswa</p>
            </div>

            <!-- Tabel Tagihan -->
            <div class="overflow-x-auto">
                <table class="w-full">
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
                                <td class="border p-2">{{ $tagihan->periode?->kode ?? '-' }}</td>
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
                                        <span
                                            class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Belum
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

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tagihans->links() }}
            </div>
        </div>
    </div>
</div>
