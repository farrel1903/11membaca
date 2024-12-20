@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard Admin Perpus Sebelas</h1>
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
                                    {{ $jumlahBukuTersedia }} <!-- Tampilkan jumlah buku yang tersedia -->
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
                                <span>Jumlah Denda Masuk</span>
                                <div style="color: #ffffff; font-size: 1.5rem; font-weight: bold; margin-top: 0.5rem;">
                                    {{ $totalDenda }} <!-- Tampilkan total anggota bukan pegawai -->
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
                                    {{ $totalMember }} <!-- Tampilkan total anggota bukan pegawai -->
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
                    <!-- Grafik Statistik Jumlah Ebook Dibaca -->
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-chart-area me-1"></i>
                                    Statistik Jumlah Ebook Dibaca
                                </div>
                                <!-- Form Filter Tahun untuk Ebook Dibaca -->
                                <form method="GET" action="{{ route('admin.dashboard') }}" class="d-inline">
                                    <select name="tahun_online" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">Pilih Tahun</option>
                                        @foreach (range(date('Y'), date('Y') - 5) as $tahun)
                                            <option value="{{ $tahun }}" {{ request('tahun_online') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- Pastikan mempertahankan nilai tahun_offline di query string -->
                                    <input type="hidden" name="tahun_offline" value="{{ request('tahun_offline') }}">
                                </form>
                            </div>
                            <div class="card-body">
                                <canvas id="myAreaChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                
                    <!-- Grafik Statistik Peminjaman Offline -->
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-chart-line me-1"></i>
                                    Statistik Peminjaman Offline
                                </div>
                                <!-- Form Filter Tahun untuk Peminjaman Offline -->
                                <form method="GET" action="{{ route('admin.dashboard') }}" class="d-inline">
                                    <select name="tahun_offline" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="">Pilih Tahun</option>
                                        @foreach (range(date('Y'), date('Y') - 5) as $tahun)
                                            <option value="{{ $tahun }}" {{ request('tahun_offline') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- Pastikan mempertahankan nilai tahun_online di query string -->
                                    <input type="hidden" name="tahun_online" value="{{ request('tahun_online') }}">
                                </form>
                            </div>
                            <div class="card-body">
                                <canvas id="offlineAreaChart" width="100%" height="40"></canvas>
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
                label: 'Jumlah Ebook Dibaca Tahun {{request('tahun_online') ?: 'Belum Dipilih'}}',
                data: @json($peminjamanDataOnline),
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
                    max: 60, // Set maximum value to 60
                    ticks: {
                        stepSize: 10 // Set step size to 10
                    }
                }
            }
        }
    });



    const ctxOffline = document.getElementById('offlineAreaChart').getContext('2d');
    const offlineAreaChart = new Chart(ctxOffline, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ], // Label bulan
            datasets: [{
                label: 'Jumlah Buku Offline Dipinjam Tahun {{request('tahun_offline') ?: 'Belum Dipilih'}}',
                data: @json($peminjamanOfflineData), // Data jumlah peminjaman offline
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna latar
                borderColor: 'rgba(54, 162, 235, 1)', // Warna garis
                borderWidth: 2,
                fill: true, // Isi area di bawah garis
                tension: 0.4 // Memberikan efek lengkung pada garis
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0, // Set nilai minimum
                    max: 60, // Set nilai maksimum
                    ticks: {
                        stepSize: 10 // Langkah nilai pada sumbu Y
                    }
                }
            }
        }
    });
</script>
