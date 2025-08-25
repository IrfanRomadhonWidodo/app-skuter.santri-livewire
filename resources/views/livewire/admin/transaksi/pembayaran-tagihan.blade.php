<div class="space-y-6">

    {{-- Header --}}
    <div
        class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Pembayaran Tagihan</h1>
            <p class="text-sm opacity-90">Kelola data pembayaran dan status tagihan pengguna</p>
        </div>
        <div class="flex-shrink-0">
            <img src="{{ asset('image/keuangan.png') }}" alt="Kas" class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>

    {{-- Form Input Pembayaran --}}
    <div class="bg-white p-6 rounded-lg shadow space-y-4">
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar</label>
                <input type="date" wire:model="tanggal_bayar"
                    class="w-full border px-3 py-2 rounded @error('tanggal_bayar') border-red-500 @enderror">
                @error('tanggal_bayar')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input type="text" wire:model.lazy="nim" placeholder="Masukkan NIM"
                    class="w-full border px-3 py-2 rounded @error('nim') border-red-500 @enderror">
                @error('nim')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                <input type="text" wire:model="nama_mahasiswa" readonly
                    class="w-full border px-3 py-2 rounded bg-gray-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                <input type="text" wire:model="program" readonly class="w-full border px-3 py-2 rounded bg-gray-100"
                    value="{{ $program }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Tagihan</label>
                <select wire:model="tagihan_id"
                    class="w-full border px-3 py-2 rounded @error('tagihan_id') border-red-500 @enderror">
                    <option value="">-- Pilih Tagihan --</option>
                    @foreach ($tagihans as $t)
                        <option value="{{ $t->id }}">
                            {{ $t->periode->kode }} - Sisa: Rp {{ number_format($t->sisa, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('tagihan_id')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sisa Tagihan</label>
                <input type="text" value="Rp {{ number_format($sisa_tagihan ?? 0, 0, ',', '.') }}" readonly
                    class="w-full border px-3 py-2 rounded bg-gray-100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal Bayar</label>
                <input type="number" wire:model="nominal_bayar"
                    class="w-full border px-3 py-2 rounded @error('nominal_bayar') border-red-500 @enderror">
                @error('nominal_bayar')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cara Bayar</label>
                <select wire:model="cara_bayar"
                    class="w-full border px-3 py-2 rounded @error('cara_bayar') border-red-500 @enderror">
                    <option value="">-- Pilih Cara Bayar --</option>
                    <option value="transfer">Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="alokasi">Alokasi</option>
                </select>
                @error('cara_bayar')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran</label>
                <input type="file" wire:model="bukti_pembayaran"
                    class="w-full border px-3 py-2 rounded @error('bukti_pembayaran') border-red-500 @enderror">
                @error('bukti_pembayaran')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button wire:click="savePembayaran" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mt-4"
            wire:loading.attr="disabled">
            <span wire:loading.remove>Simpan Pembayaran</span>
            <span wire:loading>Menyimpan...</span>
        </button>
    </div>

    {{-- Filter & Tabel --}}
    <div class="flex flex-wrap gap-4 items-center mt-6">
        <input type="text" placeholder="Cari mahasiswa / NIM..." wire:model.debounce.500ms="search"
            class="px-4 py-2 rounded-lg border">
        <select wire:model="filterStatus" class="px-4 py-2 rounded-lg border">
            <option value="">Semua Status</option>
            <option value="menunggu">Menunggu</option>
            <option value="disetujui">Disetujui</option>
            <option value="ditolak">Ditolak</option>
        </select>
        <input type="date" wire:model="filterTanggal" class="px-4 py-2 rounded-lg border">
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg mt-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-green-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">NIM</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nominal Bayar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Cara Bayar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Bukti</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pembayarans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->tanggal_bayar->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->user->nim }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->user->program }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($p->tagihans as $t)
                                <span
                                    class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                    {{ $t->periode->kode }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $p->cara_bayar }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($p->status == 'menunggu')
                                <span
                                    class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Menunggu</span>
                            @elseif($p->status == 'disetujui')
                                <span
                                    class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Disetujui</span>
                            @else
                                <span
                                    class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($p->bukti_pembayaran)
                                <a href="{{ Storage::url($p->bukti_pembayaran) }}" target="_blank"
                                    class="text-blue-600 hover:underline">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
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
                                @if ($p->kwitansi)
                                    <a href="{{ Storage::url($p->kwitansi) }}" target="_blank"
                                        class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                        Kwitansi
                                    </a>
                                @endif
                                <span class="text-green-600 text-sm">✓ Selesai</span>
                            @else
                                <span class="text-red-600 text-sm">✗ Ditolak</span>
                                @if ($p->catatan)
                                    <div class="text-xs text-gray-500 mt-1">{{ $p->catatan }}</div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-4 text-center text-gray-500">Belum ada pembayaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $pembayarans->links() }}
    </div>

    {{-- Modal untuk input catatan penolakan --}}
    @if ($showRejectModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">Catatan Penolakan</h3>
                <textarea wire:model="catatan_penolakan" class="w-full border px-3 py-2 rounded h-24"
                    placeholder="Masukkan alasan penolakan..."></textarea>
                <div class="flex justify-end gap-2 mt-4">
                    <button wire:click="$set('showRejectModal', false)"
                        class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button wire:click="confirmReject" class="px-4 py-2 bg-red-600 text-white rounded">Tolak</button>
                </div>
            </div>
        </div>
    @endif
