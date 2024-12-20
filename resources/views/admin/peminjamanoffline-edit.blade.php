@extends('layouts.mainadmin')

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <h2>Form Edit Peminjaman Offline</h2>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="card" style="background-color: #afb3b7; padding: 20px;">
                            <form action="{{ route('transaksi.update', $transaksi->id_transaksi) }}" method="POST" id="peminjamanForm">
                                @csrf
                                @method('PUT')

                                <!-- Input untuk NIS/NIK dan Nama Anggota (readonly) -->
                                <div class="mb-4">
                                    <label for="nis_nik" class="form-label">NIS/NIK dan Nama Anggota</label>
                                    <input type="text" class="form-control" name="nis_nik" id="nis_nik" value="{{ $transaksi->nis_nik }} - {{ $transaksi->member->nama }}" readonly>
                                </div>

                                <!-- Input Buku dan Durasi -->
                                <div id="inputBukuContainer">
                                    @if ($transaksi->buku && $transaksi->buku->isNotEmpty())
                                        @foreach ($transaksi->buku as $index => $buku)
                                            <div class="row mb-4 buku-input">
                                                <div class="col-md-6 mb-3">
                                                    <label for="id_buku_anak[]" class="form-label">ID Buku Anak</label>
                                                    <select class="form-control" name="id_buku_anak[]" required>
                                                        <option value="">Pilih Buku</option>
                                                        @foreach ($bukuAnak as $bukuItem)
                                                            <option value="{{ $bukuItem->id_buku_anak }}" {{ $bukuItem->id_buku_anak == $buku->id_buku_anak ? 'selected' : '' }}>
                                                                {{ $bukuItem->judul }} ({{ $bukuItem->id_buku_anak }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="durasi[]" class="form-label">Durasi (Hari)</label>
                                                    <select class="form-control" name="durasi[]" required>
                                                        <option value="3" {{ $buku->durasi == 3 ? 'selected' : '' }}>3 Hari</option>
                                                        <option value="5" {{ $buku->durasi == 5 ? 'selected' : '' }}>5 Hari</option>
                                                        <option value="7" {{ $buku->durasi == 7 ? 'selected' : '' }}>7 Hari</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="row mb-4 buku-input">
                                            <div class="col-md-6 mb-3">
                                                <label for="id_buku_anak[]" class="form-label">ID Buku Anak</label>
                                                <select class="form-control" name="id_buku_anak[]" required>
                                                    <option value="">Pilih Buku</option>
                                                    @foreach ($bukuAnak as $bukuItem)
                                                        <option value="{{ $bukuItem->id_buku_anak }}">{{ $bukuItem->judul }} ({{ $bukuItem->id_buku_anak }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="durasi[]" class="form-label">Durasi (Hari)</label>
                                                <select class="form-control" name="durasi[]" required>
                                                    <option value="3">3 Hari</option>
                                                    <option value="5">5 Hari</option>
                                                    <option value="7">7 Hari</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
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
