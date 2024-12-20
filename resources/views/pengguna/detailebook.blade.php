@extends('layouts.layoutuser')

@section('title', $buku->judul)

@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <div class="site-wrap">
        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0 d-flex align-items-center">
                        <a href="javascript:history.back()" class="btn btn-link p-0 mr-2" style="text-decoration: none;">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <a href="{{ route('pengguna.produk.index') }}">Produk</a>
                        <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">{{ $buku->judul }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center">
                        <img src="{{ asset('fotobuku/' . $buku->sampul) }}" alt="{{ $buku->judul }}"
                            class="img-fluid rounded" style="max-width: 400px; height: 400px;">
                    </div>

                    <div class="col-md-6">
                        <h2 class="text-black">{{ $buku->judul }}</h2>
                        <p class="text-dark"><strong>ID Buku Induk:</strong> {{ $buku->id_buku_induk }}</p>
                        <p class="text-dark"><strong>Kategori:</strong> {{ $buku->kategori->kategori }}</p>
                        <p class="text-dark"><strong>ISBN:</strong> {{ $buku->ISBN }}</p>
                        <p class="text-dark"><strong>Penulis:</strong> {{ $buku->Penulis }}</p>
                        <p class="text-dark"><strong>Penerbit:</strong> {{ $buku->Penerbit }}</p>
                        <p class="text-dark"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                        <p class="text-dark"><strong>Jumlah Halaman:</strong> {{ $buku->jumlah_halaman }}</p>
                        <p class="text-dark"><strong>Status:</strong> {{ $buku->status }}</p>
                        <!-- Detail status ditambahkan di sini -->

                        <p class="text-dark">
                            <strong>Ebook:</strong>
                            @if ($buku->ebook)
                                <button type="button" class="btn btn-info btn-pinjam" data-id-buku-induk="{{ $buku->id_buku_induk }}">
                                    Pinjam Ebook
                                </button>
                            @else
                                Tidak ada ebook
                            @endif
                        </p>                        

                        <p class="text-dark"><strong>Sinopsis:</strong></p>
                        <div class="p-3 mb-2 bg-light border rounded">
                            <p class="text-dark">{!! nl2br(e($buku->sinopsis)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Peraturan Peminjaman Ebook -->
        <div class="modal fade" id="ebookModal" tabindex="-1" role="dialog" aria-labelledby="ebookModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ebookModalLabel">Peraturan Peminjaman Ebook</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-modal">1. Hanya bisa membaca atau meminjam 10 Ebook dalam satu akun NonPro.</p>
                        <p class="text-modal">2. Dilarang untuk mendownload Ebook.</p>
                        <p class="text-modal">3. Tidak diperkenankan membagikan ebook ke pihak ketiga.</p>
                        <p class="text-modal">4. Jika terdapat masalah dengan ebook, harap segera menghubungi layanan pelanggan.
                        </p>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="agreementCheckbox">
                            <label class="form-check-label" for="agreementCheckbox">
                                Saya setuju dengan peraturan peminjaman ebook
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <form id="borrowForm" action="{{ route('pengguna.pinjam', $buku->id_buku_induk) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            <input type="hidden" name="id_buku_induk" id="id_buku_induk">
                            <button type="submit" class="btn btn-info" id="confirmBorrow" disabled>Pinjam Ebook / Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


 <!-- Modal Batas Peminjaman -->
@if (session('limitReached'))
<div class="modal fade show" id="limitReachedModal" tabindex="-1" role="dialog" aria-labelledby="limitReachedModalLabel" aria-hidden="true" style="display: block; background-color: rgba(0,0,0,0.5); padding-top: 50px;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="limitReachedModalLabel">Peminjaman Maksimal Tercapai</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hideModal()">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body">
                Anda telah mencapai batas pinjam 10 ebook. Hubungi admin untuk upgrade akun Anda agar dapat meminjam lebih banyak Ebook.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Style to hide modal backdrop after closing -->
<style>
    .modal-backdrop {
        display: none;
    }
</style>

<script>
    function hideModal() {
        document.getElementById('limitReachedModal').style.display = 'none';
    }
</script>
@endif



@endsection

<!-- Include FontAwesome and Bootstrap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom CSS for Modal Text -->
<style>
    .text-modal {
        color: #333;
        font-weight: bold;
    }

    .modal-dialog {
        max-width: 600px;
        /* Atur lebar maksimum modal */
        margin-top: 100px;
    }

    .modal {
        z-index: 1050;
        /* Pastikan modal muncul di atas elemen lain */
    }
</style>

{{-- Script untuk mengaktifkan tombol pinjam saat checkbox dicentang --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('agreementCheckbox');
        const confirmButton = document.getElementById('confirmBorrow');

        checkbox.addEventListener('change', function() {
            confirmButton.disabled = !checkbox.checked;
        });

        confirmButton.addEventListener('click', function() {
            const form = document.getElementById('borrowForm');
            form.submit(); // Kirim formulir setelah mengklik tombol "Next"
        });

        // const modalElement = document.getElementById('ebookModal'); 

        // modalElement.addEventListener('shown.bs.modal', function () {
            
        //     console.log('Modal sedang ditampilkan');
        // });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttonPinjamElements = document.getElementsByClassName('btn-pinjam'); // Ambil semua tombol dengan class 'btn-pinjam'
        const modalPinjamElement = document.getElementById('ebookModal'); // Ambil modal berdasarkan ID
        const idBukuIndukElement = document.getElementById('id_buku_induk'); // Input hidden dalam modal

        Array.from(buttonPinjamElements).forEach(function (button) {
            button.addEventListener('click', function () {
                // Ambil data ID buku induk dari atribut data pada tombol
                const idBukuInduk = button.getAttribute('data-id-buku-induk');

                // Set nilai ID buku induk ke input hidden di dalam modal
                idBukuIndukElement.value = idBukuInduk;

                // Tampilkan modal menggunakan Bootstrap Modal API
                const bootstrapModal = new bootstrap.Modal(modalPinjamElement);
                bootstrapModal.show();
            });
        });
    });
</script>
