@extends('layouts.mainadmin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('addebook.create') }}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <button type="submit" class="btn btn-warning">Tambah Buku</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar eBook
                        <form action="{{ route('ebooks.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Buku" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>
                    
                    
                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Nama Buku</th>
                                    <th scope="col">Kode Buku</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Penulis</th>
                                    <th scope="col">Penerbit</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ebook as $p)
                                    <tr>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->kode_buku }}</td>
                                        <td>{{ $p->kategori->kategori ?? 'Kategori tidak ditemukan' }}</td>
                                        <td>{{ $p->ISBN }}</td>
                                        <td>{{ $p->Penulis }}</td>
                                        <td>{{ $p->Penerbit }}</td>
                                        <td>{{ $p->Deskripsi }}</td>
                                        <td>{{ $p->stok }}</td>
                                        <td>
                                            <img src="{{ asset('fotobuku/' . $p->foto) }}" alt="" style="width: 100px">
                                        </td>
                                        <td class="action-buttons">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('ebooks.edit', $p->id) }}" class="btn btn-primary">Edit</a>
                                            
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('ebooks.destroy', $p->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus ebook ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada hasil yang ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
