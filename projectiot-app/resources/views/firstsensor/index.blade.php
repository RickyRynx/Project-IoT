@extends('layouts.masterFirstSensor')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Section 1: Info dan Aksi -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Suhu Air Terbaru</h5>
                        <h1 class="text-success">{{ $latestTemperature ?? 'Tidak tersedia' }} °C</h1>
                        <small class="text-muted">Kategori: {{ $condition ?? 'Tidak tersedia' }}</small><br>
                        <small class="text-muted">Timestamp Terakhir: {{ $latestTimestamp ?? 'Tidak tersedia' }}</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Kondisi Air</h5>
                        <h1 class="text-info">{{ $description ?? 'Tidak tersedia' }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5>Keterangan</h5>
                        <h1 class="text-primary">
                            {{ $latestTemperature > 30 ? 'Air harus diganti' : 'Air tidak diganti' }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <!-- Section 2: Grafik -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tingkat Suhu Air</h5>
                        <canvas id="temperatureThermometer"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Riwayat Pengecekan Suhu</h5>
                        <canvas id="temperatureHistory"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        // Data from Controller
        const currentTemperature = {{ $latestTemperature ?? 0 }};
        const historyData = @json($history ?? []);
        const historyLabels = historyData.map(data => data.time ?? 'N/A');
        const historyValues = historyData.map(data => data.temperature ?? 0);

        // Thermometer Chart
        const ctxThermometer = document.getElementById('temperatureThermometer').getContext('2d');
        const thermometerChart = new Chart(ctxThermometer, {
            type: 'bar',
            data: {
                labels: [''],
                datasets: [{
                    label: 'Suhu (°C)',
                    data: [currentTemperature],
                    backgroundColor: currentTemperature > 30 ? '#dc3545' : '#28a745',
                    borderColor: '#000',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 10,
                            callback: function(value) {
                                return value + '°C';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        display: true,
                        align: 'end',
                        color: '#000',
                        formatter: function(value) {
                            return value + '°C';
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Temperature History Chart
        const ctxHistory = document.getElementById('temperatureHistory').getContext('2d');
        const temperatureHistory = new Chart(ctxHistory, {
            type: 'line',
            data: {
                labels: historyLabels, // Data waktu dari controller
                datasets: [{
                    label: 'Temperature (°C)',
                    data: historyValues, // Data suhu dari controller
                    borderColor: '#007bff',
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    zoom: {
                        pan: {
                            enabled: true, // Aktifkan fitur pan (geser)
                            mode: 'x', // Geser hanya pada sumbu X (horizontal)
                        },
                        zoom: {
                            wheel: {
                                enabled: true, // Zoom menggunakan scroll wheel mouse
                            },
                            pinch: {
                                enabled: true, // Zoom menggunakan pinch (gesture touch)
                            },
                            limits: {
                                x: {
                                    min: 5,
                                    max: 500
                                }, // Minimal dan maksimal data yang dapat dilihat dalam satu waktu
                            },
                            mode: 'x', // Zoom hanya pada sumbu X (horizontal)
                        },
                    }
                },
                scales: {
                    x: {
                        type: 'category',
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                        },
                    },
                    y: {
                        ticks: {
                            stepSize: 5, // Mengatur interval suhu pada sumbu Y
                        },
                    },
                },
            }
        });
    </script>
@endsection
