<?php

use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\EkstrakulikulerController;
use App\Http\Controllers\Api\GambarSaranaController;
use App\Http\Controllers\Api\KaryaGuruController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\PrestasiController;
use App\Http\Controllers\Api\ProfilSekolahController;
use App\Http\Controllers\Api\SaranaPrasaranaController;
use App\Http\Controllers\Api\TestimoniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/detail', [UserController::class, 'show']);

    Route::get('/agendas', [AgendaController::class, 'index']);
    Route::get('/agendas/{id}', [AgendaController::class, 'show']);

    Route::get('/banner', [BannerController::class, 'index']);

    Route::get('/berita', [BeritaController::class, 'index']);
    Route::get('/berita/{slug}', [BeritaController::class, 'show']);

    Route::get('/pengumuman', [PengumumanController::class, 'index']);
    Route::get('/pengumuman/{id}', [PengumumanController::class, 'show']);

    Route::get('/ekstrakulikuler', [EkstrakulikulerController::class, 'index']);
    Route::get('/ekstrakulikuler/{id}', [EkstrakulikulerController::class, 'show']);

    Route::get('/karya-guru', [KaryaGuruController::class, 'index']);
    Route::get('/karya-guru/{slug}', [KaryaGuruController::class, 'show']);

    Route::get('/prestasi', [PrestasiController::class, 'index']);
    Route::get('/prestasi/{id}', [PrestasiController::class, 'show']);

    Route::get('/gambar-sarana', [GambarSaranaController::class, 'index']);
    Route::get('/gambar-sarana/{id}', [GambarSaranaController::class, 'show']);

    Route::get('/profil-sekolah', [ProfilSekolahController::class, 'index']);

    Route::get('/sarana-prasarana', [SaranaPrasaranaController::class, 'index']);
    Route::get('/sarana-prasarana/{id}', [SaranaPrasaranaController::class, 'show']);

    Route::get('/testimoni', [TestimoniController::class, 'index']);
    Route::get('/testimoni/{id}', [TestimoniController::class, 'show']);
