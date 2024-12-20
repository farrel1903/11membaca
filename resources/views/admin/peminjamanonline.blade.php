@extends('layouts.mainadmin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    {{-- <div class="col-md-7">
                        <form action="{{ route('riwayat.create') }}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <button type="submit" class="btn btn-warning">Tambah Peminjaman</button>
                            </div>
                        </form>
                    </div> --}}
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Peminjaman Ebook
                        <form action="{{ route('riwayat.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <select name="filter" class="form-select form-select-sm me-2" id="filter-option">
                                <option value="" disabled selected>Kriteria Pencarian </option>
                                <option value="id_pinjam" {{ request('filter') == 'id_pinjam' ? 'selected' : '' }}>ID Peminjaman</option>
                                <option value="id_user" {{ request('filter') == 'id_user' ? 'selected' : '' }}>ID Pengguna</option>
                                <option value="id_buku_induk" {{ request('filter') == 'id_buku_induk' ? 'selected' : '' }}>ID Buku Induk</option>
                                <option value="judul" {{ request('filter') == 'judul' ? 'selected' : '' }}>Judul Buku</option>
                                <option value="kategori" {{ request('filter') == 'kategori' ? 'selected' : '' }}>Kategori</option>
                                <option value="isbn" {{ request('filter') == 'isbn' ? 'selected' : '' }}>ISBN</option>
                                <option value="tanggal_pinjam" {{ request('filter') == 'tanggal_pinjam' ? 'selected' : '' }}>Tanggal Pinjam</option>
                            </select>
                            
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Peminjaman " value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                        <a href="{{ route('riwayat.export') }}" class="btn btn-success float-end me-2">
                            <i class="fas fa-file-excel"></i> Export Rekap
                        </a>                        
                    </div>

                    <div class="card-body">
                        <h4>Jumlah Total Peminjaman: <span class="badge badge-info" style="color: black; background-color:cornflowerblue;">{{ $riwayat->count() }}</span></h4>

                        <table id="dataTable" style="text-align: center" class="table table-dark table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">ID Peminjaman</th>
                                    <th scope="col">ID Pengguna</th>
                                    <th scope="col">ID Buku Induk</th>
                                    <th scope="col">Judul Buku</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Tanggal Peminjaman</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayat as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->id_pinjam }}</td>
                                        <td>{{ $peminjaman->id_user }}</td>
                                        <td>{{ $peminjaman->id_buku_induk }}</td>
                                        <td>{{ $peminjaman->judul }}</td>
                                        <td>{{ $peminjaman->kategori }}</td>
                                        <td>{{ $peminjaman->isbn }}</td>
                                        <td>{{ $peminjaman->tanggal_peminjaman }}</td>
                                        <td class="action-buttons">
                                            <form action="{{ route('riwayat.destroy', $peminjaman->id_pinjam) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada hasil yang ditemukan</td>
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

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "searching": false,
            "ordering": true
        });
    });
</script>
