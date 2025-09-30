<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Routing\Router;
use App\Http\Controllers\Trangchucontroller;
use App\Http\Controllers\Admincontroller;

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

Route::get('/', [TrangchuController::class, 'Index'])->name('trangchu');
Route::get('/Admin/testconsole', [Admincontroller::class, 'testconsole'])->name('testconsole');

Route::middleware(['checkAdminCookie', 'redirectIfAdmin'])->group(function () {
    Route::get('/Admin/dangnhap', [Admincontroller::class, 'dangnhap'])->name('dangnhapadmin');
    Route::post('/Admin/dangnhap', [Admincontroller::class, 'xulydangnhap'])->name('xulydangnhap');
    Route::get('/Admin/quenmatkhau', [Admincontroller::class, 'quenmatkhau'])->name('quenmatkhau');
    Route::post('/Admin/quenmatkhauotp', [Admincontroller::class, 'quenmatkhauotp'])->name('capotp');
    Route::get('/Admin/checkotpcapmatkhau', [Admincontroller::class, 'checkotpcapmatkhau_METHOD_GET'])->name('checkotpcapmatkhau_METHOD_GET');
    Route::post('/Admin/caplaimatkhausuccess', [Admincontroller::class, 'checkotpcapmatkhau_METHOD_POST'])->name('checkotpcapmatkhau_METHOD_POST');
});

Route::middleware(['checkAdminCookie', 'checkAdminSession'])->group(function () {
    Route::get('/Admin/dashboard', [Admincontroller::class, 'dashboard'])->name('dashboard');
    Route::post('/Admin/dangxuat', [Admincontroller::class, 'dangxuat'])->name('dangxuat');
    Route::get('/Admin/quanlyanhdautrang', [Admincontroller::class, 'quanlyanhdautrang'])->name('quanlyanhdautrang');
    Route::get('/Admin/quanlymausac', [Admincontroller::class, 'quanlymausac'])->name('quanlymausac');
    Route::get('/Admin/quanlysanpham', [Admincontroller::class, 'quanlysanpham'])->name('quanlygiatien');
    Route::post('/Admin/upload-cloudinary', [Admincontroller::class, 'uploadcloudinary'])->name('upload.cloudinary');
    Route::post('/Admin/addcolor', [Admincontroller::class, 'addcolor'])->name('themmau');
    Route::post('/Admin/editmau', [Admincontroller::class, 'editcolor'])->name('suamau');
    Route::post('/Admin/deletemau', [Admincontroller::class, 'deletemau'])->name('xoamau');
    Route::post('/Admin/addgiatien', [Admincontroller::class, 'addgiatien'])->name('themgiatien');
    Route::post('/Admin/getgiatien', [Admincontroller::class, 'getgiatien'])->name('laygiatien');
    Route::post('/Admin/xoaanhchitiet', [Admincontroller::class, 'xoaanhchitiet'])->name('xoaanhchitiet');
    Route::post('/Admin/updategiatien', [Admincontroller::class, 'updategiatien'])->name('updategiatien');
    Route::post('/Admin/deletegiatien', [Admincontroller::class, 'deletegiatien'])->name('deletegiatien');
});