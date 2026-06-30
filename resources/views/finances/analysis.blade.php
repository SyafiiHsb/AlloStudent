@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Analisis Keuangan</h3>
    <a href="{{ route('finances.index') }}" class="btn btn-outline-primary">Kembali ke Data</a>
</div>

<!-- Grafik Tren Bulanan -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card card-custom shadow-sm p-3">
            <h5 class="card-title text-primary">Tren Pemasukan vs Pengeluaran (Tahun Ini)</h5>
            <div class="ratio ratio-16x9">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Kategori -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card card-custom shadow-sm p-3 h-100">
            <h5 class="card-title text-primary">Proporsi Pengeluaran per Kategori</h5>
            <div class="ratio ratio-4x3">
                <canvas id="categoryChart"></canvas>
            </div>
            @if(empty($categoryLabels))
                <div class="alert alert-warning mt-3">Belum ada pengeluaran yang dapat ditampilkan berdasarkan kategori.</div>
            @endif
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card card-custom shadow-sm p-3 h-100">
            <h5 class="card-title text-primary">Ringkasan Cepat</h5>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Gunakan grafik ini untuk melihat di mana uang Anda paling banyak keluar. Kurangi pengeluaran pada kategori yang mendominasi untuk menabung lebih banyak!
            </div>
            @if(count($categoryLabels) > 0)
                <ul class="list-group list-group-flush">
                    @foreach($categoryLabels as $index => $label)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $label }}
                        <span class="badge bg-primary rounded-pill">Rp {{ number_format($categoryValues[$index], 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center text-muted py-4">Tidak ada data kategori pengeluaran untuk ditampilkan.</div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Setup Grafik Tren (Line Chart)
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($incomeChart),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($expenseChart),
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        if (@json(count($categoryLabels)) > 0) {
            const ctxCat = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctxCat, {
                type: 'doughnut',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categoryValues),
                        backgroundColor: [
                            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                            '#8E44AD', '#2ECC71', '#E67E22', '#3498DB'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection