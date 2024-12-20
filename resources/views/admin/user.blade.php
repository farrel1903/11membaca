@extends('layouts.mainadmin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        {{-- <form action="{{ route('user.create') }}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <button type="submit" class="btn btn-warning">Tambah User</button>
                            </div>
                        </form> --}}
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar User
                        <form action="{{ route('user.search') }}" method="GET" class="d-flex align-items-center float-end">
                            @csrf
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari User" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tabel-user" class="table table-dark table-striped" style="text-align: center">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">ID User</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                        {{-- <th scope="col">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $user->id_user }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role_as == 1)
                                                    <p>Admin</p>
                                                @elseif($user->role_as == 3)
                                                    <p>Kepala</p>
                                                @elseif($user->role_as == 0)
                                                    <p>User</p>
                                                @endif
                                            </td>                                        
                                            {{-- <td class="action-buttons"> --}}
                                                {{-- <!-- Tombol Edit -->
                                                <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-primary">Edit</a> --}}
                                                {{-- <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                                                </form> --}}
                                            {{-- </td> --}}
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
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabel-user').DataTable({
            "paging": true,        // Aktifkan fitur pagination
            "searching": true,     // Aktifkan fitur pencarian
            "ordering": true,      // Aktifkan fitur sorting
            "info": true           // Aktifkan informasi tabel
        });
    });
</script>
