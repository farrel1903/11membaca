@extends('layouts.layoutuser')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong
                        class="text-black">Koleksi Pinjaman Buku</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    @csrf

                    <!-- Tempatkan pesan kesalahan dan notifikasi di sini -->
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <h4>Jumlah Ebook yang Dipinjam: <span class="badge badge-info">{{ $jumlahEbookDipinjam }}</span></h4>

                    <div class="list-group">
                        @foreach ($riwayat as $item)
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-2">
                                        <figure class="block-4-image">
                                            @if ($item->buku)
                                                <a href="{{ route('pengguna.buku.show', $item->buku->id_buku_induk) }}">
                                                    <img src="{{ asset('fotobuku/' . $item->buku->sampul) }}"
                                                        alt="{{ $item->judul }}" class="img-fluid"
                                                        style="max-width: 100px; object-fit: cover;">
                                                </a>
                                            @else
                                                <img src="{{ asset('path/to/default/image.jpg') }}"
                                                    alt="Gambar tidak tersedia" class="img-fluid"
                                                    style="max-width: 100px;">
                                            @endif
                                        </figure>
                                    </div>
                                    <div class="col-md-10">
                                        <h5 class="mt-0">{{ $item->judul }}</h5>
                                        <p><strong>Kategori:</strong> {{ $item->kategori }}</p>
                                        <p><strong>ISBN:</strong> {{ $item->isbn }}</p>
                                        <p><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</p>
                                        <a href="{{ route('pengguna.ebook.read', $item->id_buku_induk) }}"
                                            class="btn btn-primary btn-sm">Baca Kembali</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
