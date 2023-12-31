<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\loginController;
use App\Http\controllers\sanPhamController;
use App\Http\controllers\taiKhoanKhachHangController;
use App\Http\controllers\taiKhoanAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

Route::get('/dang-nhap', function () {
    return view('login');
})->name('dang-nhap');
Route::get('/', function () {
    return view('user.index');
})->name('trang-chu-nguoi-dung');
Route::get('/404', function () {
    return view('404');
})->name('trang-loi');
/**
     * đăng xuất
 */
Route::post('/dang-xuat', function () {
    Auth::logout();
    session()->flush();
    return redirect()->route('dang-nhap');
})->name('dang-xuat');

Route::post('/dang-nhap',[loginController::class,'login'])->name('xu-li-dang-nhap');
Route::post('/dang-ki',[loginController::class,'register'])->name('xu-li-dang-ki');
Route::group(['prefix' => '/admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    Route::get('/', [loginController::class, 'index'])->name('trang-chu');
    /**
     * tài khoản
     */
    Route::group(['prefix' => '/tai-khoan-admin', 'as' => 'tai-khoan-admin.'], function (){
        Route::get('/danh-sach-tai-khoan-admin', [taiKhoanAdminController::class, 'index'])->name('danh-sach-tai-khoan-admin');
    });
    Route::group(['prefix' => '/tai-khoan-khach-hang', 'as' => 'tai-khoan-khach-hang.'], function (){
        Route::get('/danh-sach-tai-khoan-khach-hang', [taiKhoanKhachHangController::class, 'index'])->name('danh-sach-tai-khoan-khach-hang');
    });
    Route::group(['prefix' => '/tai-khoan', 'as' => 'tai-khoan.'], function (){
        Route::get('/them-tai-khoan', [taiKhoanAdminController::class, 'create'])->name('them-tai-khoan-admin');
        Route::get('/chinh-sua-tai-khoan/{id}', [taiKhoanAdminController::class, 'show'])->name('chinh-sua-tai-khoan');
        Route::post('/them-tai-khoan', [taiKhoanAdminController::class, 'store'])->name('xu-li-them-tai-khoan-admin');
        Route::post('/chinh-sua-tai-khoan/xoa-tai-khoan/{id}', [taiKhoanAdminController::class, 'destroy'])->name('xu-li-xoa-tai-khoan');
        Route::post('/chinh-sua-tai-khoan/cap-nhat-trang-thai/{id}', [taiKhoanAdminController::class, 'update'])->name('cap-nhat-trang-thai-tai-khoan');
        Route::post('/chinh-sua-tai-khoan/cap-nhat-mat-khau/{id}', [taiKhoanAdminController::class, 'editPassWord'])->name('cap-nhat-mat-khau');
        Route::post('/chinh-sua-tai-khoan/{id}', [taiKhoanAdminController::class, 'edit'])->name('xu-li-cap-nhat-tai-khoan');
    });
    /**
     * Sản phẩm
     */
    Route::group(['prefix' => '/san-pham', 'as' => 'san-pham.'], function (){
        Route::get('/danh-sach-san-pham', [sanPhamController::class, 'index'])->name('san-pham');
    });
});
