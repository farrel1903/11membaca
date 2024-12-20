@extends('layouts.layoutuser')

@section('title', 'Edit Profile Pengguna')

@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="main-body">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                </ol>
            </nav>
            <!-- /Breadcrumb -->

            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="{{ asset('storage/'. $member->foto)}}" class="rounded-circle" width="150" height="150" alt="Profile Picture" style="object-fit: cover;">
                                <div class="mt-3">
                                    <h4>{{ $member->nama }}</h4>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary">Logout</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>Edit Profil</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group mb-3">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="{{ $member->nama }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                        <option value="Laki-laki" {{ $member->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $member->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="no_telepon">No. Telepon</label>
                                    <input type="text" id="no_telepon" name="no_telepon" class="form-control" value="{{ $member->no_telepon }}">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="foto">Foto Profil</label>
                                    <input type="file" id="foto" name="foto" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    <a href="{{ route('profile.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
