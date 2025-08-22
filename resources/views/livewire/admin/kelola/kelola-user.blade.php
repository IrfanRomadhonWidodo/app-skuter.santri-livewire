<div>
    <div class="p-4">
        <!-- Header dengan Card -->
        <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-2xl font-bold mb-2">Kelola Pengguna</h1>
        </div>

    <!-- Card untuk Form dan Tabel -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Search dan Button Tambah -->
        <div class="p-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
            <div class="relative w-full md:w-64">
                <input 
                    type="text" 
                    placeholder="Cari pengguna..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                    wire:model.live.debounce.300ms="search"
                >
                <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <button 
                wire:click="showCreateModal"
                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg flex items-center transition-colors"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah User
            </button>
        </div>

        <!-- Tabel User -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50" wire:key="user-{{ $user->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->nim ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->program ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $user->role == 'admin' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button 
                                    wire:click="edit({{ $user->id }})" 
                                    class="text-yellow-600 hover:text-yellow-900 mr-3 transition-colors"
                                >
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button 
                                    wire:click="confirmDelete({{ $user->id }})" 
                                    class="text-red-600 hover:text-red-900 transition-colors"
                                >
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900">Tidak ada data pengguna</p>
                                    <p class="text-gray-500 mt-1">Mulai dengan menambahkan pengguna baru</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
    <div class="fixed inset-0 backdrop-blur-sm bg-white/30 flex items-center justify-center z-50 transition-opacity duration-300" 
        wire:click.self="closeModal">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl mx-4 transform transition-all duration-300" 
            wire:click.stop>
            <div class="flex justify-between items-center px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ $isEdit ? 'Edit User' : 'Tambah User' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="px-6 py-4 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- KIRI -->
                    <div class="space-y-4">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="name" placeholder="Nama lengkap"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('name') border-red-500 @enderror">
                            @error('name') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- NIM -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                            <input type="text" wire:model="nim" placeholder="Nomor Induk Mahasiswa"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('nim') border-red-500 @enderror">
                            @error('nim') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Program Studi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                            <input type="text" wire:model="program" placeholder="Program studi"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('program') border-red-500 @enderror">
                            @error('program') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="space-y-4">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" wire:model="email" placeholder="Alamat email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('email') border-red-500 @enderror">
                            @error('email') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Password 
                                @if($isEdit)
                                    <span class="text-gray-500 text-xs">(biarkan kosong jika tidak diubah)</span>
                                @else
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <input type="password" wire:model="password" placeholder="Password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('password') border-red-500 @enderror">
                            @error('password') 
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="role"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('role') border-red-500 @enderror">
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') 
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
                        <span wire:loading.remove wire:target="{{ $isEdit ? 'update' : 'store' }}">
                            {{ $isEdit ? 'Update' : 'Simpan' }}
                        </span>
                        <span wire:loading wire:target="{{ $isEdit ? 'update' : 'store' }}" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ $isEdit ? 'Updating...' : 'Menyimpan...' }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <!-- Loading Overlay -->
    <div wire:loading.flex class="fixed inset-0 backdrop-blur-sm bg-white/30 items-center justify-center z-40">
        <div class="bg-white rounded-lg p-4 shadow-lg">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
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

            // Confirmation dialog for delete
            Livewire.on('confirmDelete', (data) => {
                const userId = data.id || data[0]?.id;
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#dc2626',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteUser', {id: userId});
                    }
                });
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    Livewire.dispatch('closeModal');
                }
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
    </style>
</div>