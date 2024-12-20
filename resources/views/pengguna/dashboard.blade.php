@extends('layouts.layoutuser')

@section('title', 'Halaman Baru')

@section('content')
    <!-- Bagian landing page -->
    <style>
        .chart-canvas {
            width: 100% !important;
            /* Mengatur lebar untuk mengikuti kontainer */
            height: auto !important;
            /* Menjaga rasio aspek */
            max-width: 330px;
            /* Ukuran maksimal sesuai keinginan */
        }

        .modal {
            z-index: 1050;
        }
    </style>
    <div class="site-blocks-cover" style="background-image: url('{{ asset('assets/img/landingpage.png') }}');" data-aos="fade">
        <div class="container">
            <div class="row align-items-start align-items-md-center justify-content-end">
                <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                    <h1 class="mb-2">Jelajahi Berbagai Cerita, Kapan Saja, Dimana Saja</h1>
                    <div class="intro-text text-center text-md-left">
                        <p class="mb-4">
                            Di Perpus Sebelas, nikmati ribuan buku dari klasik hingga terbaru yang bisa diakses kapan saja,
                            di mana saja, dari perangkat apa pun. Bacaan Anda, mudah dan fleksibel.
                        </p>
                        <p>
                            <a href="{{ route('pengguna.produk.index') }}" class="btn btn-sm btn-primary">Baca Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian ikon dan penjelasan -->
    <div class="site-section site-section-sm site-blocks-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-suitcase"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Akses Instan</h2>
                        <p>Mulai membaca buku favorit Anda dalam hitungan detik, tanpa menunggu atau biaya tambahan.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-star"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Baca Fleksibel</h2>
                        <p>Nikmati pengalaman membaca di berbagai perangkat smartphone, tablet, atau komputer kapan saja dan
                            di mana saja, sesuai keinginan Anda.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon mr-4 align-self-start">
                        <span class="icon-link"></span>
                    </div>
                    <div class="text">
                        <h2 class="text-uppercase">Koleksi Luas</h2>
                        <p>Temukan ribuan buku dari berbagai genre dan kategori, selalu diperbarui dengan judul terbaru
                            untuk kepuasan membaca yang maksimal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik bulat -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Grafik 1: Persentase Ebook Sedang Dibaca -->
            <div class="col-md-6 mb-4 d-flex flex-column align-items-center">
                <h4 class="text-center">Statistik Ebook Sering Dibaca - Online</h4>
                <canvas id="riwayatEbookPieChart" class="chart-canvas mt-2"></canvas>
            </div>

            <!-- Grafik 2: Persentase Buku Offline Dipinjam -->
            <div class="col-md-6 mb-4 d-flex flex-column align-items-center">
                <h4 class="text-center">Statistik Buku Sering Dipinjam - Offline</h4>
                <canvas id="chartBukuOffline" class="chart-canvas mt-2"></canvas>
            </div>
        </div>
    </div>

    <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Featured Books</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @foreach ($buku as $b)
                            <div class="item" style="max-width: 350px;"> <!-- Mengatur ukuran maksimal item -->
                                <div class="block-4 text-center card-shadow">
                                    <figure class="block-4-image">
                                        <img src="{{ asset('fotobuku/' . $b->sampul) }}" alt="Image placeholder"
                                            class="img-fluid carousel-img" style="max-height: 290px;">
                                    </figure>
                                    <div class="block-4-text p-2"> <!-- Mengurangi padding -->
                                        <h3 style="font-size: 16px;"><a href="#">{{ $b->judul }}</a></h3>
                                        <p class="mb-0" style="font-size: 14px;">Kategori:
                                            {{ $b->kategori ? $b->kategori->kategori : 'Tidak ada kategori' }}</p>
                                        <a href="javascript:void(0);" class="btn btn-primary mt-2 pinjamBuku"
                                            data-toggle="modal" data-target="#detailBukuModal"
                                            data-id="{{ $b->id_buku_induk }}" data-judul="{{ $b->judul }}"
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
                </div>
            </div>
        </div>
    </div>

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
                    <a href="" id="pinjamEbook" class="btn btn-primary">Pinjam Ebook</a>
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
                    <p> <b> Maaf, anda bukan warga SMKN 11 Bandung.

                            Silahkan Hubungi Admin Jika Ingin Melakukan Peminjaman Offline</b> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Grafik data -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mengambil data dari controller
var pieChartData = @json($pieChartData);

// Menyiapkan data untuk chart
var labels = pieChartData.map(function(item) {
    return item.label;  // Label buku
});

var dataValues = pieChartData.map(function(item) {
    return item.value;  // Jumlah peminjaman
});

// Inisialisasi pie chart untuk Buku Offline (menggunakan warna dan legend seperti ebook)
var ctx = document.getElementById('chartBukuOffline').getContext('2d');
var bookBorrowPieChart = new Chart(ctx, {
    type: 'pie',  // Tipe chart pie
    data: {
        labels: labels,
        datasets: [{
            label: 'Jumlah Peminjaman Buku',
            data: dataValues,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)', 
                'rgba(54, 162, 235, 0.2)', 
                'rgba(255, 206, 86, 0.2)', 
                'rgba(75, 192, 192, 0.2)', 
                'rgba(153, 102, 255, 0.2)', 
                'rgba(255, 159, 64, 0.2)', 
                'rgba(255, 99, 132, 0.2)', 
                'rgba(54, 162, 235, 0.2)', 
                'rgba(255, 206, 86, 0.2)', 
                'rgba(75, 192, 192, 0.2)'
            ],  // Warna masing-masing bagian
            borderColor: [
                'rgba(255, 99, 132, 1)', 
                'rgba(54, 162, 235, 1)', 
                'rgba(255, 206, 86, 1)', 
                'rgba(75, 192, 192, 1)', 
                'rgba(153, 102, 255, 1)', 
                'rgba(255, 159, 64, 1)', 
                'rgba(255, 99, 132, 1)', 
                'rgba(54, 162, 235, 1)', 
                'rgba(255, 206, 86, 1)', 
                'rgba(75, 192, 192, 1)'
            ], // warna border masing-masing bagian
            borderWidth: 2,  // Ketebalan border
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',  // Legend di bawah
                padding: 10,  // Mengatur jarak legend dari grafik
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw + ' peminjaman';
                    }
                }
            }
        }
    }
});

// Data untuk grafik Ebook
const labelsEbook = @json($bukuOnline->pluck('judul'));
const dataEbook = @json($bukuOnline->pluck('riwayat_count'));
const totalEbook = {{ $totalOnline }};

// Pastikan totalEbook tidak nol untuk menghindari pembagian nol
const finalEbookData = totalEbook > 0 ? dataEbook : Array(labelsEbook.length).fill(0);

// Grafik Ebook
var ctxEbook = document.getElementById('riwayatEbookPieChart').getContext('2d');
var riwayatEbookPieChart = new Chart(ctxEbook, {
    type: 'pie', // Menggunakan pie chart
    data: {
        labels: labelsEbook,
        datasets: [{
            label: 'Jumlah Peminjaman Buku',
            data: finalEbookData,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)', 
                'rgba(54, 162, 235, 0.2)', 
                'rgba(255, 206, 86, 0.2)', 
                'rgba(75, 192, 192, 0.2)', 
                'rgba(153, 102, 255, 0.2)', 
                'rgba(255, 159, 64, 0.2)', 
                'rgba(255, 99, 132, 0.2)', 
                'rgba(54, 162, 235, 0.2)', 
                'rgba(255, 206, 86, 0.2)', 
                'rgba(75, 192, 192, 0.2)'
            ],  // Warna yang sama dengan chart offline untuk konsistensi
            borderColor: [
                'rgba(255, 99, 132, 1)', 
                'rgba(54, 162, 235, 1)', 
                'rgba(255, 206, 86, 1)', 
                'rgba(75, 192, 192, 1)', 
                'rgba(153, 102, 255, 1)', 
                'rgba(255, 159, 64, 1)', 
                'rgba(255, 99, 132, 1)', 
                'rgba(54, 162, 235, 1)', 
                'rgba(255, 206, 86, 1)', 
                'rgba(75, 192, 192, 1)'
            ], // warna border masing-masing bagian
            borderWidth: 2,  // Ketebalan border
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',  // Posisikan legend di bawah grafik
                padding: 10, // Mengatur jarak legend dari grafik
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw + ' peminjaman';
                    }
                }
            }
        }
    }
});




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
    </script>

@endsection
