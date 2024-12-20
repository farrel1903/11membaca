@extends('layouts.mainkepala')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line me-1"></i> Rekap Peminjaman Online Ebook
                        </div>

                        <!-- Export Button - Menampilkan seluruh data -->
                        <div class="col-md-4 d-flex justify-content-end align-items-center">
                            <a href="{{ route('rekaponline.export') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-excel"></i> Export Rekap Peminjaman
                            </a>
                        </div>
                    </div>

                    <div class="card-body" style="background-color: #ffffff; color: white;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card" style="background-color: #555555; color: white;">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Peminjaman Ebook</h5>
                                        <p class="card-text" style="font-size: 24px;">
                                            {{ $totalPeminjaman }} Peminjaman
                                        </p>

                                        <!-- Form Filter Bulan di dalam Card Total Peminjaman Ebook -->
                                        <form action="{{ route('kepala.rekaponline') }}" method="GET" class="d-flex align-items-center mt-3">
                                            <label for="filter-bulan" class="me-2">Filter Bulan:</label>
                                            <select name="bulan" id="filter-bulan" class="form-select form-select-sm me-2">
                                                <option value="">Pilih Bulan</option>
                                                <option value="total" {{ request('bulan') == 'total' ? 'selected' : '' }}>
                                                    Total Peminjaman Ebook Keseluruhan
                                                </option>                                                
                                                @foreach(range(1, 12) as $month)
                                                    <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-sm me-2">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted">Menampilkan rekap peminjaman untuk bulan yang dipilih atau seluruh waktu jika tidak ada bulan yang dipilih.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
