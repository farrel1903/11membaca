@extends('layouts.mainadmin')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <label class="form-label" for="kategori" style="font-weight: bold">Nama Kategori</label>
                                <input type="text" name="kategori" class="form-control" required>

                                <label class="form-label" for="waktu_peminjaman" style="font-weight: bold; margin-top: 10px;">Waktu Peminjaman (hari)</label>
                                <input type="number" name="waktu_peminjaman" class="form-control" required>

                                <label class="form-label" for="harga_keterlambatan" style="font-weight: bold; margin-top: 10px;">Harga Keterlambatan (Rp)</label>
                                <input type="number" name="harga_keterlambatan" class="form-control" required>

                                <button style="background-color: #ffc107; margin-top: 15px;" type="submit" class="btn btn-warning">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Kategori
                        <form action="{{ route('category.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Kategori" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Waktu Peminjaman (hari)</th>
                                    <th scope="col">Harga Keterlambatan (Rp)</th>
                                    <th scope="col">Dibuat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $c)
                                    <tr>
                                        <td>{{ $c->kategori }}</td>
                                        <td>{{ $c->waktu_peminjaman }} hari</td>
                                        <td>Rp {{ number_format($c->harga_keterlambatan, 0, ',', '.') }}</td>
                                        <td>{{ $c->created_at ? $c->created_at->diffForHumans() : 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('categories.destroy', $c->kategori_id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
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

<!-- Tambahkan jQuery dan DataTables di bawah ini -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "ordering": true,
            "paging": true,
            "searching": false,
            "lengthChange": true,
            "info": true,
            "language": {
                "paginate": {
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                },
                "lengthMenu": "Tampilkan _MENU_ entri",
                "search": "Cari:",
                "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                "zeroRecords": "Tidak ada hasil yang ditemukan"
            }
        });
    });
</script>
