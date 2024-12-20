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
                                <h2>Form Tambah Buku Anak</h2>
                            </div>
                            <form action="{{ route('bukuanak.store') }}" method="POST">
                                @csrf
                                <!-- Row for ID Buku Induk and Status -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_buku_induk" class="form-label">ID Buku Induk</label>
                                        <select class="form-control" name="id_buku_induk" id="id_buku_induk" required>
                                            @foreach ($buku as $bukuItem)
                                                <option value="{{ $bukuItem->id_buku_induk }}">{{ $bukuItem->id_buku_induk }} - {{ $bukuItem->judul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="tersedia">Tersedia</option>
                                            <option value="dipinjam">Dipinjam</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Row for Kategori -->
                                {{-- <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="kategori_id" class="form-label">Kategori</label>
                                        <select class="form-control" name="kategori_id" id="kategori_id" required>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->kategori_id }}">{{ $category->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="text-center">
                                    <button style="font-weight: bold" type="submit" class="btn btn-warning">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
