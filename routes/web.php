<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EbookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\RakController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\JenisDendaController;
use App\Http\Controllers\Admin\HistoriOfflineController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\TransaksiDetailController;
use App\Http\Controllers\Admin\BukuAnakController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DetailBukuController;
use App\Http\Controllers\Pengguna\DashboardController;
use App\Http\Controllers\Pengguna\DetailEbookController;
use App\Http\Controllers\Pengguna\HistoriOnlineController;
use App\Http\Controllers\Pengguna\ProfileController;
use App\Http\Controllers\Pengguna\ProdukController;
use App\Http\Controllers\Pengguna\RatingController;
use App\Http\Controllers\Pengguna\EbookReadController;
use App\Http\Controllers\Pengguna\PeminjamanController;
use App\Http\Controllers\Pengguna\RiwayatController;
use App\Http\Controllers\Pengguna\RiwayatOfflineController;
use App\Http\Controllers\Kepala\RekapOnlineController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\Auth\BiodataController;
use App\Exports\RiwayatExport;
use App\Models\Historionline;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pengguna/dashboard', [PenggunaController::class, 'index'])->name('pengguna.dashboard');

Auth::routes();

// Halaman Home (dapat diakses setelah login)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/riwayat/export', function () {
        return Excel::download(new RiwayatExport, 'rekap-peminjaman-ebook.xlsx');
    })->name('riwayat.export');



    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id_user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id_user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/destroy/{id_user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');



    // Rute untuk Buku
    Route::get('/admin/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/admin/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/admin/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/admin/buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/admin/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/admin/buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
    Route::get('/admin/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/admin/buku/{id}/detail', [DetailBukuController::class, 'show'])->name('buku.show');

    // Rute untuk Buku Anak
    Route::get('/admin/bukuanak', [BukuAnakController::class, 'index'])->name('bukuanak.index');
    Route::get('/admin/bukuanak/create', [BukuAnakController::class, 'create'])->name('bukuanak.create');
    Route::post('/admin/bukuanak', [BukuAnakController::class, 'store'])->name('bukuanak.store');
    Route::get('/admin/bukuanak/search', [BukuAnakController::class, 'search'])->name('bukuanak.search');
    Route::delete('/admin/bukuanak/{id}', [BukuAnakController::class, 'destroy'])->name('bukuanak.destroy');

    // Rute untuk Ebooks
    Route::get('/admin/ebooks/create', [EbookController::class, 'create'])->name('ebooks.create');
    Route::get('/admin/ebooks/{id}/edit', [EbookController::class, 'edit'])->name('ebooks.edit');
    Route::put('/admin/ebooks/{id}', [EbookController::class, 'update'])->name('ebooks.update');
    Route::delete('/ebook/{id}', [EbookController::class, 'destroy'])->name('ebook.destroy');
    Route::post('storeebook', [EbookController::class, 'store'])->name('storeebook');
    Route::get('/admin/ebooks/search', [EbookController::class, 'search'])->name('ebooks.search');
    Route::resource('ebooks', EbookController::class);

    // Rute untuk kategori
    Route::resource('categories', CategoryController::class);
    Route::get('categories/search', [CategoryController::class, 'search'])->name('category.search');
    Route::get('/admin/kategori', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/add/category1', [CategoryController::class, 'store_category'])->name('storecategor');
    Route::get('/add/category', [CategoryController::class, 'category'])->name('addcategor');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/admin/addebook', [CategoryController::class, 'create'])->name('addebook.create');
    Route::get('/admin/kategori/search', [CategoryController::class, 'search'])->name('category.search');

    // Rute untuk Member
    Route::get('/admin/member', [MemberController::class, 'index'])->name('admin.member.index');
    Route::get('/admin/member/create', [MemberController::class, 'create'])->name('admin.member.create');
    Route::post('/admin/member', [MemberController::class, 'store'])->name('admin.member.store');
    Route::get('/admin/member/{id_user}/edit', [MemberController::class, 'edit'])->name('admin.member.edit');
    Route::put('/admin/member/{id_user}', [MemberController::class, 'update'])->name('admin.member.update');
    Route::delete('/admin/member/{id_user}', [MemberController::class, 'destroy'])->name('admin.member.destroy');
    Route::get('/admin/member/search', [MemberController::class, 'search'])->name('admin.member.search');
    Route::post('/admin/member/update-multiple', [MemberController::class, 'updateMultiple'])->name('admin.member.update_multiple');
    Route::get('/admin/member/{id_user}/detail', [MemberController::class, 'showdetail'])->name('admin.member.detail');




    // Rute untuk siswa
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::delete('/admin/siswa/{nis}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/admin/addsiswa', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/admin/addsiswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/admin/addsiswa/{nis}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/admin/addsiswa/{nis}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::get('/admin/siswa/search', [SiswaController::class, 'search'])->name('siswa.search');

    // Rute untuk Rak
    Route::get('/admin/rak', [RakController::class, 'index'])->name('rak.index');
    Route::get('/admin/rak/create', [RakController::class, 'create'])->name('rak.create');
    Route::post('/admin/rak', [RakController::class, 'store'])->name('rak.store');
    Route::get('/admin/rak/{id_rak}', [RakController::class, 'show'])->name('rak.show');
    Route::get('/admin/rak/{id_rak}/edit', [RakController::class, 'edit'])->name('rak.edit');
    Route::put('/admin/rak/{id_rak}', [RakController::class, 'update'])->name('rak.update');
    Route::delete('/admin/rak/{id_rak}', [RakController::class, 'destroy'])->name('rak.destroy');
    Route::get('/admin/rak/search', [RakController::class, 'search'])->name('rak.search');

    Route::get('/admin/peminjamanonline', [RiwayatController::class, 'peminjamanOnline'])->name('peminjaman.online');
    Route::get('/riwayat/create', [RiwayatController::class, 'create'])->name('riwayat.create');
    // Rute untuk menyimpan peminjaman ebook
    Route::post('/riwayat', [RiwayatController::class, 'pinjamEbook'])->name('riwayat.store');
    Route::get('/riwayat/search', [RiwayatController::class, 'search'])->name('riwayat.search');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
    Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');



    // Route::resource('transaksi', TransaksiController::class);

    Route::post('/historioffline/{id_pinjam}/return', [HistoriOfflineController::class, 'returnBook'])->name('historioffline.return');
    // Route untuk menampilkan halaman peminjaman offline
    Route::get('/admin/peminjamanoffline', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/admin/addpeminjamanoffline', [TransaksiController::class, 'create'])->name('peminjamanoffline.create');
    Route::get('/admin/export-peminjamanoffline', [TransaksiController::class, 'export'])->name('transaksi.export');
    


    // Ubah rute pencarian untuk mengarah ke index
    Route::get('/admin/transaksi/search', [TransaksiController::class, 'index'])->name('transaksi.search');


    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store'); // Simpan transaksi

    Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');

    Route::delete('/transaksi/{id}', [TransaksiDetailController::class, 'destroy'])->name('transaksi.destroy');
    Route::get('transaksi/{id}', [TransaksiDetailController::class, 'showdetail'])->name('transaksi.show');
    Route::post('/transaksi/return', [TransaksiDetailController::class, 'return'])->name('transaksi.return');




    Route::get('admin/jenisdenda', [JenisDendaController::class, 'index'])->name('jenis_denda.index');


});






Route::middleware(['auth', 'role:0'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Pengguna\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengguna/dashboard', [PenggunaController::class, 'index'])->name('pengguna.dashboard');
    Route::get('/pengguna/riwayat', [RiwayatController::class, 'index'])->name('pengguna.riwayat.index');
    Route::get('/pengguna/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/pengguna/editprofile', [ProfileController::class, 'edit'])->name('profile.edit'); // Ini untuk menampilkan form edit
    Route::put('/pengguna/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/pengguna/history', [RiwayatOfflineController::class, 'showDetail'])->name('pengguna.history');
    Route::get('/pengguna/buku/{id}/detail', [DetailEbookController::class, 'show'])->name('pengguna.buku.show');
    Route::get('/pengguna/buku/{id}/pinjamoffline', [DetailEbookController::class, 'pinjam'])->name('pengguna.buku.pinjamoffline');

    Route::post('/rating/store', [RatingController::class, 'store'])->name('rating.store');

    Route::post('/pengguna/pinjam/{id}', [PeminjamanController::class, 'pinjamEbook'])->name('pengguna.pinjam');
    Route::get('/pengguna/ebook/{id}', [EbookReadController::class, 'read'])->name('pengguna.ebook.read');


    Route::get('/pengguna/detailbuku', function () {
        return view('pengguna.detailbuku');
    });
    Route::get('/pengguna/produk', [ProdukController::class, 'index'])->name('pengguna.produk.index');
    Route::get('/produk/search', [ProdukController::class, 'search'])->name('pengguna.produk.search');
    Route::get('/dashboard', [App\Http\Controllers\Pengguna\DashboardController::class, 'index'])->name('dashboard');


    // Rute untuk menyimpan, menampilkan, memperbarui, dan menghapus riwayat peminjaman
    Route::post('/historionline', [HistoriOnlineController::class, 'store'])->name('history.store');
    Route::get('/historionline/{id_pinjam}', [HistoriOnlineController::class, 'show'])->name('history.show'); // Ganti id_riwayat menjadi id_pinjam
    Route::put('/historionline/{id_pinjam}/kembali', [HistoriOnlineController::class, 'updateTanggalKembali'])->name('history.updateTanggalKembali'); // Ganti id_riwayat menjadi id_pinjam
    Route::delete('/historionline/{id_pinjam}', [HistoriOnlineController::class, 'destroy'])->name('history.destroy'); // Ganti id_riwayat menjadi id_pinjam
    Route::get('/kategori/{id}', [ProdukController::class, 'filterByCategory'])->name('pengguna.kategori.filter');

    Route::get('/save-last-page', [EbookReadController::class, 'saveLastPage'])->middleware('auth');
});


Route::middleware(['auth', 'role:3'])->group(function () {
    // Halaman untuk Kepala
    Route::get('/kepala/dashboard', [KepalaController::class, 'index'])->name('kepala.dashboard');
    Route::get('/kepala/rekaponline', [RekapOnlineController::class, 'rekapOnline'])->name('kepala.rekaponline');
Route::get('/kepala/rekaponline/export', [RekapOnlineController::class, 'exportRekapOnline'])->name('rekaponline.export');
});




Route::middleware(['auth'])->group(function () {});



Route::middleware(['auth'])->group(function () {


    // Rute untuk menampilkan form biodata
    Route::get('/biodata', [BiodataController::class, 'create'])->name('biodata.create');

    // Rute untuk menyimpan biodata
    Route::post('/biodata', [BiodataController::class, 'store'])->name('biodata.store');
});
