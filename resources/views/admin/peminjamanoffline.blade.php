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
                    <div class="col-md-7">
                        <div class="d-flex mb-3" style="padding: 15px;">
                            <form action="{{ route('peminjamanoffline.create') }}" method="GET" style="margin-right: 10px;">
                                @csrf
                                <button type="submit" class="btn btn-warning">Tambah Peminjaman</button>
                            </form>
                            
                            <form action="{{ route('transaksi.export') }}" method="GET">
                                @csrf
                                <button type="submit" class="btn btn-warning">  <i class="fas fa-file-excel"></i> Export Rekap</button>
                            </form>
                        </div>
                    </div>                    

                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Peminjaman Offline
                        <form action="{{ route('transaksi.search') }}" method="GET" class="d-flex align-items-center mb-3">
                            @csrf
                            <select name="filter" class="form-select form-select-sm me-2" id="filter-option">
                                <option value="" disabled selected>Kriteria Pencarian</option>
                                <option value="id_transaksi" {{ request('filter') == 'id_transaksi' ? 'selected' : '' }}>ID Transaksi</option>
                                <option value="nis_nik" {{ request('filter') == 'nis_nik' ? 'selected' : '' }}>NIS/NIK</option>
                                <option value="tanggal_peminjaman" {{ request('filter') == 'tanggal_peminjaman' ? 'selected' : '' }}>Tanggal Pinjam</option>
                            </select>
                
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Transaksi" value="{{ request('search') }}">
                
                            <button type="submit" class="btn btn-info btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>
                

                    <div class="card-body">
                        <h4>Jumlah Total Peminjaman: <span class="badge badge-info"
                                style="color: black; background-color:cornflowerblue;">{{ $transaksi->count() }}</span>
                        </h4>

                        <table id="dataTable" style="text-align: center" class="table table-dark table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">ID Transaksi</th>
                                    <th scope="col">NIS/NIK</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Tanggal Pengembalian</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksi as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->id_transaksi }}</td>
                                        <td>{{ $peminjaman->nis_nik }}</td>
                                        <td>{{ $peminjaman->tanggal_peminjaman ? $peminjaman->tanggal_peminjaman : 'N/A' }}
                                        </td>
                                        <td>
                                            @php
                                                // Ambil tanggal pengembalian dari database jika sudah ada
                                                $tanggalPengembalian = $peminjaman->tanggal_pengembalian;
                                        
                                                // Jika tanggal pengembalian belum ada, hitung berdasarkan kategori
                                                if (!$tanggalPengembalian) {
                                                    // Ambil buku anak berdasarkan id_buku_anak
                                                    $bukuAnak = \App\Models\BukuAnak::find($peminjaman->id_buku_anak);
                                        
                                                    // Cek jika bukuAnak ditemukan
                                                    if ($bukuAnak) {
                                                        // Ambil kategori buku
                                                        $kategori = \App\Models\Categories::find($bukuAnak->kategori_id);
                                        
                                                        // Cek jika kategori ditemukan
                                                        if ($kategori) {
                                                            // Hitung tanggal pengembalian berdasarkan waktu_peminjaman dari kategori
                                                            $tanggalPengembalian = \Carbon\Carbon::parse(
                                                                $peminjaman->tanggal_peminjaman
                                                            )->addDays($kategori->waktu_peminjaman);
                                        
                                                            // Update tanggal_pengembalian ke database untuk menghindari perhitungan ulang
                                                            $peminjaman->update(['tanggal_pengembalian' => $tanggalPengembalian]);
                                                        }
                                                    }
                                                }
                                            @endphp
                                        
                                            {{ $tanggalPengembalian ? \Carbon\Carbon::parse($tanggalPengembalian)->format('Y-m-d') : 'Tidak Diketahui' }}
                                        </td>
                                        
                                        <td class="action-buttons">
                                            <a href="{{ route('transaksi.show', $peminjaman->id_transaksi) }}"
                                                class="btn btn-warning">Pengembalian</a>
                                            <form action="{{ route('transaksi.destroy', $peminjaman->id_transaksi) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
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

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true
        });
    });
</script>
