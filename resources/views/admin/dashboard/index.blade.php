@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row my-4">
    <div class="col-md-4">
        <div class="card my-custom-card-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Pesanan</h5>
                <h2>{{ $total_pesanan }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card my-custom-card-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Pengguna</h5>
                <h2>{{ $total_pengguna }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Penjualan Mingguan -->
<div class="row my-4">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-white">Grafik Penjualan Mingguan (Produk Terlaris)</h5>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height: 400px; width: 100%;">
                    <canvas id="grafikPenjualan"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Penjualan -->
<div class="row my-4">
    <div class="col-12">
        <div class="card glass-card">
            <div class="card-header">
                <h5 class="card-title mb-0 text-white">Data Penjualan Per Minggu</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-glass">
                        <thead>
                            <tr>
                                <th class="text-white">Minggu</th>
                                @php
                                    $top_produk = collect($chart_data['datasets'])->pluck('label')->toArray();
                                @endphp
                                @foreach($top_produk as $produk)
                                    <th class="text-white">{{ $produk }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($chart_data['labels']) > 0)
                                @foreach($chart_data['labels'] as $index => $label)
                                    <tr>
                                        <td class="text-white"><strong>{{ $label }}</strong></td>
                                        @foreach($top_produk as $produk)
                                            <td class="text-white">
                                                {{ $chart_data['datasets'][array_search($produk, $top_produk)]['data'][$index] ?? 0 }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="{{ count($top_produk) + 1 }}" class="text-white text-center">
                                        Tidak ada data penjualan
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('grafikPenjualan');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const chartData = @json($chart_data);

        // Jika tidak ada data, buat data dummy
        if (chartData.labels.length === 0) {
            chartData.labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
            chartData.datasets = [{
                label: 'Sample Data',
                data: [5, 10, 8, 12],
                backgroundColor: 'rgba(54, 162, 235, 0.8)'
            }];
        }

        try {
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: chartData.datasets.map((dataset, index) => ({
                        label: dataset.label,
                        data: dataset.data,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ][index % 5],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(153, 102, 255, 1)'
                        ][index % 5],
                        borderWidth: 2,
                        borderRadius: 10,
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#fff'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#fff'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff'
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Error creating chart:', error);
        }
    });
</script>
@endpush
@endsection