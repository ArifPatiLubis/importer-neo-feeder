<?php

use App\Http\Controllers\Administrator\AdministratorController;
use App\Http\Controllers\Administrator\Import\SingkronBiodataController;
use App\Http\Controllers\Administrator\Import\SingkronDosenPengajarController;
use App\Http\Controllers\Administrator\Import\SingkronHistoriController;
use App\Http\Controllers\Administrator\Import\SingkronPerkuliahanController;
use App\Http\Controllers\Administrator\Import\SingkronPesertaKelasController;
use App\Http\Controllers\Administrator\Pddikti\KelasController;
use App\Http\Controllers\Administrator\Pddikti\KrsMahasiswaController;
use App\Http\Controllers\Administrator\Pddikti\MahasiswaController;
use App\Http\Controllers\Administrator\Pengaturan\DaftarPenggunaController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\Administrator\Referensi\ReferensiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\CheckUserActivity;
use Illuminate\Support\Facades\Auth;

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


Route::middleware(['guest'])->group(function(){
    Route::get('/', [SessionController::class, 'index'])->name('login');
    Route::post('/', [SessionController::class, 'login']);
});

Route::get('/logout', [SessionController::class, 'logout']);

// Route::get('/home', function() {
//     return redirect('/');
// });


Route::group(['middleware' => 'CheckUserActivity'], function () {
    // ... daftar route yang perlu dipantau aktivitasnya

    Route::middleware(['auth'])->group(function(){
        // ... route yang sudah ada
    
        Route::group(['prefix' => '/Administrator'], function () {
            Route::group(['middleware' => 'AksesPengguna:1'], function () {

                Route::get('/Beranda/Profil-Kampus', [AdministratorController::class, 'index']);
                Route::get('/Beranda/Program-Studi', [ReferensiController::class, 'prodi']);
                Route::get('/Beranda/Penugasan-Dosen', [ReferensiController::class, 'penugasandosen']);

                
                Route::get('/Data-Pddikti/Mahasiswa', [MahasiswaController::class, 'index']);
                Route::get('/Data-Pddikti/Mahasiswa/Cari', [MahasiswaController::class, 'cari']);
                Route::get('/Data-Pddikti/KRS', [KrsMahasiswaController::class, 'index']);
                Route::get('/Data-Pddikti/KRS/Cari', [KrsMahasiswaController::class, 'cari']);
                Route::get('/Data-Pddikti/KRS/Cari-KRS', [KrsMahasiswaController::class, 'carikrs']);
                Route::get('/Data-Pddikti/KRS/Cari-AKM', [KrsMahasiswaController::class, 'cariakm']);
                Route::get('/Data-Pddikti/Kelas-Perkuliahan', [KelasController::class, 'index']);
                Route::get('/Data-Pddikti/Kelas-Perkuliahan/Cari', [KelasController::class, 'cari']);

                Route::get('/Pengaturan/Daftar-Pengguna', [DaftarPenggunaController::class, 'index']);

                Route::get('/Referensi/Agama', [ReferensiController::class, 'agama']);
                Route::get('/Referensi/Jalur-Masuk', [ReferensiController::class, 'jalurmasuk']);
                Route::get('/Referensi/Jenis-Evaluasi', [ReferensiController::class, 'jenisevaluasi']);
                Route::get('/Referensi/Jenjang-Pendidikan', [ReferensiController::class, 'jenjangpendidikan']);
                Route::get('/Referensi/Pembiayaan', [ReferensiController::class, 'pembiayaan']);
                Route::get('/Referensi/Wilayah', [ReferensiController::class, 'wilayah']);
                Route::get('/Referensi/Wilayah-Provinsi', [ReferensiController::class, 'wilayahProvinsi']);
                Route::get('/Referensi/Wilayah-Provinsi-Kota', [ReferensiController::class, 'wilayahKota']);
                Route::get('/Referensi/Wilayah-Provinsi-Kota-Kecamatan', [ReferensiController::class, 'wilayahKecamatan']);

                //**Import Route */
                Route::get('/Import/Biodata', [SingkronBiodataController::class, 'index']);
                Route::post('/Import/Biodata/Singkron', [SingkronBiodataController::class, 'store']);

                Route::get('/Import/Dosen-Pengajar', [SingkronDosenPengajarController::class, 'index']);
                Route::post('/Import/Dosen-Pengajar/Singkron', [SingkronDosenPengajarController::class, 'store']);

                Route::get('/Import/Peserta-Kelas', [SingkronPesertaKelasController::class, 'index']);
                Route::post('/Import/Peserta-Kelas/Singkron', [SingkronPesertaKelasController::class, 'store']);

                Route::get('/Import/Histori', [SingkronHistoriController::class, 'index']);
                Route::post('/Import/Histori/Singkron', [SingkronHistoriController::class, 'store']);

                Route::get('/Import/Aktivitas-Perkuliahan', [SingkronPerkuliahanController::class, 'index']);
                Route::post('/Import/Aktivitas-Perkuliahan/Singkron', [SingkronPerkuliahanController::class, 'store']);
            });
        });
    
        Route::get('/PIC', [PicController::class, 'index'])->middleware('AksesPengguna:2');
        Route::get('/logout', [SessionController::class, 'logout']);
    });

});
