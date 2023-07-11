<?php

use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerMasterDataItem;
use App\Http\Controllers\ControllerMasterDataLokasi;
use App\Http\Controllers\ControllerMasterHakAkses;
use App\Http\Controllers\ControllerMasterSPG;
use App\Http\Controllers\ControllerMasterWarna;
use App\Http\Controllers\ControllerReportMutasiStock;
use App\Http\Controllers\ControllerReportOmsetItem;
use App\Http\Controllers\ControllerReportOmsetPecounter;
use App\Http\Controllers\ControllerReportStockOverview;
use App\Http\Controllers\ControllerTransAdjustmentStock;
use App\Http\Controllers\ControllerTransBonPenjualan;
use App\Http\Controllers\ControllerTransPembelianBarang;
use App\Http\Controllers\ControllerTransPenerimaanBrg;
use App\Http\Controllers\ControllerTransReturPenjualan;
use App\Http\Controllers\ControllerTransSOB;
use App\Http\Controllers\ControllerTransStockOpname;
use App\Http\Controllers\ControllerTransSuratJalan;
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
// ---Master Data---
Route::get('/', [ControllerLogin::class, 'index'])->name('login');
Route::post('/', [ControllerLogin::class, 'postLogin'])->name('postlogin');
Route::get('logout', [ControllerLogin::class, 'logout'])->name('logout');

Route::get('mwarna', [ControllerMasterWarna::class, 'index'])->name('mwarna');
Route::get('mspg', [ControllerMasterSPG::class, 'index'])->name('mspg');
Route::get('mlokasi', [ControllerMasterDataLokasi::class, 'index'])->name('mlokasi');
Route::get('mitem', [ControllerMasterDataItem::class, 'index'])->name('mitem');
Route::get('mhakses', [ControllerMasterHakAkses::class, 'index'])->name('mhakses');


// ---Transaksi---
Route::get('tsob', [ControllerTransSOB::class, 'index'])->name('tsob');
Route::get('tpenerimaanbrg', [ControllerTransPenerimaanBrg::class, 'index'])->name('tpenerimaanbrg');
Route::get('treturjual', [ControllerTransReturPenjualan::class, 'index'])->name('treturjual');
Route::get('tbonjual', [ControllerTransBonPenjualan::class, 'index'])->name('tbonjual');
Route::get('tadjustmentstock', [ControllerTransAdjustmentStock::class, 'index'])->name('tadjustmentstock');
Route::get('tsuratjalan', [ControllerTransSuratJalan::class, 'index'])->name('tsuratjalan');
Route::get('tstockopname', [ControllerTransStockOpname::class, 'index'])->name('tstockopname');
Route::get('tpembelianbarang', [ControllerTransPembelianBarang::class, 'index'])->name('tpembelianbarang');

// ---Report---
Route::get('romsetitem', [ControllerReportOmsetItem::class, 'index'])->name('romsetitem');
Route::get('rstockoverview', [ControllerReportStockOverview::class, 'index'])->name('rstockoverview');
Route::get('rmutasistock', [ControllerReportMutasiStock::class, 'index'])->name('rmutasistock');
Route::get('romsetcounter', [ControllerReportOmsetPecounter::class, 'index'])->name('romsetcounter');

Route::group(['middleware' => ['auth']], function () {
    
});
