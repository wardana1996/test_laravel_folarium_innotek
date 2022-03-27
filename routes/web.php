<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jabatan', [App\Http\Controllers\jabatanPegawaiController::class, 'index'])->name('jabatan.index');
Route::post('/jabatan/create', [App\Http\Controllers\jabatanPegawaiController::class, 'create'])->name('jabatan.create');
Route::post('/jabatan/edit/{id}', [App\Http\Controllers\jabatanPegawaiController::class, 'edit'])->name('jabatan.edit');
Route::post('/jabatan/update/{id}', [App\Http\Controllers\jabatanPegawaiController::class, 'update'])->name('jabatan.update');
Route::delete('/jabatan/delete/{id}', [App\Http\Controllers\jabatanPegawaiController::class, 'delete'])->name('jabatan.delete');

Route::get('/pegawai', [App\Http\Controllers\pegawaiController::class, 'index'])->name('pegawai.index');
Route::post('/pegawai/create', [App\Http\Controllers\pegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/pegawai/edit/{id}', [App\Http\Controllers\pegawaiController::class, 'edit'])->name('pegawai.edit');
Route::post('/pegawai/update/{id}', [App\Http\Controllers\pegawaiController::class, 'update'])->name('pegawai.update');
Route::delete('/pegawai/delete/{id}', [App\Http\Controllers\pegawaiController::class, 'delete'])->name('pegawai.delete');
Route::post('/pegawai/nama', [App\Http\Controllers\pegawaiController::class, 'getnama'])->name('pegawai.nama');
Route::post('/pegawai/jabatan', [App\Http\Controllers\pegawaiController::class, 'getJabatan'])->name('pegawai.jabatan');
Route::post('/pegawai/import', [App\Http\Controllers\pegawaiController::class, 'import'])->name('pegawai.import');

Route::get('/kontrak', [App\Http\Controllers\kontrakController::class, 'index'])->name('kontrak.index');
Route::post('/kontrak/create', [App\Http\Controllers\kontrakController::class, 'create'])->name('kontrak.create');
Route::post('/kontrak/edit/{id}', [App\Http\Controllers\kontrakController::class, 'edit'])->name('kontrak.edit');
Route::post('/kontrak/update/{id}', [App\Http\Controllers\kontrakController::class, 'update'])->name('kontrak.update');
Route::delete('/kontrak/delete/{id}', [App\Http\Controllers\kontrakController::class, 'delete'])->name('kontrak.delete');
Route::get('/kontrak/jabatan/{id}', [App\Http\Controllers\kontrakController::class, 'indexJabatan'])->name('kontrak.jabatan');

