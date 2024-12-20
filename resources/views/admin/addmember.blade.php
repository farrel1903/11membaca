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
                    <div class="col-md-10">
                        <!-- Kartu untuk form -->
                        <div class="card" style="background-color: #afb3b7; padding: 20px;">
                            <div class="text-center">
                                <h2>Form Tambah Member</h2>
                            </div>
                            <form action="{{ route('admin.member.store') }}" method="POST">
                                @csrf

                                <!-- Row for NIS_NIK -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nis_nik" class="form-label">NIS/NIK</label>
                                        <input type="text" class="form-control" id="nis_nik" name="nis_nik" placeholder="Masukan NIS/NIK" required>
                                    </div>
                                </div>

                                <!-- Row for ID User -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="id_user" class="form-label">ID User</label>
                                        <input type="text" class="form-control" id="id_user" name="id_user" placeholder="Masukan ID User" required>
                                    </div>
                                </div>

                                <!-- Row for Nama Lengkap and Jenis Kelamin -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Lengkap" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Row for No Telepon -->
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Masukan Nomor Telepon" required>
                                    </div>
                                </div>

                                <!-- Row for Status -->
                                <div class="row mb-4">
                                    <div class="col-md-12 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="Full">Full</option>
                                            <option value="General">General</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button style="font-weight: bold" type="submit" class="btn btn-warning">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
