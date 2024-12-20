@extends('layouts.layoutuser')

@section('title', 'Daftar Buku')

@section('content')
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <!-- Sidebar Kategori -->
                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategori</h3>
                        <ul class="list-unstyled mb-0">
                            @foreach ($kategori as $k)
                                <li class="mb-1">
                                    <a href="{{ route('pengguna.kategori.filter', $k->kategori_id) }}" class="d-flex">
                                        <span>{{ $k->kategori }}</span>
                                        <span class="text-black ml-auto">({{ $k->bukus_count }})</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-9 order-2">

                    <!-- Search Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form id="searchForm" action="{{ route('pengguna.produk.search') }}" method="GET"
                                class="site-block-top-search d-flex flex-column align-items-start">

                                <!-- Kriteria Pencarian -->
                                <select id="criteriaSelect" name="filter" class="form-select form-select-sm me-2"
                                    style="width: 180px;">
                                    <option value="" disabled selected>Kriteria Pencarian Buku</option>
                                    <option value="judul">Judul Buku</option>
                                    <option value="Penulis">Penulis</option>
                                    <option value="kategori">Kategori</option>
                                </select>

                                <!-- Input Search dan Tombol -->
                                <div class="input-group mt-3" style="width: 100%;">
                                    <input type="text" id="keywordInput" name="query" class="form-control border-0"
                                        placeholder="Cari Buku"
                                        style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 4px;"
                                        value="{{ request()->input('query') }}">
                                    <div class="input-group-append">
                                        <button id="searchButton"
                                            class="btn btn-primary btn-lg d-flex align-items-center justify-content-center"
                                            type="submit" disabled style="padding: 8px 16px;">
                                            <span class="icon icon-search2" style="font-size: 1.2em;"></span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Teks Peringatan dengan warna lebih lembut -->
                                <small style="color: rgba(240, 28, 28, 0.66); margin-top: 8px; display: block;">*Pilih
                                    terlebih dahulu kriteria pencarian</small>

                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-md-left mb-4">
                                <h2 class="text-black h5">Katalog Buku</h2>
                            </div>
                        </div>
                    </div>

                    <!-- Buku Loop -->
                    <div class="row mb-5">
                        @foreach ($buku as $b)
                            <div class="col-7 col-md-3 mb-4">
                                <div class="block-4 text-center border card-shadow"
                                    style="padding: 10px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                    <figure class="block-4-image">
                                        <img src="{{ asset('fotobuku/' . $b->sampul) }}" alt="{{ $b->judul }} "
                                            class="img-fluid" style="max-height: 200px; object-fit: cover;">
                                    </figure>
                                    <div class="block-4-text p-2" style="flex: 1; display: flex; flex-direction: column;">
                                        <h3 class="judul-buku" style="font-size: 14px; flex-grow: 1;">
                                            {{ $b->judul }}
                                        </h3>
                                        <p class="mb-0" style="font-size: 12px;">{{ $b->Penulis }}</p>
                                        <p class="text-primary font-weight-bold" style="font-size: 14px;">
                                            {{ $b->kategori->kategori ?? 'Tidak ada kategori' }}
                                        </p>
                                        <a href="javascript:void(0);" class="btn btn-primary mt-2 pinjamBuku"
                                            data-toggle="modal" data-target="#detailBukuModal"
                                            data-id="{{ $b->id_buku_induk }}" data-judul="{{ $b->judul }} "
                                            data-penulis="{{ $b->Penulis ?? 'Tidak ada penulis' }}"
                                            data-kategori="{{ $b->kategori ? $b->kategori->kategori : 'Tidak ada kategori' }}"
                                            data-penerbit="{{ $b->Penerbit }}"
                                            data-sampul="{{ asset('fotobuku/' . $b->sampul) }}"
                                            data-status="{{ $b->status }}" style="font-size: 12px;">Pinjam Buku</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Custom Pagination -->
                    <div class="row" data-aos="fade-up">
                        <div class="col-md-12 text-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <!-- Tombol Previous -->
                                    @if ($buku->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $buku->previousPageUrl() }}"
                                                aria-label="Previous">
                                                Previous
                                            </a>
                                        </li>
                                    @endif

                                    <!-- Nomor Halaman -->
                                    @for ($i = 1; $i <= $buku->lastPage(); $i++)
                                        <li class="page-item {{ $buku->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $buku->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    <!-- Tombol Next -->
                                    @if ($buku->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $buku->nextPageUrl() }}" aria-label="Next">
                                                Next
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    {{-- MODAL --}}
    <!-- Modal untuk Detail Buku -->
    <div class="modal fade" id="detailBukuModal" tabindex="-1" aria-labelledby="detailBukuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailBukuModalLabel">Detail Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="modalSampulBuku" src="" alt="Sampul Buku" class="img-fluid mb-3"
                            style="max-height: 200px;">
                    </div>
                    <h5>Judul: <span id="modalJudulBuku"></span></h5>
                    <h6>Penulis: <span id="modalPenulisBuku"></span></h6>
                    <h6>Kategori: <span id="modalKategoriBuku"></span></h6>
                    <h6>Penerbit: <span id="modalPenerbitBuku"></span></h6>
                </div>
                <div class="modal-footer">
                    <!-- Tombol Pinjam Ebook -->
                    <a href="#" id="pinjamEbook" class="btn btn-primary">Pinjam Ebook</a>
                    <!-- Tombol Pinjam Offline yang hanya muncul jika status buku offline -->
                    <a href="" id="pinjamOffline" class="btn btn-secondary">Pinjam Offline</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk Alert Pinjam Offline -->
    <div class="modal fade" id="offlineAlertModal" tabindex="-1" aria-labelledby="offlineAlertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered"> <!-- Tambahkan class modal-dialog-centered -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offlineAlertModalLabel">Peringatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <b> Maaf, anda bukan warga SMKN 11 Bandung.</b> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


@endsection

<!-- Custom CSS -->
<style>
    .block-4 {
        height: 100%;
    }

    .judul-buku {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-height: 3.5em;
    }

    #criteriaSelect {
        color: #555;
        /* Gunakan warna abu-abu tua agar tidak terlalu pekat */
        font-weight: normal;
        /* Sesuaikan ketebalan teks jika perlu */
    }

    #criteriaSelect option[disabled] {
        color: #888;
        /* Gunakan warna abu-abu muda untuk opsi yang tidak aktif */
    }

    #keywordInput {
        border: 1px solid #ddd;
        /* Memberikan border pada input */
        border-radius: 4px;
        /* Opsional, untuk memperhalus sudut input */
    }

    #warningText {
        font-size: 12px;
        margin-top: 5px;
        display: none;
        /* Mulai dengan menyembunyikan teks peringatan */
    }

    /* Custom Pagination */
    .pagination {
        display: inline-block;
        margin-top: 20px;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-item .page-link {
        padding: 8px 15px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
        color: #007bff;
        background-color: #f8f9fa;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        background-color: #e9ecef;
        border-color: #e9ecef;
    }

    .pagination .page-item .page-link:hover {
        background-color: #007bff;
        color: white;
        text-decoration: none;
    }
</style>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    // Event listener untuk setiap buku
    $(document).on('click', '.pinjamBuku', function() {
        var idBuku = $(this).data('id'); // Ambil id_buku_induk
        var judulBuku = $(this).data('judul');
        var penulisBuku = $(this).data('penulis');
        var kategoriBuku = $(this).data('kategori');
        var penerbitBuku = $(this).data('penerbit');
        var sampulBuku = $(this).data('sampul');
        var statusBuku = $(this).data('status'); // Ambil status buku ('online', 'offline', 'full')
        var filePdf = $(this).data('pdf');

        // Mengisi modal dengan informasi buku yang dipilih
        $('#modalJudulBuku').text(judulBuku);
        $('#modalPenulisBuku').text(penulisBuku);
        $('#modalKategoriBuku').text(kategoriBuku);
        $('#modalPenerbitBuku').text(penerbitBuku);
        $('#modalSampulBuku').attr('src', sampulBuku);

        // Mengatur tautan dinamis untuk tombol "Pinjam Ebook"
        $('#pinjamEbook').attr('href', '{{ url('pengguna/buku') }}/' + idBuku + '/detail');

        // Reset visibilitas tombol
        $('#pinjamOffline').show(); // Tampilkan tombol "Pinjam Offline"
        $('#pinjamEbook').show(); // Tampilkan tombol "Pinjam Ebook"

        if (statusBuku === 'online') {
            // Jika buku berstatus online, sembunyikan tombol "Pinjam Offline"
            $('#pinjamOffline').hide();
            $('#pinjamEbook').attr('href', '{{ url('pengguna/buku') }}/' + idBuku + '/detail');
        } else if (statusBuku === 'offline') {
            // Jika buku berstatus offline, sembunyikan tombol "Pinjam Ebook"
            $('#pinjamEbook').hide();
            $('#pinjamOffline').attr('href', '{{ url('pengguna/buku') }}/' + idBuku + '/pinjam-offline');
        } else if (statusBuku === 'full') {
            // Jika buku berstatus full
            $('#pinjamEbook').attr('href', '{{ url('pengguna/buku') }}/' + idBuku + '/detail');
            $('#pinjamOffline').attr('href', '{{ url('pengguna/buku') }}/' + idBuku + '/pinjam-offline');
        }

        // Logika untuk menampilkan modal peringatan untuk user General saat pinjam offline
        var userStatus = "{{ Auth::user()->status }}"; // Ambil status user

        if (userStatus === 'General') {
            $('#pinjamOffline').attr('href', '#').on('click', function(event) {
                event.preventDefault();
                $('#offlineAlertModal').modal('show');
            });
        } else {
            // Jika bukan General, izinkan pinjaman offline jika buku statusnya offline atau full
            if (statusBuku === 'offline' || statusBuku === 'full') {
                $('#pinjamOffline').attr('href', '{{ url('pengguna/buku') }}/' + idBuku + '/pinjamoffline');
            } else {
                $('#pinjamOffline')
                    .hide(); // Sembunyikan tombol "Pinjam Offline" jika tidak bisa dipinjam offline
            }
        }

        // Menampilkan modal detail buku
        $('#detailBukuModal').modal('show');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const criteriaSelect = document.getElementById('criteriaSelect');
        const searchButton = document.getElementById('searchButton');

        // Fungsi untuk mengaktifkan atau menonaktifkan tombol pencarian
        function toggleSearchButton() {
            searchButton.disabled = !criteriaSelect.value; // Aktifkan tombol jika ada kriteria yang dipilih
        }

        // Event listener untuk mendeteksi perubahan pada select
        criteriaSelect.addEventListener('change', toggleSearchButton);

        // Jalankan fungsi saat halaman dimuat untuk memastikan tombol tetap sesuai kondisi
        toggleSearchButton();
    });
</script>
