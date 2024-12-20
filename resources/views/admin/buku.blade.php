@extends('layouts.mainadmin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<style>
    .sort-icon {
        display: inline-block;
        position: relative;
        vertical-align: middle;
        color: inherit;
    }

    .disabled-link {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }

</style>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('buku.create') }}" method="GET">
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
                        Daftar Buku
                        <form action="{{ route('buku.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <select name="filter" class="form-select form-select-sm me-2" id="filter-option">
                                <option value="" disabled selected>Kriteria Pencarian Buku</option>
                                <option value="judul">Judul Buku</option>
                                <option value="id_buku_induk">ID Buku Induk</option>
                                <option value="kategori">Kategori</option>
                            </select>
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Buku" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        <!-- Menampilkan jumlah total buku -->
                        <h4>Jumlah Total Buku: <span class="badge badge-info" style="color: black; background-color:cornflowerblue;">{{ count($buku) }}</span></h4>

                        <table id="tabel-buku" class="table table-dark table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">ID Buku Induk</th>
                                    <th scope="col">ID Rak</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Jumlah Buku</th>
                                    <th scope="col">Ebook</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($buku as $b)
                                    <tr>
                                        <td>{{ $b->judul }}</td>
                                        <td>{{ $b->id_buku_induk }}</td>
                                        <td>{{ $b->id_rak }}</td>
                                        <td>{{ $b->kategori->kategori }}</td>
                                        <td>{{ $b->jumlah_buku }}</td>
                                        <td>
                                            <a href="{{ $b->ebook ? asset('ebook_pdf/' . $b->ebook) : '#' }}" 
                                               class="btn btn-info btn-sm {{ !$b->ebook ? 'disabled-link' : '' }}" 
                                               target="_blank">
                                                Lihat Ebook
                                            </a>
                                        </td>
                                        
                                        
                                        <td class="action-buttons">
                                            <a href="{{ route('buku.edit', $b->id_buku_induk) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ route('buku.show', $b->id_buku_induk) }}" class="btn btn-info">Detail</a>
                                            <form action="{{ route('buku.destroy', $b->id_buku_induk) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada hasil yang ditemukan</td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabel-buku').DataTable({
            "paging": true,        // Aktifkan fitur pagination
            "searching": false,     // Aktifkan fitur pencarian
            "ordering": true,      // Aktifkan fitur sorting
            "info": true           // Aktifkan informasi tabel
        });
    });
</script>
