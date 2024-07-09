<?php

use App\Models\User;
use App\Events\NotifApproval;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\authController;
use App\Http\Controllers\IjinController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\NotificationController;

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

Route::get('/', [authController::class, 'index'])->name('login')->middleware('guest');
Route::get('/login-admin', [authController::class, 'loginAdmin'])->name('loginAdmin')->middleware('guest');
Route::post('/presensi/store', [authController::class, 'presensiStore'])->middleware('guest');
Route::post('/presensi-pulang/store', [authController::class, 'presensiPulangStore'])->middleware('guest');
Route::get('/ajaxGetNeural', [authController::class, 'ajaxGetNeural'])->middleware('guest');
Route::get('/register', [authController::class, 'register'])->middleware('guest');
Route::post('/register-proses', [authController::class, 'registerProses'])->middleware('guest');
Route::post('/login-proses', [authController::class, 'loginProses'])->middleware('guest');
Route::post('/login-proses-user', [authController::class, 'loginProsesUser'])->middleware('guest');
Route::get('/dashboard', [dashboardController::class, 'index'])->middleware('auth');
Route::get('/logout', [authController::class, 'logout'])->middleware('auth');
Route::get('/pegawai', [karyawanController::class, 'index'])->middleware('auth');
Route::get('/euforia', [karyawanController::class, 'euforia'])->middleware('auth');
Route::get('/pegawai/tambah-pegawai', [karyawanController::class, 'tambahKaryawan'])->middleware('admin');
Route::post('/pegawai/tambah-pegawai-proses', [karyawanController::class, 'tambahKaryawanProses'])->middleware('admin');
Route::post('/pegawai/face/ajaxPhoto', [karyawanController::class, 'ajaxPhoto'])->middleware('admin');
Route::post('/pegawai/face/ajaxDescrip', [karyawanController::class, 'ajaxDescrip'])->middleware('admin');
Route::post('/pegawai/import', [karyawanController::class, 'importUsers'])->middleware('admin');
Route::get('/pegawai/detail/{id}', [karyawanController::class, 'detail'])->middleware('admin');
Route::get('/pegawai/show/{id}', [karyawanController::class, 'show'])->middleware('auth');
Route::put('/pegawai/proses-edit/{id}', [karyawanController::class, 'editKaryawanProses'])->middleware('admin');
Route::delete('/pegawai/delete/{id}', [karyawanController::class, 'deleteKaryawan'])->middleware('admin');
Route::get('/pegawai/edit-password/{id}', [karyawanController::class, 'editPassword'])->middleware('admin');
Route::put('/pegawai/edit-password-proses/{id}', [karyawanController::class, 'editPasswordProses'])->middleware('admin');
Route::resource('/shift', ShiftController::class)->middleware('admin');

Route::get('/pegawai/shift/{id}', [karyawanController::class, 'shift'])->middleware('admin');

Route::post('/pegawai/shift/proses-tambah-shift', [karyawanController::class, 'prosesTambahShift'])->middleware('admin');
Route::post('/pegawai/dinas-luar/proses-tambah-shift', [karyawanController::class, 'prosesTambahDinas'])->middleware('admin');

Route::delete('/pegawai/delete-shift/{id}', [karyawanController::class, 'deleteShift'])->middleware('admin');
Route::delete('/pegawai/delete-dinas/{id}', [karyawanController::class, 'deleteDinas'])->middleware('admin');

Route::get('/pegawai/edit-shift/{id}', [karyawanController::class, 'editShift'])->middleware('admin');
Route::get('/pegawai/edit-dinas/{id}', [karyawanController::class, 'editDinas'])->middleware('admin');

Route::put('/pegawai/proses-edit-shift/{id}', [karyawanController::class, 'prosesEditShift'])->middleware('auth');

Route::get('/absen', [AbsenController::class, 'index'])->middleware('auth');

Route::get('/notifications', [NotificationController::class, 'index'])->middleware('auth');
Route::get('/notifications/read', [NotificationController::class, 'read'])->middleware('auth');
Route::get('/notifications/unread', [NotificationController::class, 'unread'])->middleware('auth');
Route::get('/notifications/read-message/{id}', [NotificationController::class, 'readMessage'])->middleware('auth');

Route::get('/menu', [dashboardController::class, 'menu'])->middleware('auth');

Route::get('/my-location', [AbsenController::class, 'myLocation'])->middleware('auth');

Route::put('/absen/masuk/{id}', [AbsenController::class, 'absenMasuk'])->middleware('auth');

Route::put('/absen/pulang/{id}', [AbsenController::class, 'absenPulang'])->middleware('auth');

Route::get('/data-absen', [AbsenController::class, 'dataAbsen'])->middleware('admin');

Route::get('/data-absen/{id}/edit-masuk', [AbsenController::class, 'editMasuk'])->middleware('admin');
Route::get('/maps/{lat}/{long}/{userid}', [AbsenController::class, 'maps'])->middleware('auth');
Route::put('/data-absen/{id}/proses-edit-masuk', [AbsenController::class, 'prosesEditMasuk'])->middleware('admin');
Route::get('/data-absen/{id}/edit-pulang', [AbsenController::class, 'editPulang'])->middleware('admin');
Route::put('/data-absen/{id}/proses-edit-pulang', [AbsenController::class, 'prosesEditPulang'])->middleware('admin');
Route::delete('/data-absen/{id}/delete', [AbsenController::class, 'deleteAdmin'])->middleware('admin');

Route::get('/my-absen', [AbsenController::class, 'myAbsen'])->middleware('auth');
Route::get('/my-absen/pengajuan/{id}', [AbsenController::class, 'pengajuan'])->middleware('auth');
Route::post('/my-absen/pengajuan-proses/{id}', [AbsenController::class, 'pengajuanProses'])->middleware('auth');
Route::get('/pengajuan-absensi', [AbsenController::class, 'pengajuanAbsensi'])->middleware('auth');
Route::get('/pengajuan-absensi/edit/{id}', [AbsenController::class, 'editPengajuanAbsensi'])->middleware('auth');
Route::post('/pengajuan-absensi/update/{id}', [AbsenController::class, 'updatePengajuanAbsensi'])->middleware('auth');

Route::get('/lembur', [LemburController::class, 'index'])->middleware('auth');
Route::post('/lembur/masuk', [LemburController::class, 'masuk'])->middleware('auth');
Route::put('/lembur/pulang/{id}', [LemburController::class, 'pulang'])->middleware('auth');
Route::get('/data-lembur', [LemburController::class, 'dataLembur'])->middleware('admin');
Route::post('/data-lembur/approval/{id}', [LemburController::class, 'approval'])->middleware('admin');
Route::get('/my-lembur', [LemburController::class, 'myLembur'])->middleware('auth');

Route::get('/rekap-data', [RekapDataController::class, 'index'])->middleware('admin');
Route::get('/rekap-data/get-data', [RekapDataController::class, 'getData'])->middleware('admin');
Route::get('/rekap-data/payroll/{id}', [RekapDataController::class, 'payroll'])->middleware('admin');
Route::post('/rekap-data/payroll/tambah', [RekapDataController::class, 'tambahPayroll'])->middleware('admin');

Route::get('/cuti', [IjinController::class, 'index'])->middleware('auth');
Route::post('/cuti/tambah', [IjinController::class, 'tambah'])->middleware('auth');
Route::delete('/cuti/delete/{id}', [IjinController::class, 'delete'])->middleware('auth');
Route::get('/cuti/edit/{id}', [IjinController::class, 'edit'])->middleware('auth');
Route::put('/cuti/proses-edit/{id}', [IjinController::class, 'editProses'])->middleware('auth');
Route::get('/data-cuti', [IjinController::class, 'dataCuti'])->middleware('admin');
Route::get('/data-cuti/tambah', [IjinController::class, 'tambahAdmin'])->middleware('admin');
Route::post('/data-cuti/getuserid', [IjinController::class, 'getUserId'])->middleware('admin');
Route::post('/data-cuti/proses-tambah', [IjinController::class, 'tambahAdminProses'])->middleware('admin');
Route::delete('/data-cuti/delete/{id}', [IjinController::class, 'deleteAdmin'])->middleware('admin');
Route::get('/data-cuti/edit/{id}', [IjinController::class, 'editAdmin'])->middleware('admin');
Route::put('/data-cuti/edit-proses/{id}', [IjinController::class, 'editAdminProses'])->middleware('admin');
Route::get('/my-profile', [KaryawanController::class, 'myProfile'])->middleware('auth');
Route::put('/my-profile/update/{id}', [KaryawanController::class, 'myProfileUpdate'])->middleware('auth');
Route::get('/my-profile/edit-password', [KaryawanController::class, 'editPassMyProfile'])->middleware('auth');
Route::put('/my-profile/edit-password-proses/{id}', [KaryawanController::class, 'editPassMyProfileProses'])->middleware('auth');

Route::get('/lokasi-kantor', [LokasiController::class, 'index'])->middleware('admin');
Route::get('/lokasi-kantor/tambah', [LokasiController::class, 'tambahLokasi'])->middleware('admin');
Route::post('/lokasi-kantor/tambah-proses', [LokasiController::class, 'prosesTambahLokasi'])->middleware('admin');
Route::get('/lokasi-kantor/edit/{id}', [LokasiController::class, 'editLokasi'])->middleware('admin');
Route::put('/lokasi-kantor/update/{id}', [LokasiController::class, 'updateLokasi'])->middleware('admin');
Route::put('/lokasi-kantor/radius/{id}', [LokasiController::class, 'updateRadiusLokasi'])->middleware('admin');
Route::delete('/lokasi-kantor/delete/{id}', [LokasiController::class, 'deleteLokasi'])->middleware('admin');

Route::get('/request-location', [LokasiController::class, 'requestLocation'])->middleware('auth');
Route::get('/request-location/tambah', [LokasiController::class, 'tambahRequestLocation'])->middleware('auth');
Route::post('/request-location/tambah-proses', [LokasiController::class, 'prosesTambahRequestLocation'])->middleware('auth');
Route::get('/request-location/edit/{id}', [LokasiController::class, 'editRequestLocation'])->middleware('auth');
Route::put('/request-location/update/{id}', [LokasiController::class, 'updateRequestLocation'])->middleware('auth');
Route::put('/request-location/radius/{id}', [LokasiController::class, 'updateRadiusRequestLocation'])->middleware('auth');
Route::delete('/request-location/delete/{id}', [LokasiController::class, 'deleteRequestLocation'])->middleware('auth');

Route::get('/reset-cuti', [KaryawanController::class, 'resetCuti'])->middleware('admin');
Route::put('/reset-cuti/{id}', [KaryawanController::class, 'resetCutiProses'])->middleware('admin');

Route::get('/file', [FileController::class, 'index'])->middleware('admin');
Route::get('/file/upload', [FileController::class, 'upload'])->middleware('admin');
Route::post('/file/upload-proses', [FileController::class, 'uploadProses'])->middleware('admin');
Route::get('/file/edit/{id}', [FileController::class, 'edit'])->middleware('admin');
Route::put('/file/update/{id}', [FileController::class, 'update'])->middleware('admin');
Route::delete('/file/delete/{id}', [FileController::class, 'delete'])->middleware('admin');

Route::get('/my-file', [FileController::class, 'myFile'])->middleware('auth');
Route::get('/my-file/upload', [FileController::class, 'myFileUpload'])->middleware('auth');
Route::post('/my-file/upload-proses', [FileController::class, 'myFileUploadProses'])->middleware('auth');
Route::get('/my-file/edit/{id}', [FileController::class, 'myFileEdit'])->middleware('auth');
Route::put('/my-file/update/{id}', [FileController::class, 'myFileUpdate'])->middleware('auth');
Route::delete('/my-file/delete/{id}', [FileController::class, 'myFileDelete'])->middleware('auth');

Route::get('/data-absen/export', [AbsenController::class, 'exportDataAbsen'])->middleware('admin');

Route::get('/reset', function () {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('migrate:fresh --seed');
    Artisan::call('storage:link');
});