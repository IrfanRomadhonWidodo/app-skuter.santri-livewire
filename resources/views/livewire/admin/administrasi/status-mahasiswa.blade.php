<div>
    {{-- Header --}}
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Status Mahasiswa</h1>
            <p class="text-sm opacity-90">Kelola data status mahasiswa</p>
        </div>
        <div class="flex-shrink-0">
            <img src="{{ asset('image/keuangan.png') }}" alt="Status" class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">NIM</th>
                    <th class="px-6 py-3">Program</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statuses as $row)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $row->user->name }}</td>
                        <td class="px-6 py-4">{{ $row->user->nim ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $row->user->program ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($editingId === $row->id)
                                <input type="text" wire:model="keterangan" class="border rounded px-2 py-1 w-full" placeholder="Tulis keterangan...">
                            @else
                                {{ $row->keterangan ?? '-' }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($editingId === $row->id)
                                <select wire:model="status" class="border rounded px-2 py-1">
                                    @foreach($statusOptions as $option)
                                        <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs
                                    @if($row->status === 'aktif') bg-green-100 text-green-700
                                    @elseif($row->status === 'cuti') bg-yellow-100 text-yellow-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ ucfirst($row->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($editingId === $row->id)
                                <button wire:click="update" class="px-3 py-1 bg-green-600 text-white rounded">Simpan</button>
                            @else
                                <button wire:click="edit({{ $row->id }})" class="px-3 py-1 bg-blue-600 text-white rounded">Edit</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $statuses->links() }}
        </div>
    </div>
</div>
