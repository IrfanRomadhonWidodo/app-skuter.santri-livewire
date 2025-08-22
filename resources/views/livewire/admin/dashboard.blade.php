<div>
    <!-- Header Dashboard -->
    <div class="bg-gradient-to-r from-green-800 to-green-600 text-white rounded-2xl shadow-xl mb-6 relative overflow-hidden flex items-center justify-between">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-1">Dashboard Admin</h1>
            <p class="text-sm opacity-90">Selamat Datang di Aplikasi Skuter Santri</p>
        </div>

        <div class="flex-shrink-0">
            <img src="{{ asset('image/kas.png') }}" 
                alt="Kas"
                class="h-32 w-auto object-contain drop-shadow-md">
        </div>
    </div>

    <!-- 3 Card Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-md p-5 flex flex-col">
            <span class="text-gray-500 text-sm font-medium">Pendapatan</span>
            <span class="text-2xl font-bold text-green-700 mt-2">Rp 125.000.000</span>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 flex flex-col">
            <span class="text-gray-500 text-sm font-medium">User Menunggak</span>
            <span class="text-2xl font-bold text-red-600 mt-2">1.250</span>
            <span class="text-xs text-gray-400">Mahasiswa</span>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 flex flex-col">
            <span class="text-gray-500 text-sm font-medium">Nominal Tunggakan</span>
            <span class="text-2xl font-bold text-orange-600 mt-2">Rp 57.500.000</span>
        </div>
    </div>

    <!-- Grafik Dummy -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4 text-gray-700">Grafik Jumlah Pembayaran</h2>
        <canvas wire:ignore id="chartPembayaran" class="w-full h-64"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('livewire:load', function () {
    const ctx = document.getElementById('chartPembayaran').getContext('2d');
    window.chartPembayaran = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Jumlah Pembayaran',
                data: [12, 19, 15, 25, 22, 30],
                borderColor: 'rgba(34,197,94,1)',
                backgroundColor: 'rgba(34,197,94,0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, labels: { color: '#374151' } }
            },
            scales: {
                x: { ticks: { color: '#6B7280' } },
                y: { ticks: { color: '#6B7280' } }
            }
        }
    });
});
</script>
@endpush
