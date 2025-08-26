<!-- Single root element wrapper -->
<div>
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Tagihan Mahasiswa</h1>
            <p class="text-sm opacity-90">Selamat Datang di Aplikasi Skuter Santri</p>
        </div>

        <div class="flex-shrink-0">
            <img src="{{ asset('image/kas.png') }}" 
                alt="Kas"
                class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>

<!-- Ringkasan Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

        <!-- Total Tagihan -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Tagihan</h3>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($ringkasan['total_tagihan'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Total Terbayar -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Terbayar</h3>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($ringkasan['total_terbayar'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Sisa Tagihan -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Sisa Tagihan</h3>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($ringkasan['sisa_tagihan'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Tagihan</label>
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Cari berdasarkan periode atau program studi..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            
            <div class="md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                <select wire:model.live="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Status</option>
                    <option value="belum_bayar">Belum Bayar</option>
                    <option value="sebagian">Alokasi</option>
                    <option value="lunas">Lunas</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabel Tagihan -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-green-50 border-b border-green-200">
            <h3 class="text-lg font-semibold text-green-800">Daftar Tagihan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program Studi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terbayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tagihan as $item)
                        @php
                            $sisa = $item->total_tagihan - $item->terbayar;
                            $statusBadge = $this->getStatusBadge($item);
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $item->periode->nama_periode ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->periode->programStudi->nama_program_studi ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                Rp {{ number_format($item->terbayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $sisa > 0 ? 'text-red-600' : 'text-green-600' }}">
                                Rp {{ number_format($sisa, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusBadge['class'] }}">
                                    {{ $statusBadge['text'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button 
                                    wire:click="showDetail({{ $item->id }})"
                                    class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-lg transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg mb-1">Tidak ada tagihan ditemukan</p>
                                    <p class="text-gray-400 text-sm">Coba ubah kata kunci pencarian atau filter</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tagihan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tagihan->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail -->
    @if($showDetailModal && $selectedTagihan)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeDetail"></div>
                
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">Detail Tagihan</h3>
                            <button wire:click="closeDetail" class="text-white hover:text-gray-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-6 py-4">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Periode</dt>
                                <dd class="text-lg text-gray-900">{{ $selectedTagihan->periode->nama_periode ?? 'N/A' }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Program Studi</dt>
                                <dd class="text-lg text-gray-900">{{ $selectedTagihan->periode->programStudi->nama_program_studi ?? 'N/A' }}</dd>
                            </div>
                            
                            <div class="border-t pt-4">
                                <dt class="text-sm font-medium text-gray-500">Total Tagihan</dt>
                                <dd class="text-2xl font-bold text-gray-900">Rp {{ number_format($selectedTagihan->total_tagihan, 0, ',', '.') }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sudah Terbayar</dt>
                                <dd class="text-2xl font-bold text-green-600">Rp {{ number_format($selectedTagihan->terbayar, 0, ',', '.') }}</dd>
                            </div>
                            
                            <div class="border-t pt-4">
                                @php $sisaDetail = $selectedTagihan->total_tagihan - $selectedTagihan->terbayar; @endphp
                                <dt class="text-sm font-medium text-gray-500">Sisa Tagihan</dt>
                                <dd class="text-2xl font-bold {{ $sisaDetail > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    Rp {{ number_format($sisaDetail, 0, ',', '.') }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                                <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($selectedTagihan->created_at)->format('d F Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4">
                        <button 
                            wire:click="closeDetail" 
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>