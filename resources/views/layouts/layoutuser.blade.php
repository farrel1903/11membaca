<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'Shoppers') &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/fonts/icomoon/style.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/aos.css">
    <link rel="stylesheet" href="{{ asset('assets/shoppers') }}/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>
<style>
    .logout-link {
        transition: transform 0.2s;
        /* Tambahkan transisi untuk efek halus */
    }

    .logout-link:hover {
        transform: scale(1.1);
        /* Ubah ukuran saat hover */
    }
</style>

<body>
    <div class="site-wrap">
        <header class="site-navbar" role="banner">
            <div class="site-navbar-top">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6 col-md-4 order-1 order-md-1">
                            <!-- Tambahan elemen atau kosong -->
                        </div>
                        <div class="col-12 mb-3 mb-md-0 col-md-4 order-2 text-center">
                            <div class="site-logo">
                                <a href="{{ url('pengguna/dashboard') }}">
                                    <img src="{{ asset('/assets/img/11logo.png') }}" alt="Logo"
                                        style="max-width: 65%; height: auto;">
                                </a>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 order-3">
                            <div class="site-top-icons text-right">
                                <ul>
                                    <li><a href="{{ url('pengguna/history') }}"><span
                                                class="icon icon-history"></span></a></li>
                                    <li>
                                        <a href="{{ url('pengguna/riwayat') }}" class="site-cart">
                                            <span class="icon icon-book"></span>
                                            {{-- <span
                                                class="count">{{ isset($jumlahEbookDipinjam) ? $jumlahEbookDipinjam : 0 }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="dropdown">
                                        <button class="dropbtn">
                                            <span class="icon icon-person"></span>
                                        </button>
                                        <div class="dropdown-content">
                                            <div class="profile-info" style="text-align: center;">
                                                @if ($member->foto)
                                                    <img src="{{ asset('storage/' . $member->foto) }}"
                                                        alt="Foto Profil" class="profile-photo"
                                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                                @else
                                                    <img src="default-profile.jpg" alt="Default Profile"
                                                        class="profile-photo"
                                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                                @endif
                                                <div class="profile-text" style="margin-top: 10px;">
                                                    <strong>{{ Auth::user()->name }}</strong><br>
                                                    <span>{{ Auth::user()->email }}</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div style="text-align: center;">
                                                <a href="{{ url('pengguna/profile') }}" class="btn btn-primary"
                                                    style="display: inline-block; margin-bottom: 10px; text-decoration: none; color: white;">
                                                    Profil Saya
                                                </a>

                                                <form action="{{ route('logout') }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    <a href="#"
                                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                                        class="logout-link"
                                                        style="text-decoration: none; color: #007bff; padding: 10px 20px; border: none; border-radius: 5px;">
                                                        Logout <i class="fas fa-sign-out-alt"></i>
                                                    </a>
                                                </form>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="d-inline-block d-md-none ml-md-0">
                                        <a href="#" class="site-menu-toggle js-menu-toggle"><span
                                                class="icon-menu"></span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="site-navigation text-right text-md-center" role="navigation">
                <div class="container">
                    <ul class="site-menu js-clone-nav d-none d-md-block">
                        <li class="has-children">
                        <li><a href="{{ url('pengguna/dashboard') }}">Beranda</a></li>
                        </li>
                        <li><a href="{{ route('pengguna.produk.index') }}">Produk</a></li>
                        <li class="has-children">
                            <a href="{{ url('about.html') }}">Tentang</a>
                            <ul class="dropdown">
                                <li><a href="#">Menu One</a></li>
                                <li><a href="#">Menu Two</a></li>
                                <li><a href="#">Menu Three</a></li>
                            </ul>
                        </li>

                        {{-- <li><a href="#">Katalog</a></li>
                        <li><a href="#">New Arrivals</a></li> --}}
                        {{-- <li><a href="{{ url('contact.html') }}">Contact</a></li> --}}
                    </ul>
                </div>
            </nav>
        </header>

        @yield('content')

        <footer class="site-footer border-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="footer-heading mb-4">Navigations</h3>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <ul class="list-unstyled">
                                    <li><a href="#">Sell online</a></li>
                                    <li><a href="#">Features</a></li>
                                    <li><a href="#">Shopping cart</a></li>
                                    <li><a href="#">Store builder</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <ul class="list-unstyled">
                                    <li><a href="#">Mobile commerce</a></li>
                                    <li><a href="#">Dropshipping</a></li>
                                    <li><a href="#">Website development</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <ul class="list-unstyled">
                                    <li><a href="#">Point of sale</a></li>
                                    <li><a href="#">Hardware</a></li>
                                    <li><a href="#">Software</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <h3 class="footer-heading mb-4">Promo</h3>
                        <a href="#" class="block-6">
                            <img src="{{ asset('/assets/img/11logo.png') }}" alt="Image placeholder"
                                class="img-fluid rounded mb-4">
                            <h3 class="font-weight-light mb-0">Read Your Favorite Book</h3>
                            <p>Promo from January 15 &mdash; 25, 2019</p>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="block-5 mb-5">
                            <h3 class="footer-heading mb-4">Contact Info</h3>
                            <ul class="list-unstyled">
                                <li class="address">Jl. Raya Cilember, RT.01/RW.04, Sukaraja, Kec. Cicendo, Kota
                                    Bandung, Jawa Barat 40153</li>
                                <li class="phone"><a href="tel://(022) 6652442">(022) 6652442</a></li>
                                <li class="email">smkn11bdg@gmail.com</li>
                            </ul>
                        </div>
                        <div class="block-7">
                            <form action="#" method="post">
                                <label for="email_subscribe" class="footer-heading">Subscribe</label>
                                <div class="form-group">
                                    <input type="text" class="form-control py-4" id="email_subscribe"
                                        placeholder="Email">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Send">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row pt-5 mt-5 text-center">
                    <div class="col-md-12">
                        <p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script data-cfasync="false"
                                src="{{ asset('assets/shoppers') }}/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | This template is made with <i
                                class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                target="_blank" class="text-primary">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/shoppers') }}/js/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/jquery-ui.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/popper.min.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/aos.js"></script>
    <script src="{{ asset('assets/shoppers') }}/js/main.js"></script>
    <script>
        // Fungsi untuk toggle dropdown
        document.addEventListener("DOMContentLoaded", function() {
            var dropdownBtn = document.querySelector('.dropbtn');
            var dropdownContent = document.querySelector('.dropdown-content');

            // Toggle tampilan dropdown saat tombol diklik
            dropdownBtn.addEventListener('click', function(event) {
                event.preventDefault();
                dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' :
                    'block';
            });

            // Sembunyikan dropdown jika mengklik di luar dropdown
            window.addEventListener('click', function(event) {
                if (!dropdownBtn.contains(event.target) && !dropdownContent.contains(event.target)) {
                    dropdownContent.style.display = 'none';
                }
            });
        });
    </script>


</body>

</html>
