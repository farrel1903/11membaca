@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <!-- Judul Form -->
                <div class="row justify-content-center mb-4">
                </div>

                <!-- Formulir dengan Background -->
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <!-- Kartu untuk form -->
                        <div class="card" style="background-color: #afb3b7; padding: 20px;">
                            <div class="text-center">
                                <h2>Form Edit Member</h2>
                            </div>
                            <form action="{{ route('admin.member.update', $member->id_user) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Row for NIK and Nama -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nis_nik" class="form-label">NIS/NIK</label>
                                        <input type="text" class="form-control" id="nis_nik" name="nis_nik" value="{{ old('nis_nik', $member->nis_nik) }}" readonly>
                                        <small class="form-text text-danger"> * NIK tidak dapat diubah.</small> <!-- Peringatan untuk NIK -->
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $member->nama) }}" required>
                                    </div>
                                </div>

                                <!-- Row for Jenis Kelamin and No Telepon -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                            <option value="Laki-laki" {{ $member->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ $member->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="no_telepon" class="form-label">No Telepon</label>
                                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $member->no_telepon) }}" required>
                                    </div>
                                </div>

                                <!-- Row for Asal Sekolah and Tingkatan -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                        <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $member->asal_sekolah) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tingkatan" class="form-label">Tingkatan</label>
                                        <select class="form-control" name="tingkatan" id="tingkatan" required>
                                            <option value="NonPro" {{ $member->tingkatan == 'NonPro' ? 'selected' : '' }}>NonPro</option>
                                            <option value="Pro" {{ $member->tingkatan == 'Pro' ? 'selected' : '' }}>Pro</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Row for Foto and Status -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="foto" class="form-label">Foto</label>
                                        <input type="file" class="form-control" id="foto" name="foto">
                                        @if ($member->foto)
                                            <img src="{{ asset('storage/'. $member->foto) }}" alt="Foto Member" style="max-width: 100px; margin-top: 10px;">
                                        @endif
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="Full" {{ $member->status == 'Full' ? 'selected' : '' }}>Full</option>
                                            <option value="General" {{ $member->status == 'General' ? 'selected' : '' }}>General</option>
                                            <option value="Pegawai" {{ $member->status == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="text-center">
                                    <button style="font-weight: bold" type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
