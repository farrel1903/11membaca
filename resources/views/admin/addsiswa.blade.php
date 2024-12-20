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
                            <div class=" text-center">
                                <h2>Form Tambah Siswa</h2>
                            </div>
                            <form action="{{ route('siswa.store') }}" method="POST">
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nis" class="form-label">NIS</label>
                                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukan NIS Siswa">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="full_name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Masukan Nama Lengkap">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <select class="form-control" name="kelas" id="kelas">
                                            <option value="X RPL 1">X RPL 1</option>
                                            <option value="X RPL 2">X RPL 2</option>
                                            <option value="XI RPL 1">XI RPL 1</option>
                                            <option value="XI RPL 2">XI RPL 2</option>
                                            <option value="XI AKL 1">XI AKL 1</option>
                                            <option value="XI AKL 2">XI AKL 2</option>
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
