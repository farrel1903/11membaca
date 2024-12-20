@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <!-- Judul Form -->
                <div class="row justify-content-center mb-4">
                </div>

                <!-- Formulir dengan Background -->
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <!-- Kartu untuk form -->
                        <div class="card" style="background-color: #afb3b7; padding: 20px;">
                            <div class="text-center">
                                <h2>Form Edit Buku</h2>
                            </div>
                            <form action="{{ route('buku.update', $buku->id_buku_induk) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Row for Nama Buku and ID Buku -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="judul" class="form-label">Judul Buku</label>
                                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $buku->judul) }}" placeholder="Masukkan Judul Buku" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="id_buku_induk" class="form-label">ID Buku</label>
                                        <input type="text" class="form-control" id="id_buku_induk" name="id_buku_induk" value="{{ old('id_buku_induk', $buku->id_buku_induk) }}" placeholder="Masukkan ID Buku" required>
                                    </div>
                                </div>

                                <!-- Row for Kategori and Rak -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="kategori_id" class="form-label">Kategori</label>
                                        <select class="form-control" name="kategori_id" id="kategori_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->kategori_id }}" {{ $category->kategori_id == $buku->kategori_id ? 'selected' : '' }}>{{ $category->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="id_rak" class="form-label">Rak</label>
                                        <select class="form-control" name="id_rak" id="id_rak" required>
                                            @foreach ($rak as $rakItem)
                                                <option value="{{ $rakItem->id_rak }}" {{ $rakItem->id_rak == $buku->id_rak ? 'selected' : '' }}>{{ $rakItem->id_rak }}</option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                </div>

                                <!-- Row for ISBN, Penulis, and Penerbit -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="ISBN" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="ISBN" name="ISBN" value="{{ old('ISBN', $buku->ISBN) }}" placeholder="Masukkan ISBN" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="Penulis" class="form-label">Penulis</label>
                                        <input type="text" class="form-control" id="Penulis" name="Penulis" value="{{ old('Penulis', $buku->Penulis) }}" placeholder="Masukkan Nama Penulis" required>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="Penerbit" class="form-label">Penerbit</label>
                                        <input type="text" class="form-control" id="Penerbit" name="Penerbit" value="{{ old('Penerbit', $buku->Penerbit) }}" placeholder="Masukkan Nama Penerbit" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                        <select class="form-control" name="tahun_terbit" id="tahun_terbit" required>
                                            @for ($year = date('Y'); $year >= 1900; $year--)
                                                <option value="{{ $year }}" {{ $year == $buku->tahun_terbit ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <!-- Row for Sinopsis, Jumlah Halaman, and Stok -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="sinopsis" class="form-label">Sinopsis</label>
                                        <textarea name="sinopsis" id="sinopsis" class="form-control" rows="4" placeholder="Masukkan Sinopsis">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jumlah_halaman" class="form-label">Jumlah Halaman</label>
                                        <input type="number" class="form-control" id="jumlah_halaman" name="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}" placeholder="Masukkan Jumlah Halaman" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $buku->harga) }}" placeholder="Masukkan Harga" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $buku->stok) }}" placeholder="Masukkan Stok" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jumlah_buku" class="form-label">Jumlah Buku</label>
                                        <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku"
                                            value="{{ old('jumlah_buku', $buku->jumlah_buku) }}" placeholder="Masukkan Jumlah Buku" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="" disabled>Pilih Status</option>
                                            <option value="full" {{ $buku->status == 'full' ? 'selected' : '' }}>Full</option>
                                            <option value="offline" {{ $buku->status == 'offline' ? 'selected' : '' }}>Offline</option>
                                            <option value="online" {{ $buku->status == 'online' ? 'selected' : '' }}>Online</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Row for Sampul and Ebook -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="sampul" class="form-label">Sampul Buku</label>
                                        <input type="file" class="form-control" id="sampul" name="sampul">
                                        @if ($buku->sampul)
                                            <img src="{{ asset('fotobuku/' . $buku->sampul) }}" alt="Sampul Buku" style="max-width: 100px; margin-top: 10px;">
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ebook" class="form-label">Ebook (PDF)</label>
                                        <input type="file" class="form-control" id="ebook" name="ebook">
                                        @if ($buku->ebook)
                                            <a href="{{ asset('ebook_pdf/' . $buku->ebook) }}" target="_blank">Lihat Ebook</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button style="font-weight: bold" type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
