<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\API\PengembalianDetailController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/petugas', [PetugasController::class, 'create']);

Route::post('/anggota', [AnggotaController::class, 'create']);

Route::post('/penerbit', [PenerbitController::class, 'create']);
Route::get('/penerbit', [PenerbitController::class, 'index']);
Route::get('/penerbit{id}', [PenerbitController::class, 'show']);

Route::post('/pengarang', [PengarangController::class, 'create']);
Route::get('/pengarang', [PengarangController::class, 'index']);
Route::get('/pengarang/{id}', [PengarangController::class, 'show']);

Route::post('/rak', [RakController::class, 'create']);
Route::get('/rak', [RakController::class, 'index']);
Route::get('/rak/{id}', [RakController::class, 'show']);

Route::post('/buku', [BukuController::class, 'create']);
Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/{id}', [BukuController::class, 'show']);

Route::post('/peminjaman', [PeminjamanController::class, 'create']);
Route::get('/peminjaman', [PeminjamanController::class, 'index']);
Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show']);

Route::post('/peminjamandetail', [PeminjamanDetailController::class, 'create']);
Route::get('/peminjamandetail', [PeminjamanDetailController::class, 'index']);
Route::get('/peminjamandetail/{id}', [PeminjamanDetailController::class, 'show']);

Route::post('/pengembalian', [PengembalianController::class, 'create']);
Route::get('/pengembalian', [PengembalianController::class, 'index']);
Route::get('/pengembalian/{id}', [PengembalianController::class, 'show']);

Route::post('/pengembaliandetail', [PengembalianDetailController::class, 'create']);
Route::get('/pengembaliandetail', [PengembalianDetailController::class, 'index']);
Route::get('/pengembaliandetail/{id}', [PengembalianDetailController::class, 'show']);
