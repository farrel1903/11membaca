@extends('layouts.mainadmin')

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Daftar Pengguna
                                <form action="{{ route('pengguna.search') }}" method="GET" class="d-flex align-items-center float-end">
                                    @csrf
                                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Pengguna" value="{{ request('search') }}">
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
                                            <th scope="col">UserID</th>
                                            <th scope="col">Nama Lengkap</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Nomor Telepon</th>
                                            <th scope="col">Dibuat</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengguna as $p)
                                            <tr>
                                                <td>{{ $p->UserID }}</td>
                                                <td>{{ $p->nama_lengkap }}</td>
                                                <td>{{ $p->username }}</td>
                                                <td>{{ $p->jenis_kelamin }}</td>
                                                <td>{{ $p->nomor_telepon }}</td>
                                                <td>{{ $p->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <!-- Tombol hapus dengan form -->
                                                    <form action="{{ route('pengguna.destroy', $p->UserID) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
