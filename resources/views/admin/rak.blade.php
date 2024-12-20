@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('rak.store') }}" method="POST">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <label class="form-label" for="id_rak" style="font-weight: bold">Nama Rak</label>
                                <input type="text" name="id_rak" class="form-control">
                                <button style="background-color: #ffc107" type="submit" class="btn btn-primary mt-2">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Rak
                        <form action="{{ route('rak.search') }}" method="GET" class="d-flex align-items-center float-end">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Rak" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="rakTable" class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID Rak</th>
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rak as $r)
                                    <tr>
                                        <td>{{ $r->id_rak }}</td>
                                        <td>{{ $r->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('rak.edit', $r->id_rak) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('rak.destroy', $r->id_rak) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus rak ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Tambahkan referensi jQuery dan DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- Inisialisasi DataTables -->
<script>
    $(document).ready(function() {
        $('#rakTable').DataTable({
            // Pengaturan tambahan bisa ditambahkan di sini jika perlu
            paging: true, // Menyalakan pagination
            searching: true, // Menyalakan pencarian
            ordering: true // Menyalakan sorting
        });
    });
</script>
