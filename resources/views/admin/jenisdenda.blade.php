@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Jenis Denda
                        <form action="{{ route('jenis_denda.index') }}" method="GET" class="d-flex align-items-center float-end">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Jenis Denda" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="jenisDendaTable" class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID Jenis Denda</th>
                                    <th scope="col">Nama Jenis Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenisDenda as $jd)
                                    <tr>
                                        <td>{{ $jd->id_jenis_denda }}</td>
                                        <td>{{ $jd->jenis_denda }}</td>
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
        $('#jenisDendaTable').DataTable({
            paging: true,
            searching: true,
            ordering: true
        });
    });
</script>
