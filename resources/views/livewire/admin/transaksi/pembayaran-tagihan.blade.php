<div>
    <div class="p-4">
        <div
            class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-1">Pembayaran Tagihan</h1>
                <p class="text-sm opacity-90">Kelola data pembayaran dan status tagihan pengguna</p>
            </div>

            <div class="flex-shrink-0">
                <img src="{{ asset('image/keuangan.png') }}" alt="Kas"
                    class="h-32 w-auto object-contain drop-shadow-md">
            </div>
        </div>

        <!-- Card untuk Filter dan Tabel -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Search dan Button Tambah -->
            <div
                class="p-4 border-b border-gray-200 flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-3 lg:space-y-0">
                <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                    <div class="relative w-full md:w-64">
                        <input type="text" placeholder="Cari mahasiswa / NIM..." wire:model.debounce.500ms="search"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <select wire:model="filterStatus"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                        <option value="">Semua Status</option>
                        <option value="menunggu">Menunggu</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                    <input type="date" wire:model="filterTanggal"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <button wire:click="showCreateModal"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Pembayaran
                </button>
            </div>

            <!-- Alert Messages -->
            {{-- @if (session()->has('success'))
                <div class="mx-4 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="mx-4 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if (session()->has('warning'))
                <div class="mx-4 mt-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif --}}

            <!-- Tabel Pembayaran -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                NIM</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Program</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nominal Bayar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cara Bayar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Penerima</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Waktu Input</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bukti</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kwitansi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pembayarans as $p)
                            <tr class="hover:bg-gray-50" wire:key="pembayaran-{{ $p->id }}">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $p->tanggal_bayar->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->user->nim }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $p->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $p->user->programStudi->nama ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach ($p->tagihans as $t)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-1 mb-1">
                                            {{ $t->periode->kode }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp
                                    {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        {{ $p->cara_bayar == 'transfer' ? 'bg-purple-100 text-purple-800' : ($p->cara_bayar == 'cash' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800') }}">
                                        {{ ucfirst($p->cara_bayar) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $p->penerima->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($p->status == 'menunggu')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu
                                        </span>
                                    @elseif($p->status == 'disetujui')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($p->bukti_pembayaran)
                                        <a href="{{ Storage::url($p->bukti_pembayaran) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-900 font-medium">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $p->catatan ? Str::limit($p->catatan, 30) : '-' }}
                                </td>
                                <!-- Kolom Kwitansi -->
<td class="px-6 py-4 whitespace-nowrap">
    @if ($p->status == 'disetujui' && $p->kwitansi)
        <a href="{{ Storage::url($p->kwitansi) }}" target="_blank"
            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm inline-flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 
                    012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 
                    01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download Kwitansi
        </a>
    @else
        <span class="text-gray-500 text-sm italic">Belum tersedia</span>
    @endif
</td>

<!-- Kolom Aksi -->
<td class="px-6 py-4 whitespace-nowrap">
    @if ($p->status == 'menunggu')
        <button wire:click="approvePembayaran({{ $p->id }})"
            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
            Setujui
        </button>
        <button wire:click="rejectPembayaran({{ $p->id }})"
            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
            Tolak
        </button>
    @elseif($p->status == 'disetujui')
        <span class="text-green-600 text-sm">✓ Selesai</span>
    @elseif($p->status == 'ditolak')
        <span class="text-red-600 text-sm">✕ Ditolak</span>
    @endif
</td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <svg class="w-12 h-12 text-gray-300 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">Tidak ada data pembayaran</p>
                                        <p class="text-gray-500 mt-1">Mulai dengan menambahkan pembayaran baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pembayarans->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form Pembayaran -->
    @if ($showModal)
        <div class="fixed inset-0 backdrop-blur-sm bg-white/30 flex items-center justify-center z-50 transition-opacity duration-300"
            wire:click.self="closeModal">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl mx-4 transform transition-all duration-300 max-h-[90vh] overflow-y-auto"
                wire:click.stop>
                <div class="flex justify-between items-center px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Tambah Pembayaran Baru</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="savePembayaran" class="px-6 py-4 space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Kolom 1 -->
                        <div class="space-y-4">
                            <!-- Tanggal Bayar -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal Bayar <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="tanggal_bayar"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('tanggal_bayar') border-red-500 @enderror">
                                @error('tanggal_bayar')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- NIM -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    NIM <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model.lazy="nim" placeholder="Masukkan NIM"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('nim') border-red-500 @enderror">
                                @error('nim')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nama Mahasiswa -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                                <input type="text" wire:model="nama_mahasiswa" readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="space-y-4">
                            <!-- Program Studi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                <input type="text" wire:model="program" readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none"
                                    value="{{ $program }}">
                            </div>

                            <!-- Jenis Tagihan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Tagihan <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="tagihan_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('tagihan_id') border-red-500 @enderror">
                                    <option value="">-- Pilih Tagihan --</option>
                                    @foreach ($tagihans as $t)
                                        <option value="{{ $t->id }}">
                                            {{ $t->periode->kode }} - Sisa: Rp
                                            {{ number_format($t->sisa, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tagihan_id')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Sisa Tagihan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sisa Tagihan</label>
                                <input type="text" value="Rp {{ number_format($sisa_tagihan ?? 0, 0, ',', '.') }}"
                                    readonly
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
                            </div>
                        </div>

                        <!-- Kolom 3 -->
                        <div class="space-y-4">
                            <!-- Nominal Bayar -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nominal Bayar <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model.lazy="nominal_bayar" placeholder="Masukkan nominal"
                                    max="{{ $max_bayar }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('nominal_bayar') border-red-500 @enderror">
                                @if ($max_bayar > 0)
                                    <small class="text-gray-500 text-xs mt-1 block">
                                        Maksimal: Rp {{ number_format($max_bayar, 0, ',', '.') }}
                                    </small>
                                @endif
                                @error('nominal_bayar')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Cara Bayar -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Cara Bayar <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="cara_bayar"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('cara_bayar') border-red-500 @enderror">
                                    <option value="">-- Pilih Cara Bayar --</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="alokasi">Alokasi</option>
                                </select>
                                @error('cara_bayar')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bukti Pembayaran -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                                <input type="file" wire:model="bukti_pembayaran"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('bukti_pembayaran') border-red-500 @enderror">
                                @error('bukti_pembayaran')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex justify-end pt-4 space-x-3 border-t">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center"
                            wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed">
                            <span wire:loading.remove wire:target="savePembayaran">
                                Simpan Pembayaran
                            </span>
                            <span wire:loading wire:target="savePembayaran" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal untuk input catatan penolakan -->
    @if ($showRejectModal)
        <div
            class="fixed inset-0 backdrop-blur-sm bg-white/30 flex items-center justify-center z-50 transition-opacity duration-300">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 transform transition-all duration-300">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">Catatan Penolakan</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                        <textarea wire:model="catatan_penolakan"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 h-24"
                            placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end px-6 py-4 space-x-3 border-t">
                    <button wire:click="$set('showRejectModal', false)"
                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button wire:click="confirmReject"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                        Tolak Pembayaran
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div wire:loading.flex class="fixed inset-0 backdrop-blur-sm bg-white/30 items-center justify-center z-40">
        <div class="bg-white rounded-lg p-4 shadow-lg">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-gray-700">Memproses...</span>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.min.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Listen for Livewire events
            Livewire.on('showSuccessMessage', (data) => {
                Toast.fire({
                    icon: 'success',
                    title: data.message || data[0]?.message || 'Berhasil!'
                });
            });

            Livewire.on('showErrorMessage', (data) => {
                Toast.fire({
                    icon: 'error',
                    title: data.message || data[0]?.message || 'Terjadi kesalahan!'
                });
            });

            // Show modal event
            Livewire.on('showCreateModal', () => {
                // Modal akan ditampilkan otomatis melalui $showModal property
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    Livewire.dispatch('closeModal');
                }
            });

            // Confirmation for approve payment
            Livewire.on('confirmApprove', (data) => {
                const paymentId = data.id || data[0]?.id;

                Swal.fire({
                    title: 'Setujui Pembayaran?',
                    text: "Pembayaran akan disetujui dan kwitansi akan dibuat.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('confirmApprove', {
                            id: paymentId
                        });
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom scrollbar for modal */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Modal animation */
        .modal-enter {
            opacity: 0;
            transform: scale(0.9);
        }

        .modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 300ms, transform 300ms;
        }

        .modal-leave {
            opacity: 1;
            transform: scale(1);
        }

        .modal-leave-active {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 300ms, transform 300ms;
        }

        /* Table hover effects */
        .hover\:bg-gray-50:hover {
            background-color: #f9fafb;
            transition: background-color 150ms ease-in-out;
        }

        /* Button hover effects */
        .transition-colors {
            transition-property: color, background-color, border-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
</div>
