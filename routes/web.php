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
        Route::post('/pesanan/simpan','OrderController@store')->name('store');
        Route::get('/pesanan/{id}','OrderController@show')->name('show');
        Route::get('/pesanan/{id}/pembayaran','OrderController@payment')->name('payment');
        Route::get('/pesanan/{id}/pembayaran/{payment_id}}','OrderController@paymentShow')->name('payment.show');
        Route::post('/pesanan/{id}/update','OrderController@update')->name('update');
        Route::post('/pesanan/{id}/upload','OrderController@upload')->name('upload');
        Route::get('/pesanan/{id}/kontrak','OrderController@kontrak')->name('kontrak');
        Route::get('/pesanan/{id}/invoice','OrderController@pdf')->name('invoice');
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
                Route::post('/select','UserController@select')->name('select');
                Route::get('/json/{id}','UserController@json')->name('json');
                Route::get('/{id}','UserController@show')->name('show');
                Route::get('/{id}/edit','UserController@edit')->name('edit');
                Route::post('{id}/update','UserController@update')->name('update');
                Route::delete('/{id}/delete','UserController@destroy')->name('delete');
                Route::get('/{id}/riwayat','UserController@riwayat')->name('riwayat');
            });

            Route::prefix('/pemesanan')->name('order.')->group(function () {
                Route::get('/','OrderController@index')->name('index');
                Route::get('/create','OrderController@create')->name('create');
                Route::get('/report','OrderController@report')->name('report');
                Route::post('/store','OrderController@store')->name('store');
                Route::post('/select','OrderController@select')->name('select');
                Route::get('/{id}','OrderController@show')->name('show');
                Route::get('/{id}/invoice','OrderController@invoice')->name('invoice');
                Route::get('/{id}/kontrak','OrderController@kontrak')->name('kontrak');
                Route::get('/{id}/json','OrderController@json')->name('json');
                Route::get('/{id}/edit','OrderController@edit')->name('edit');
                Route::post('{id}/status','OrderController@status')->name('status');
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

        });
    });
});


// require __DIR__.'/auth.php';
