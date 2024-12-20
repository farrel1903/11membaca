@extends('layouts.mainadmin')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <!-- Card for Member Detail -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i>
                        Detail Member
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Member Photo -->
                            <div class="col-md-4 mb-3">
                                @if($member->foto)
                                    <img src="{{ asset('storage/' . $member->foto) }}" alt="Foto Member" class="img-fluid rounded"
                                    style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="Foto Member" class="img-fluid rounded">
                                @endif
                            </div>
                            <!-- Member Details -->
                            <div class="col-md-8 mb-3">
                                <h5 class="card-title mb-3">{{ $member->nama }}</h5>
                                <div class="row mb-2">
                                    <!-- NIS / NIK -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>NIS / NIK:</strong> {{ $member->nis_nik }}</p>
                                    </div>
                                    <!-- ID User -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>ID User:</strong> {{ $member->id_user }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Jenis Kelamin -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Jenis Kelamin:</strong> {{ $member->jenis_kelamin }}</p>
                                    </div>
                                    <!-- No Telepon -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>No Telepon:</strong> {{ $member->no_telepon }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Status -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Status:</strong> {{ $member->status }}</p>
                                    </div>
                                    <!-- Asal Sekolah -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Asal Sekolah:</strong> {{ $member->asal_sekolah }}</p>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <!-- Tingkatan -->
                                    <div class="col-6">
                                        <p class="card-text"><strong>Tingkatan:</strong> {{ $member->tingkatan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Buttons -->
                        <div class="mt-3">
                            <a href="{{ route('admin.member.edit', $member->nis_nik) }}" class="btn btn-primary me-2">Edit</a>
                            <a href="{{ route('admin.member.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
