@extends('layouts.layoutuser')

@section('title', 'History Peminjaman Offline')

@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="mx-2 mb-0">/</span>
                    <strong class="text-black">History Peminjaman Offline</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    @csrf

                    <!-- Tempatkan pesan kesalahan dan notifikasi di sini -->
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <h4>Jumlah Buku dipinjam pada Transaksi:
                        <span class="badge badge-info" style="color: black; background-color:cornflowerblue;">
                            {{ $transaksiDetail->count() }}
                        </span>
                    </h4>

                    <!-- Tabel dengan DataTables -->
                    <table id="historyTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>ID Buku Anak</th>
                                <th>Denda</th>
                                <th>Tanggal Pengembalian Buku</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiDetail as $detail)
                                <tr>
                                    <td>{{ $detail->id_transaksi }}</td>
                                    <td>{{ $detail->id_buku_anak }}</td>
                                    <td>
                                        <span id="denda_{{ $detail->id_buku_anak }}"
                                            data-harga="{{ optional($detail->bukuAnak->buku)->harga ?? 0 }}"
                                            data-harga_keterlambatan="{{ optional(optional($detail->bukuAnak->buku)->category)->harga_keterlambatan ?? 0 }}">
                                            {{ number_format($detail->denda, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>{{ $detail->tanggal_pengembalian_buku ?? 'N/A' }}</td>
                                    <td>{{ $detail->status }}</td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-primary btn-sm">Rating</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada hasil yang ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>


    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Muat jQuery terlebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $('#historyTable').DataTable({
        "paging": true, // Mengaktifkan pagination
        "searching": true, // Mengaktifkan pencarian
        "ordering": true, // Mengaktifkan sorting
        "info": true, // Menampilkan info jumlah data
        "lengthMenu": [5, 10, 25, 50, 75, 100], // Menentukan pilihan jumlah data per halaman
        "pageLength": 10, // Set default rows per page
        "language": {
            "lengthMenu": "Menampilkan _MENU_ data per halaman", 
            "zeroRecords": "Data tidak ditemukan", 
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_", 
            "infoEmpty": "Tidak ada data tersedia", 
            "infoFiltered": "(disaring dari _MAX_ total data)",
            "search": "Cari:"
        }
    });
</script>
@endsection
