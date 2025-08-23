<div>
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Kelola SPP Program Studi</h1>
            <p class="text-sm opacity-90">Kelola data nominal SPP setiap program studi</p>
        </div>

        <div class="flex-shrink-0">
            <img src="{{ asset('image/kelola_spp.png') }}" 
                alt="Kas"
                class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>

    <h1 class="text-xl font-bold mb-4">Kelola Periode (SPP)</h1>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="space-y-3 mb-6">
        <div>
            <label class="block">Kode</label>
            <input type="text" wire:model="kode" class="border rounded w-full p-2">
            @error('kode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Program</label>
            <select wire:model="program" class="border rounded w-full p-2">
                <option value="">-- Pilih Program Studi --</option>
                <option value="Administrasi Publik">Administrasi Publik</option>
                <option value="Agroteknologi">Agroteknologi</option>
                <option value="Akuntansi">Akuntansi</option>
                <option value="Biologi">Biologi</option>
                <option value="Hukum Syariah">Hukum Syariah</option>
                <option value="Ilmu Hukum">Ilmu Hukum</option>
                <option value="Ilmu Perikanan">Ilmu Perikanan</option>
                <option value="Manajemen">Manajemen</option>
                <option value="Matematika">Matematika</option>
                <option value="Pendidikan Agama Islam">Pendidikan Agama Islam</option>
                <option value="Pendidikan Bahasa Inggris">Pendidikan Bahasa Inggris</option>
                <option value="Peternakan">Peternakan</option>
                <option value="Teknik Pertanian dan Biosistem">Teknik Pertanian dan Biosistem</option>
                <option value="Teknologi Pangan">Teknologi Pangan</option>
            </select>
            @error('program') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Nominal Default</label>
            <input type="number" wire:model="nominal_default" class="border rounded w-full p-2" step="0.01">
            @error('nominal_default') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Periode Mulai</label>
            <input type="date" wire:model="periode_mulai" class="border rounded w-full p-2">
            @error('periode_mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Periode Selesai</label>
            <input type="date" wire:model="periode_selesai" class="border rounded w-full p-2">
            @error('periode_selesai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                {{ $isEdit ? 'Update' : 'Simpan' }}
            </button>
            @if ($isEdit)
                <button type="button" wire:click="resetForm" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            @endif
        </div>
    </form>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">Kode</th>
                <th class="border p-2">Program</th>
                <th class="border p-2">Nominal Default</th>
                <th class="border p-2">Periode</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($periodes as $periode)
                <tr>
                    <td class="border p-2">{{ $periode->kode }}</td>
                    <td class="border p-2">{{ $periode->program }}</td>
                    <td class="border p-2">Rp {{ number_format($periode->nominal_default, 0, ',', '.') }}</td>
                    <td class="border p-2">
                        {{ $periode->periode_mulai ? $periode->periode_mulai->format('d/m/Y') : '-' }}
                        s/d
                        {{ $periode->periode_selesai ? $periode->periode_selesai->format('d/m/Y') : '-' }}
                    </td>
                    <td class="border p-2">
                        <button wire:click="edit({{ $periode->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="destroy({{ $periode->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-4">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-3">
        {{ $periodes->links() }}
    </div>
</div>
