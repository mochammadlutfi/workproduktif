<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
Route::get('/','LandingController@index')->name('home');
Route::get('/tentang-kami','LandingController@about')->name('about');

Route::get('/login','AuthController@showLogin')->name('login');
Route::post('/login','AuthController@login');
Route::get('/daftar','AuthController@showRegister')->name('register');
Route::post('/daftar','AuthController@register');


Route::prefix('/alat')->name('produk.')->group(function () {
    Route::get('/','ProdukController@index')->name('index');
    Route::get('/{kategori}','ProdukController@kategori')->name('kategori');
    Route::get('/{kategori}/{slug}','ProdukController@show')->name('show');
});

Route::middleware('auth')->group(function () {
    Route::post('/keluar','AuthController@logout')->name('logout');
    
    Route::name('profil.')->group(function () {
        Route::get('/profil','ProfilController@edit')->name('edit');
        Route::post('/profil','ProfilController@update');
        
        Route::get('/password','ProfilController@password')->name('password');
        Route::post('/password','ProfilController@updatePassword');
    });
        
    Route::name('order.')->group(function () {
        Route::get('/pesanan','OrderController@index')->name('index');
        Route::get('/pesanan/{id}','OrderController@show')->name('show');
    });

});

Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function(){
    
    Route::middleware('guest:admin')->group(function () {
        Route::get('/','LoginController@showLoginForm')->name('login');
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout','LoginController@logout')->name('logout');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::post('/password', [ProfileController::class, 'passwordUpdate'])->name('password.update');

        Route::middleware('verified')->group(function () {
            Route::get('/beranda','BerandaController@index')->name('beranda');
            
            Route::prefix('/konsumen')->name('user.')->group(function () {
                Route::get('/','UserController@index')->name('index');
                Route::get('/create','UserController@create')->name('create');
                Route::post('/store','UserController@store')->name('store');
                Route::get('/json/{id}','UserController@json')->name('json');
                Route::get('/{id}','UserController@show')->name('show');
                Route::get('/{id}/edit','UserController@edit')->name('edit');
                Route::post('{id}/update','UserController@update')->name('update');
                Route::delete('/{id}/delete','UserController@destroy')->name('delete');
                Route::get('/{id}/riwayat','UserController@riwayat')->name('riwayat');
            });

            Route::prefix('/training')->name('training.')->group(function () {
                Route::get('/','TrainingController@index')->name('index');
                Route::get('/create','TrainingController@create')->name('create');
                Route::post('/store','TrainingController@store')->name('store');
                Route::post('/status','TrainingController@status')->name('status');
                Route::get('/{id}','TrainingController@show')->name('show');
                Route::get('/{id}/edit','TrainingController@edit')->name('edit');
                Route::post('{id}/update','TrainingController@update')->name('update');
                Route::delete('/{id}/delete','TrainingController@destroy')->name('delete');
                Route::get('/{id}/peserta','UserTrainingController@index')->name('peserta');
                Route::post('/{id}/peserta/store','UserTrainingController@store')->name('peserta.store');
                Route::delete('/{id}/peserta/delete','UserTrainingController@destroy')->name('peserta.delete');
                Route::get('/{id}/peserta/{user}/certificate','UserTrainingController@certificate')->name('peserta.certificate');
            });
            
            Route::prefix('/pemesanan')->name('order.')->group(function () {
                Route::get('/','OrderController@index')->name('index');
                Route::get('/create','OrderController@create')->name('create');
                Route::post('/store','OrderController@store')->name('store');
                Route::get('/json/{id}','OrderController@json')->name('json');
                Route::get('/{id}','OrderController@show')->name('show');
                Route::get('/{id}/edit','OrderController@edit')->name('edit');
                Route::post('{id}/update','OrderController@update')->name('update');
                Route::delete('/{id}/delete','OrderController@destroy')->name('delete');
                Route::get('/{id}/riwayat','OrderController@riwayat')->name('riwayat');
            });

            Route::prefix('/produk')->name('produk.')->group(function () {
                Route::get('/','ProdukController@index')->name('index');
                Route::get('/create','ProdukController@create')->name('create');
                Route::post('/store','ProdukController@store')->name('store');
                Route::get('/json/{id}','ProdukController@json')->name('json');
                Route::get('/{id}','ProdukController@show')->name('show');
                Route::get('/{id}/edit','ProdukController@edit')->name('edit');
                Route::post('{id}/update','ProdukController@update')->name('update');
                Route::delete('/{id}/delete','ProdukController@destroy')->name('delete');
                Route::get('/{id}/riwayat','ProdukController@riwayat')->name('riwayat');
            });

            Route::prefix('/kategori')->name('kategori.')->group(function () {
                Route::get('/','KategoriController@index')->name('index');
                Route::post('/store','KategoriController@store')->name('store');
                Route::get('/{id}','KategoriController@show')->name('show');
                Route::get('/{id}/edit','KategoriController@edit')->name('edit');
                Route::post('/{id}/update','KategoriController@update')->name('store');
                Route::delete('/{id}/delete','KategoriController@destroy')->name('delete');
            });

            Route::prefix('/pembayaran')->name('payment.')->group(function () {
                Route::get('/','PembayaranController@index')->name('index');
                Route::get('/create','PembayaranController@create')->name('create');
                Route::post('/store','PembayaranController@store')->name('store');
                Route::get('/{id}','PembayaranController@show')->name('show');
                Route::get('/{id}/edit','PembayaranController@edit')->name('edit');
                Route::post('{id}/update','PembayaranController@update')->name('update');
                Route::post('{id}/status','PembayaranController@status')->name('status');
                Route::delete('/{id}/delete','PembayaranController@destroy')->name('delete');
            });
        
            Route::prefix('/pengumuman')->name('pengumuman.')->group(function () {
                Route::get('/','PengumumanController@index')->name('index');
                Route::get('/tambah','PengumumanController@tambah')->name('tambah');
                Route::post('/simpan','PengumumanController@simpan')->name('simpan');
                Route::get('/{id}','PengumumanController@show')->name('show');
                Route::get('/{id}/edit','PengumumanController@edit')->name('edit');
                Route::post('{id}/update','PengumumanController@update')->name('update');
                Route::delete('/{id}/delete','PengumumanController@destroy')->name('delete');
            });
            
            Route::prefix('/anggota')->name('anggota.')->group(function () {
                Route::get('/','AnggotaController@index')->name('index');
                Route::get('/tambah','AnggotaController@tambah')->name('tambah');
                Route::post('/simpan','AnggotaController@simpan')->name('simpan');
                Route::get('/baru','AnggotaController@baru')->name('baru');
                Route::get('/{id}','AnggotaController@show')->name('show');
                Route::get('/{id}/edit','AnggotaController@edit')->name('edit');
                Route::post('{id}/confirm','AnggotaController@confirm')->name('confirm');
                Route::post('{id}/update','AnggotaController@update')->name('update');
                Route::delete('/{id}/delete','AnggotaController@destroy')->name('delete');
            });

            Route::prefix('/pegawai')->name('pegawai.')->group(function () {
                Route::get('/','PegawaiController@index')->name('index');
                Route::get('/data','PegawaiController@data')->name('data');
                Route::get('/create','PegawaiController@create')->name('create');
                Route::post('/store','PegawaiController@store')->name('store');
                Route::get('/{id}','PegawaiController@show')->name('show');
                Route::get('/{id}/edit','PegawaiController@edit')->name('edit');
                Route::post('{id}/update','PegawaiController@update')->name('update');
                Route::delete('/{id}/delete','PegawaiController@destroy')->name('delete');
            });

            Route::prefix('/absen')->name('absen.')->group(function () {
                Route::get('/','AbsenController@index')->name('index');
                Route::get('/tambah','AbsenController@tambah')->name('tambah');
                Route::post('/simpan','AbsenController@simpan')->name('simpan');
                Route::get('print/{ekskul}/{tgl}','AbsenController@print')->name('print');
                Route::get('/{ekskul}/{tgl}','AbsenController@show')->name('show');
                Route::get('/{id}/edit','AbsenController@edit')->name('edit');
                Route::post('{id}/update','AbsenController@update')->name('update');
                Route::delete('/{id}/delete','AbsenController@destroy')->name('delete');
            });
            
            Route::prefix('/galeri')->name('galeri.')->group(function () {
                Route::get('/','GaleriController@index')->name('index');
                Route::post('/store','GaleriController@store')->name('store');
                Route::delete('/{id}/delete','GaleriController@destroy')->name('delete');
            });

        });
    });
});


// require __DIR__.'/auth.php';
