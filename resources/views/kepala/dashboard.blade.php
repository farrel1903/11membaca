@extends('layouts.mainkepala')

{{-- @section('title', 'Dashboard Kepala Perpus Sebelas') --}}


<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard Kepala Perpus Sebelas</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row" style="padding-bottom: 25px">
                    <div class="col-xl-3 col-md-6" style="font-weight: bold">
                        <div class="card" style="background-color: #212529; color: #ffc107; margin-bottom: 1rem;">
                            <div class="card-body text-center">
                                <span>Ebook Terpinjam</span>
                                <div style="color: #ffffff; font-size: 1.5rem; font-weight: bold; margin-top: 0.5rem;">
                                    {{ $jumlahEbookDipinjam }}
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small stretched-link" href="#" style="color: #ffc107;">Lihat Detail</a>
                                <div class="small"><i class="fas fa-angle-right" style="color: #ffc107;"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6" style="font-weight: bold">
                        <div class="card" style="background-color: #212529; color: #ffc107; margin-bottom: 1rem;">
                            <div class="card-body text-center">
                                <span>Buku Tersedia</span>
                                <div style="color: #ffffff; font-size: 1.5rem; font-weight: bold; margin-top: 0.5rem;">
                                    {{ $jumlahBukuTersedia }}
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small stretched-link" href="#" style="color: #ffc107;">Lihat Detail</a>
                                <div class="small"><i class="fas fa-angle-right" style="color: #ffc107;"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6" style="font-weight: bold">
                        <div class="card" style="background-color: #212529; color: #ffc107; margin-bottom: 1rem;">
                            <div class="card-body text-center">
                                <span>Denda Masuk</span>
                                <div style="color: #ffffff; font-size: 1.5rem; font-weight: bold; margin-top: 0.5rem;">
                                    10
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small stretched-link" href="#" style="color: #ffc107;">Lihat Detail</a>
                                <div class="small"><i class="fas fa-angle-right" style="color: #ffc107;"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6" style="font-weight: bold">
                        <div class="card" style="background-color: #212529; color: #ffc107; margin-bottom: 1rem;">
                            <div class="card-body text-center">
                                <span>Jumlah Member</span>
                                <div style="color: #ffffff; font-size: 1.5rem; font-weight: bold; margin-top: 0.5rem;">
                                    {{ $totalMember }}
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small stretched-link" href="#" style="color: #ffc107;">Lihat Detail</a>
                                <div class="small"><i class="fas fa-angle-right" style="color: #ffc107;"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Statistik Jumlah Ebook Dibaca
                            </div>
                            <div class="card-body">
                                <canvas id="myAreaChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Statistik Peminjaman Offline
                            </div>
                            <div class="card-body">
                                <canvas id="myBarChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Logout</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    const myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ],
            datasets: [{
                label: 'Jumlah Ebook Dibaca Tahun 2024',
                data: @json($peminjamanData),
                backgroundColor: 'rgba(255, 193, 7, 0.2)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0, // Set minimum value to 0
                    max: 50, // Set maximum value to 60
                    ticks: {
                        stepSize: 5 // Set step size to 10
                    }
                }
            }
        }
    });
</script>
