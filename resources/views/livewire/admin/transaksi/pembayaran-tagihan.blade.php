<div class="space-y-6">

    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
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
        @if(session()->has('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label>Tanggal Bayar</label>
        <input type="date" wire:model="tanggal_bayar" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label>NIM</label>
        <input type="text" wire:model.lazy="nim" placeholder="Masukkan NIM" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label>Nama Mahasiswa</label>
        <input type="text" wire:model="nama_mahasiswa" readonly class="w-full border px-3 py-2 rounded bg-gray-100">
    </div>
    <div>
        <label>Program Studi</label>
        <input type="text" wire:model="program" readonly class="w-full border px-3 py-2 rounded bg-gray-100">
    </div>
    <div>
        <label>Jenis Tagihan</label>
<select wire:model="tagihan_id" class="w-full border px-3 py-2 rounded">
    <option value="">-- Pilih Tagihan --</option>
    @foreach($tagihans as $t)
        <option value="{{ $t->id }}">
            {{ $t->periode->kode }}
            (Rp {{ number_format($t->total_tagihan - $t->terbayar, 0, ',', '.') }})
        </option>
    @endforeach
</select>

    </div>
<div>
    <label>Sisa Tagihan</label>
    <input type="text"
           value="Rp {{ number_format($sisa_tagihan ?? 0, 0, ',', '.') }}"
           readonly
           class="w-full border px-3 py-2 rounded bg-gray-100">
</div>


    <div>
        <label>Nominal Bayar</label>
        <input type="number" wire:model="nominal_bayar" class="w-full border px-3 py-2 rounded">
    </div>
    <div>
        <label>Cara Bayar</label>
        <select wire:model="cara_bayar" class="w-full border px-3 py-2 rounded">
            <option value="">-- Pilih Cara Bayar --</option>
            <option value="transfer">Transfer</option>
            <option value="cash">Cash</option>
            <option value="alokasi">Alokasi/Parsial</option>
        </select>
    </div>
    <div>
        <label>Bukti Pembayaran</label>
        <input type="file" wire:model="bukti_pembayaran" class="w-full border px-3 py-2 rounded">
    </div>
</div>

<button wire:click="savePembayaran" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mt-4">Simpan Pembayaran</button>

    </div>

    {{-- Filter & Tabel --}}
    <div class="flex flex-wrap gap-4 items-center mt-6">
        <input type="text" placeholder="Cari mahasiswa / NIM..." wire:model.debounce.500ms="search" class="px-4 py-2 rounded-lg border">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Jenis Tagihan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nominal Bayar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Cara Bayar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Penerima</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Waktu Input</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Bukti</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kwitansi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pembayarans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->tanggal_bayar }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->user->nim }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->user->program }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach($p->tagihans as $t)
                                <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                    {{ $t->periode->tahun }}-{{ $t->periode->semester }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($p->jumlah,0,',','.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $p->cara_bayar }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->penerima->name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->created_at->format('d-m-Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($p->bukti_pembayaran)
                                <a href="{{ Storage::url($p->bukti_pembayaran) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($p->kwitansi)
                                <a href="{{ Storage::url($p->kwitansi) }}" target="_blank" class="text-green-600 hover:underline">Kwitansi</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <button wire:click="edit({{ $p->id }})" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">Edit</button>
                            <button wire:click="delete({{ $p->id }})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="px-6 py-4 text-center text-gray-500">Belum ada pembayaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $pembayarans->links() }}
    </div>
</div>
