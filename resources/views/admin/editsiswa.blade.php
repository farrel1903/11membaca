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
                                <h2>Form Edit Siswa</h2>
                            </div>
                            <form action="{{ route('siswa.update', $siswa->nis) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Row for NIS and Nama Lengkap -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nis" class="form-label">NIS</label>
                                        <input type="text" class="form-control" id="nis" name="nis"
                                            value="{{ $siswa->nis }}" placeholder="Masukan NIS Siswa">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="full_name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name"
                                            value="{{ $siswa->full_name }}" placeholder="Masukan Nama Lengkap">
                                    </div>
                                </div>

                                <!-- Row for Jenis Kelamin and Kelas -->
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="Laki-laki"
                                                {{ $siswa->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ $siswa->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <select class="form-control" name="kelas" id="kelas" required>
                                            <option value="X RPL 1"
                                                {{ $siswa->kelas == 'X RPL 1' ? 'selected' : '' }}>X RPL 1
                                            </option>
                                            <option value="X RPL 2"
                                                {{ $siswa->kelas == 'X RPL 2' ? 'selected' : '' }}>X RPL 2
                                            </option>
                                            <option value="XI RPL 1"
                                                {{ $siswa->kelas == 'XI RPL 1' ? 'selected' : '' }}>XI RPL 1
                                            </option>
                                            <option value="XI RPL 2"
                                                {{ $siswa->kelas == 'XI RPL 2' ? 'selected' : '' }}>XI RPL 2
                                            </option>
                                            <option value="XI AKL 1"
                                                {{ $siswa->kelas == 'XI AKL 1' ? 'selected' : '' }}>XI AKL 1
                                            </option>
                                            <option value="XI AKL 2"
                                                {{ $siswa->kelas == 'XI AKL 2' ? 'selected' : '' }}>XI AKL 2
                                            </option>
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
