@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <form action="{{ route('siswa.create') }}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <button type="submit" class="btn btn-warning">Tambah Siswa</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Data Siswa
                        <form action="{{ route('siswa.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari Siswa" value="{{ request('search') }}">
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
                                    <th scope="col">NIS</th>
                                    <th scope="col">Nama Lengkap</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $s)
                                    <tr>
                                        <td>{{ $s->nis }}</td>
                                        <td>{{ $s->full_name }}</td>
                                        <td>{{ $s->gender }}</td>
                                        <td>{{ $s->kelas }}</td>
                                        <td>
                                            <a href="{{ route('siswa.edit', $s->nis) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('siswa.destroy', $s->nis) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus Siswa ini?')">Hapus</button>
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
