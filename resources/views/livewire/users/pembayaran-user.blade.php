<div>
    <div class="min-h-screen bg-gradient-to-br p-4">
        <!-- Header dengan Gradient -->
 <!-- Header Banner -->
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Pembayaran Tagihan</h1>
            <p class="text-sm opacity-90">Lakukan pembayaran tagihan mahasiswa</p>
        </div>

        <div class="flex-shrink-0">
            <img src="{{ asset('image/kas.png') }}" 
                alt="Kas"
                class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>


        @if ($showSuccess)
            <!-- Success State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 p-6 text-center">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-white mb-2">Pembayaran Berhasil Dikirim!</h2>
                        <p class="text-green-100">{{ $successMessage }}</p>
                    </div>
                    
                    <div class="p-6 text-center">
                        <div class="space-y-4">
                            <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                                <div class="flex items-center justify-center mb-3">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="font-semibold text-green-800 mb-2">Status Pembayaran</h3>
                                <p class="text-green-700 text-sm">
                                    Pembayaran Anda sedang dalam proses verifikasi oleh admin. 
                                    Anda akan mendapat notifikasi melalui email setelah verifikasi selesai.
                                </p>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <button wire:click="resetAndContinue" 
                                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl font-medium transition-all transform hover:scale-105 shadow-lg">
                                    Bayar Tagihan Lain
                                </button>
                                <a href="{{ route('dashboard') }}" 
                                   class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors">
                                    Kembali ke Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-emerald-100 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Dibayar</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($this->summary['total_dibayar'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-xl">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.767 0L3.047 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Sisa Tagihan</p>
                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($this->summary['total_sisa'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-teal-500">
                    <div class="flex items-center">
                        <div class="p-3 bg-teal-100 rounded-xl">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Status Lunas</p>
                            <p class="text-xl font-bold text-gray-900">{{ $this->summary['lunas'] }}/{{ $this->summary['lunas'] + $this->summary['belum_lunas'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pembayaran -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <!-- Header Form -->
                    <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Form Pembayaran</h2>
                                <p class="text-green-100">Isi formulir di bawah untuk melakukan pembayaran tagihan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Messages -->
                    @if (session()->has('success'))
                        <div class="mx-6 mt-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl" role="alert">
                            <div class="flex">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="mx-6 mt-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl" role="alert">
                            <div class="flex">
                                <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif
                    @if (session()->has('warning'))
                        <div class="mx-6 mt-6 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl" role="alert">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('warning') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Form Content -->
                    <form wire:submit.prevent="savePembayaran" class="p-6 space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Tanggal Bayar -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Tanggal Bayar <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="date" wire:model="tanggal_bayar" 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition-colors @error('tanggal_bayar') border-red-300 @enderror">
                                    @error('tanggal_bayar')
                                        <span class="text-red-500 text-sm mt-1 block flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Jenis Tagihan -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Pilih Tagihan <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <select wire:model="tagihan_id" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition-colors @error('tagihan_id') border-red-300 @enderror">
                                        <option value="">-- Pilih Tagihan yang Akan Dibayar --</option>
                                        @foreach ($tagihans as $t)
                                            @if ($t->sisa > 0)
                                                <option value="{{ $t->id }}">
                                                    {{ $t->periode->kode }} - Sisa: Rp {{ number_format($t->sisa, 0, ',', '.') }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('tagihan_id')
                                        <span class="text-red-500 text-sm mt-1 block flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                

                                <!-- Nominal Bayar -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Nominal Bayar <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                   <input type="number" 
       wire:model.defer="nominal_bayar"
       placeholder="Masukkan nominal pembayaran"
       max="{{ $max_bayar }}"
       min="1"
       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition-colors @error('nominal_bayar') border-red-300 @enderror">

                                    @if ($max_bayar > 0)
                                        <small class="text-gray-600 text-sm mt-1 block" wire:ignore>
    Maksimal: Rp {{ number_format($max_bayar, 0, ',', '.') }}
</small>

                                    @endif
                                    @error('nominal_bayar')
                                        <span class="text-red-500 text-sm mt-1 block flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Cara Bayar -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            Metode Pembayaran <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <select wire:model="cara_bayar" 
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-green-500 transition-colors @error('cara_bayar') border-red-300 @enderror">
                                        <option value="">-- Pilih Metode Pembayaran --</option>
                                        <option value="transfer"> Transfer Bank</option>
                                        <option value="cash"> Bayar Tunai</option>
                                        <option value="alokasi"> Alokasi</option>
                                    </select>
                                    @error('cara_bayar')
                                        <span class="text-red-500 text-sm mt-1 block flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Bukti Pembayaran -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            Upload Bukti Pembayaran <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="file" wire:model="bukti_pembayaran" 
                                               class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:outline-none focus:border-green-500 transition-colors cursor-pointer @error('bukti_pembayaran') border-red-300 @enderror"
                                               accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <small class="text-gray-600 text-sm mt-1 block">Format: JPG, JPEG, PNG, PDF (Maksimal: 2MB)</small>
                                    @error('bukti_pembayaran')
                                        <span class="text-red-500 text-sm mt-1 block flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Info Loading Upload -->
                                <div wire:loading wire:target="bukti_pembayaran" class="text-green-600 text-sm flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengupload file...
                                </div>
                            </div>
                        </div>

                        <!-- Info Pembayaran Transfer -->
                        @if ($cara_bayar == 'transfer')
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-bold text-green-800 mb-3">Informasi Rekening Transfer</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="bg-white rounded-xl p-4 border border-green-100">
                                                <p class="text-sm text-gray-600 mb-1">Bank</p>
                                                <p class="font-bold text-gray-900">Bank Central Asia (BCA)</p>
                                            </div>
                                            <div class="bg-white rounded-xl p-4 border border-green-100">
                                                <p class="text-sm text-gray-600 mb-1">Nomor Rekening</p>
                                                <p class="font-bold text-gray-900 text-lg">1234567890</p>
                                            </div>
                                            <div class="bg-white rounded-xl p-4 border border-green-100 md:col-span-2">
                                                <p class="text-sm text-gray-600 mb-1">Atas Nama</p>
                                                <p class="font-bold text-gray-900">Yayasan Pendidikan Skuter Santri</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 p-3 bg-green-100 rounded-xl">
                                            <p class="text-sm text-green-800">
                                                <strong>Penting:</strong> Pastikan upload bukti transfer yang jelas dan lengkap setelah melakukan pembayaran.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tombol Submit -->
                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" wire:click="resetForm" 
                                    class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all font-medium">
                                Reset Form
                            </button>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl focus:outline-none focus:ring-4 focus:ring-green-300 font-semibold transition-all transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                    wire:loading.attr="disabled" 
                                    wire:loading.class="opacity-50 cursor-not-allowed transform-none">
                                <span wire:loading.remove wire:target="savePembayaran" class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Kirim Pembayaran
                                </span>
                                <span wire:loading wire:target="savePembayaran" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Mengirim Pembayaran...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div wire:loading.flex wire:target="savePembayaran" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-16 h-16 border-4 border-green-200 border-t-green-600 rounded-full animate-spin"></div>
                <h3 class="text-lg font-semibold text-gray-800">Memproses Pembayaran</h3>
                <p class="text-gray-600 text-center">Mohon tunggu, pembayaran Anda sedang diproses...</p>
            </div>
        </div>
    </div>

    <style>
        /* Custom animations and hover effects */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #10b981;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #059669;
        }

        /* Button hover effects */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        /* Input focus effects */
        input:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        /* File input styling */
        input[type="file"] {
            cursor: pointer;
        }

        input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            margin-right: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-1px);
        }
    </style>
</div>