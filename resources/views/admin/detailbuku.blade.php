@extends('layouts.mainadmin')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <!-- Card for Buku Detail -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        Detail Buku
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Cover Image -->
                            <div class="col-md-4 mb-3">
                                <img src="{{ asset('fotobuku/' . $buku->sampul) }}" alt="Sampul Buku" class="img-fluid rounded">
                            </div>
                            <!-- Buku Details -->
                            <div class="col-md-8 mb-3">
                                <h5 class="card-title mb-3">{{ $buku->judul }}</h5>
                                <div class="row mb-2">
                                    <!-- ID Buku Induk -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>ID Buku Induk:</strong> {{ $buku->id_buku_induk }}</p>
                                    </div>
                                    <!-- ID Rak -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>ID Rak:</strong> {{ $buku->id_rak }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Kategori -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Kategori:</strong> {{ $buku->kategori->kategori }}</p>
                                    </div>
                                    <!-- ISBN -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>ISBN:</strong> {{ $buku->ISBN }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Penulis -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Penulis:</strong> {{ $buku->Penulis }}</p>
                                    </div>
                                    <!-- Penerbit -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Penerbit:</strong> {{ $buku->Penerbit }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Tahun Terbit -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                                    </div>
                                    <!-- Jumlah Halaman -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Jumlah Halaman:</strong> {{ $buku->jumlah_halaman }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Harga -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Harga:</strong> {{ $buku->harga }}</p>
                                    </div>
                                    <!-- Ebook Link -->
                                    <div class="col-6">
                                        @if($buku->ebook)
                                            <a href="{{ asset('ebook_pdf/' . $buku->ebook) }}" class="btn btn-info" target="_blank">Lihat Ebook</a>
                                        @else
                                            <p>Tidak ada ebook</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-6">
                                        <p class="card-text"><strong>Status:</strong> {{ $buku->status }}</p>
                                    </div>

                                </div>
                                <!-- Sinopsis -->
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <p class="card-text"><strong>Sinopsis:</strong></p>
                                        <div class="p-3 mb-2 bg-light border rounded">
                                            <p>{{ $buku->sinopsis }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-3">
                            <a href="{{ route('buku.edit', $buku->id_buku_induk) }}" class="btn btn-primary me-2">Edit</a>
                            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
