@extends('layouts.mainadmin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container">
                <div class="row">
                    {{-- Tombol Tambah Member (jika dibutuhkan di masa depan) --}}
                    {{-- <div class="col-md-7">
                        <form action="{{ route('member.create') }}" method="GET">
                            @csrf
                            <div class="mb-3" style="padding: 15px">
                                <button type="submit" class="btn btn-warning">Tambah Member</button>
                            </div>
                        </form>
                    </div> --}}
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Daftar Member
                    </div>
                
                    <div class="card-body">
                        <form action="{{ route('admin.member.search') }}" method="GET"
                            class="d-flex align-items-center mb-3">
                            @csrf
                            <select name="filter" class="form-select form-select-sm me-2" id="filter-option">
                                <option value="" disabled selected>Cari Member Berdasarkan Kriteria</option>
                                <option value="nama">Nama</option>
                                <option value="nis_nik">NIS/NIK</option>
                                <option value="id_user">ID User</option>
                                <option value="no_telepon">No Telepon</option>
                                <option value="asal_sekolah">Asal Sekolah</option>
                            </select>
                
                            <input type="text" name="search" class="form-control form-control-sm me-2"
                                placeholder="Cari Member" value="{{ request('search') }}">
                            <select name="status" class="form-select form-select-sm me-2" id="filter-status">
                                <option value="">Semua Status</option>
                                <option value="Full" {{ request('status') == 'Full' ? 'selected' : '' }}>Full</option>
                                <option value="General" {{ request('status') == 'General' ? 'selected' : '' }}>General
                                </option>
                                <option value="Pegawai" {{ request('status') == 'Pegawai' ? 'selected' : '' }}>Pegawai
                                </option>
                            </select>
                            <button type="submit" class="btn btn-info btn btn-warning">
                                <i class="fas fa-search"></i>
                                <span class="visually-hidden">Cari</span>
                            </button>
                        </form>
                
                        <h4>Jumlah Total Member: <span class="badge badge-info"
                                style="color: black; background-color:cornflowerblue;">{{ count($members) }}</span></h4>
                        <form id="update-form">
                            @csrf
                            <div class="table-responsive">
                                <table id="tabel-member" class="table table-dark table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th scope="col">
                                                <input type="checkbox" id="select-all">
                                            </th>
                                            <th scope="col">NIS/NIK</th>
                                            <th scope="col">ID User</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">No Telepon</th>
                                            <th scope="col">Asal Sekolah</th>
                                            <th scope="col">Tingkatan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th> <!-- Kolom Action ditambahkan -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($members as $member)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" name="selected_members[]"
                                                        value="{{ $member->id_user }}" class="member-checkbox">
                                                </td>
                                                <td>{{ $member->nis_nik }}</td>
                                                <td>{{ $member->id_user }}</td>
                                                <td>{{ $member->nama }}</td>
                                                <td>{{ $member->jenis_kelamin }}</td>
                                                <td>{{ $member->no_telepon }}</td>
                                                <td>{{ $member->asal_sekolah }}</td>
                                                <td>{{ $member->tingkatan }}</td>
                                                <td>{{ $member->status }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.member.detail', $member->id_user) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-info-circle"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada hasil yang ditemukan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <select id="new-tingkatan" class="form-select form-select-sm me-2">
                                        <option value="">Pilih Tingkatan Baru</option>
                                        <option value="NonPro">NonPro</option>
                                        <option value="Pro">Pro</option>
                                    </select>
                                    <select id="new-status" class="form-select form-select-sm">
                                        <option value="">Pilih Status Baru</option>
                                        <option value="Full">Full</option>
                                        <option value="General">General</option>
                                        {{-- <option value="Pegawai">Pegawai</option> --}}
                                    </select>
                                </div>
                                <button type="button" id="update-selected" class="btn btn-warning">
                                    <i class="fas fa-sync"></i> Update Terpilih
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>a
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#tabel-member').DataTable({
            "paging": true,
            "searching": false,
            "ordering": true,
            "info": true
        });

        // Filter berdasarkan status
        $('#filter-status').on('change', function() {
            var selectedStatus = $(this).val();
            table.column(8).search(selectedStatus).draw(); // Kolom 8 adalah kolom Status
        });

        // Select/Deselect all checkboxes
        $('#select-all').on('click', function() {
            $('input[name="selected_members[]"]').prop('checked', this.checked);
        });
    });




    $(document).ready(function() {
        // Select/Deselect all checkboxes
        $('#select-all').on('click', function() {
            $('.member-checkbox').prop('checked', this.checked);
        });

        // Handle update button click
        $('#update-selected').on('click', function() {
            var selectedMembers = [];
            $('.member-checkbox:checked').each(function() {
                selectedMembers.push($(this).val());
            });

            var newStatus = $('#new-status').val();
            var newTingkatan = $('#new-tingkatan').val();

            if (selectedMembers.length === 0) {
                alert("Pilih minimal satu member untuk diupdate.");
                return;
            }

            if (!newStatus && !newTingkatan) {
                alert("Pilih status atau tingkatan baru untuk melanjutkan.");
                return;
            }

            // Send AJAX request
            $.ajax({
                url: "{{ route('admin.member.update_multiple') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    selected_members: selectedMembers,
                    new_status: newStatus,
                    new_tingkatan: newTingkatan
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Reload page to reflect changes
                    } else {
                        alert("Terjadi kesalahan saat memperbarui anggota.");
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("Terjadi kesalahan. Silakan coba lagi.");
                }
            });
        });
    });
</script>
