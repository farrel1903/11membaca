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
                                <h2>Form Edit Ebook</h2>
                            </div>
                            <form action="{{ route('ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Row for Nama Buku and Kode Buku -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Buku</label>
                                        <input type="text" class="form-control" id="name" name="nama" value="{{ $ebook->nama }}" placeholder="Masukan Nama Buku">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kode_buku" class="form-label">Kode Buku</label>
                                        <input type="text" class="form-control" id="kode_buku" name="kode_buku" value="{{ $ebook->kode_buku }}" placeholder="Masukan Kode Buku">
                                    </div>
                                </div>

                                <!-- Row for Kategori and ISBN -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-control" name="kategori" id="kategori">
                                            @foreach ($category as $c)
                                                <option value="{{ $c->id }}" {{ $ebook->kategori_id == $c->id ? 'selected' : '' }}>{{ $c->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="isbn" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="isbn" name="ISBN" value="{{ $ebook->ISBN }}" placeholder="Masukan ISBN">
                                    </div>
                                </div>

                                <!-- Row for Penulis and Penerbit -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="penulis" class="form-label">Penulis</label>
                                        <input type="text" class="form-control" id="penulis" name="Penulis" value="{{ $ebook->Penulis }}" placeholder="Masukan Nama Penulis">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="penerbit" class="form-label">Penerbit</label>
                                        <input type="text" class="form-control" id="penerbit" name="Penerbit" value="{{ $ebook->Penerbit }}" placeholder="Masukan Nama Penerbit">
                                    </div>
                                </div>

                                <!-- Row for Deskripsi and Stok -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea name="Deskripsi" id="description" class="form-control" rows="4" placeholder="Masukan deskripsi">{{ $ebook->Deskripsi }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="qty" class="form-label">Stok</label>
                                        <input type="text" class="form-control" id="qty" name="stok" value="{{ $ebook->stok }}" placeholder="Masukan Stok">
                                    </div>
                                </div>

                                <!-- Row for Foto -->
                                <div class="mb-4">
                                    <label for="image" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="image" name="foto">
                                    @if ($ebook->foto)
                                        <img src="{{ asset('fotobuku/' . $ebook->foto) }}" alt="Current Image" width="100" class="mt-2">
                                    @endif
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
