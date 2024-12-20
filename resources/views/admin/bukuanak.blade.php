@extends('layouts.mainadmin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('bukuanak.create') }}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <button type="submit" class="btn btn-warning">Tambah Buku Anak</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Buku Anak
                        <form action="{{ route('bukuanak.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Buku Anak" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        <table id="dataTable" style="text-align: center" class="table table-dark table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">ID Buku Anak</th>
                                    <th scope="col">ID Buku Induk</th>
                                    <th scope="col">Judul Buku</th> <!-- Kolom untuk judul buku -->
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bukuanak as $ba)
                                    <tr>
                                        <td>{{ $ba->id_buku_anak }}</td>
                                        <td>{{ $ba->id_buku_induk }}</td>
                                        <td>{{ $ba->buku->judul ?? 'Tidak ada' }}</td> <!-- Mengambil judul buku dari relasi -->
                                        <td>{{ $ba->status }}</td>
                                        <td class="action-buttons">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('buku.show', $ba->id_buku_induk) }}" class="btn btn-info">Detail Buku</a>
                                            
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('bukuanak.destroy', $ba->id_buku_anak) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus buku anak ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada hasil yang ditemukan</td>
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "searching": false,
            "ordering": true
        });
    });
</script>
