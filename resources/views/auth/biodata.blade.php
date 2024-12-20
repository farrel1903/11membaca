@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Biodata') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('biodata.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Input untuk NIK -->
                            <div class="mb-3">
                                <label for="nis_nik" class="form-label">NIS_NIK</label>
                                <input id="nis_nik" type="text" class="form-control @error('nis_nik') is-invalid @enderror"
                                name="nis_nik" value="{{ old('nis_nik') }}" required autocomplete="nis_nik"
                                placeholder="isi kolom dengan 16 digit angka sesuai ketentuan NIK">
                            @error('nis_nik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            
                            </div>

                            <!-- Input untuk Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    name="jenis_kelamin" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Input untuk Nomor Telepon -->
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                <input id="no_telepon" type="text"
                                    class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon"
                                    value="{{ old('no_telepon') }}" required autocomplete="no_telepon">
                                @error('no_telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                <input id="asal_sekolah" type="text"
                                    class="form-control @error('asal_sekolah') is-invalid @enderror" name="asal_sekolah"
                                    value="{{ old('asal_sekolah') }}" required autocomplete="asal_sekolah">
                                @error('asal_sekolah')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Jika Anda sudah lulus, isi dengan format "umum".</small>
                            </div>                            

                            <!-- Input untuk Foto -->
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Simpan Biodata</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
