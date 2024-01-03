<?php

use App\Http\Controllers\ControllerHome;
use App\Http\Controllers\ControllerLogin;
use App\Http\Controllers\ControllerMasterDataItem;
use App\Http\Controllers\ControllerMasterDataLokasi;
use App\Http\Controllers\ControllerMasterHakAkses;
use App\Http\Controllers\ControllerMasterJenisPayment;
use App\Http\Controllers\ControllerMasterSaldoAwal;
use App\Http\Controllers\ControllerMasterSPG;
use App\Http\Controllers\ControllerMasterWarna;
use App\Http\Controllers\ControllerReportMutasiStock;
use App\Http\Controllers\ControllerReportOmsetItem;
use App\Http\Controllers\ControllerReportOmsetPecounter;
use App\Http\Controllers\ControllerReportPerOutlet;
use App\Http\Controllers\ControllerReportStockCounter;
use App\Http\Controllers\ControllerReportStockOverview;
use App\Http\Controllers\ControllerTransAdjustmentStock;
use App\Http\Controllers\ControllerTransBonPenjualan;
use App\Http\Controllers\ControllerTransExpense;
use App\Http\Controllers\ControllerTransPembelianBarang;
use App\Http\Controllers\ControllerTransPenerimaanBrg;
use App\Http\Controllers\ControllerTransReturPenjualan;
use App\Http\Controllers\ControllerTransSOB;
use App\Http\Controllers\ControllerTransStockOpname;
use App\Http\Controllers\ControllerTransSuratJalan;
use App\Http\Controllers\ControllerUpload;
use App\Http\Controllers\ControllerUploadMitemCounter;
use App\Http\Controllers\ControllerUploadTbhStockMitem;
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

// Route::get('/testreport', function () {
//     return view('pages.Print.printp');
// });
// Route::get('/tss', function () {
//     return view('pages.Print.printp');
// });

// ---Master Data---
Route::get('/', [ControllerLogin::class, 'index'])->name('login');
Route::post('/', [ControllerLogin::class, 'postLogin'])->name('postlogin');
Route::get('/logout', [ControllerLogin::class, 'logout'])->name('logout');


Route::group(['middleware' => ['auth']], function () {

    //--- Master Warna ---
    Route::get('mwarna', [ControllerMasterWarna::class, 'index'])->name('mwarna');
    Route::post('/mwarnapost', [ControllerMasterWarna::class, 'post'])->name('mwarnapost');
    Route::get('/mwarna/{mwarna}/edit', [ControllerMasterWarna::class, 'getedit'])->name('mwarnagetedit');
    Route::post('/mwarna/{mwarna}', [ControllerMasterWarna::class, 'update'])->name('mwarnaupdt');
    Route::post('/mwarna/delete/{mwarna}', [ControllerMasterWarna::class, 'delete'])->name('mwarnadelete');
    
    Route::get('/mjenispayment', [ControllerMasterJenisPayment::class, 'index'])->name('mjenispayment');
    Route::post('/mjenispaymentpost', [ControllerMasterJenisPayment::class, 'post'])->name('mjenispaymentpost');
    Route::get('/mjenispayment/{mjenispayment}/edit', [ControllerMasterJenisPayment::class, 'getedit'])->name('mjenispaymentedit');
    Route::post('/mjenispayment/{mjenispayment}', [ControllerMasterJenisPayment::class, 'update'])->name('mjenispaymentupdt');
    Route::post('/mjenispayment/delete/{mjenispayment}', [ControllerMasterJenisPayment::class, 'delete'])->name('mjenispaymentdelete');

    Route::get('mspg', [ControllerMasterSPG::class, 'index'])->name('mspg');
    Route::post('/mspgpost', [ControllerMasterSPG::class, 'post'])->name('mspgpost');
    Route::get('/mspg/{user}/edit', [ControllerMasterSPG::class, 'getedit'])->name('mspggetedit');
    Route::post('/mspg/{user}', [ControllerMasterSPG::class, 'update'])->name('mspgupdt');
    Route::post('/mspg/delete/{user}', [ControllerMasterSPG::class, 'delete'])->name('mspgdelete');

    Route::get('mlokasi', [ControllerMasterDataLokasi::class, 'index'])->name('mlokasi');
    Route::post('/mlokasipost', [ControllerMasterDataLokasi::class, 'post'])->name('mlokasipost');
    Route::get('/mlokasi/{mcounter}/edit', [ControllerMasterDataLokasi::class, 'getedit'])->name('mlokasigetedit');
    Route::post('/mlokasi/{mcounter}', [ControllerMasterDataLokasi::class, 'update'])->name('mlokasiupdt');
    Route::post('/mlokasi/delete/{mcounter}', [ControllerMasterDataLokasi::class, 'delete'])->name('mlokasidelete');

    Route::get('mitem', [ControllerMasterDataItem::class, 'index'])->name('mitem');
    Route::post('/mitempost', [ControllerMasterDataItem::class, 'post'])->name('mitempost');
    Route::get('/mitem/{mitem}/edit', [ControllerMasterDataItem::class, 'getedit'])->name('mitemgetedit');
    Route::post('/mitem/{mitem}', [ControllerMasterDataItem::class, 'update'])->name('mitemupdt');
    Route::post('/mitem/delete/{mitem}', [ControllerMasterDataItem::class, 'delete'])->name('mitemdelete');
    Route::post('/dtablegetmitem', [ControllerMasterDataItem::class, 'getmitem'])->name('dtablegetmitem');
    Route::get('/mitem/{mitem}/print', [ControllerMasterDataItem::class, 'print'])->name('mitemprint');
    Route::get('/mitempdf', [ControllerMasterDataItem::class, 'exportpdf'])->name('mitempdf');
    Route::post('/getmitemv2', [ControllerMasterDataItem::class, 'getmitem'])->name('getmitemv2');
    Route::post('/getstock', [ControllerMasterDataItem::class, 'getstock'])->name('getstock');
    Route::post('/getpriceitem', [ControllerMasterDataItem::class, 'getpriceitem'])->name('getpriceitem');
    Route::get('mitemexcel', [ControllerMasterDataItem::class, 'exportExcel'])->name('mitemexcel');

    Route::get('msaldoawal', [ControllerMasterSaldoAwal::class, 'index'])->name('msaldoawal');
    Route::get('modalmsaldoawal', [ControllerMasterSaldoAwal::class, 'modal'])->name('modalmsaldoawal');
    Route::post('msaldoawalpost', [ControllerMasterSaldoAwal::class, 'post'])->name('msaldoawalpost');
    Route::get('/msaldoawal/{msaldoAwal}/edit', [ControllerMasterSaldoAwal::class, 'getedit'])->name('msaldoawaledit');
    Route::post('/msaldoawal/delete/{msaldoAwal}', [ControllerMasterSaldoAwal::class, 'delete'])->name('msaldoawaldelete');

    Route::get('mhakses', [ControllerMasterHakAkses::class, 'index'])->name('mhakses');
    Route::post('mhaksespost', [ControllerMasterHakAkses::class, 'post'])->name('mhaksespost');
    Route::get('/mhakses/{user}/edit', [ControllerMasterHakAkses::class, 'getedit'])->name('mhaksesgetedit');
    Route::post('/mhakses/{user}', [ControllerMasterHakAkses::class, 'update'])->name('mhaksesupdt');
    Route::post('/mhakses/delete/{user}', [ControllerMasterHakAkses::class, 'delete'])->name('mhaksesdelete');

    // ---Transaksi---
    Route::get('home', [ControllerHome::class, 'index'])->name('home');
    Route::get('uploadsample', [ControllerUpload::class, 'index'])->name('uploadsample');
    Route::post('uploadpost', [ControllerUpload::class, 'uploadpost'])->name('uploadpost');

    Route::get('uploadmitemcounter', [ControllerUploadMitemCounter::class, 'index'])->name('uploadmitemcounter');
    Route::post('uploadmitemcounterpost', [ControllerUploadMitemCounter::class, 'uploadpost'])->name('uploadmitemcounterpost');
    
    Route::get('uploadtbhstock', [ControllerUploadTbhStockMitem::class, 'index'])->name('uploadtbhstock');
    Route::post('uploadtbhstockpost', [ControllerUploadTbhStockMitem::class, 'uploadpost'])->name('uploadtbhstockpost');

    Route::get('tsob', [ControllerTransSOB::class, 'index'])->name('tsob');
    Route::post('/tsobpost', [ControllerTransSOB::class, 'post'])->name('tsobpost');
    Route::post('/getmitem', [ControllerTransSOB::class, 'getmitem'])->name('getmitem');
    Route::get('tsoblist', [ControllerTransSOB::class, 'list'])->name('tsoblist');
    Route::get('/tsob/{tsobh}/edit', [ControllerTransSOB::class, 'getedit'])->name('tsobedit');
    Route::post('/tsob/{tsobh}', [ControllerTransSOB::class, 'update'])->name('tsobupdate');
    Route::post('/tsob/delete/{tsobh}', [ControllerTransSOB::class, 'delete'])->name('tsobdelete');
    Route::get('/tsob/{tsobh}/print', [ControllerTransSOB::class, 'print'])->name('tsobprint');

    Route::get('tpenerimaanbrg', [ControllerTransPenerimaanBrg::class, 'index'])->name('tpenerimaanbrg');
    Route::post('/tpenerimaanbrgpost', [ControllerTransPenerimaanBrg::class, 'post'])->name('tpenerimaanbrgpost');
    Route::post('/getmitempenerimaan', [ControllerTransPenerimaanBrg::class, 'getmitem'])->name('getmitempenerimaan');
    Route::post('/getnosjd', [ControllerTransPenerimaanBrg::class, 'getnosj'])->name('getnosjd');
    Route::get('tpenerimaanbrglist', [ControllerTransPenerimaanBrg::class, 'list'])->name('tpenerimaanbrglist');
    Route::get('/tpenerimaanbrg/{tpenerimaanh}/edit', [ControllerTransPenerimaanBrg::class, 'getedit'])->name('tpenerimaanbrgedit');
    Route::post('/tpenerimaanbrg/{tpenerimaanh}', [ControllerTransPenerimaanBrg::class, 'update'])->name('tpenerimaanbrgupdate');
    Route::post('/tpenerimaanbrg/delete/{tpenerimaanh}', [ControllerTransPenerimaanBrg::class, 'delete'])->name('tpenerimaanbrgdelete');

    Route::get('treturjual', [ControllerTransReturPenjualan::class, 'index'])->name('treturjual');
    Route::post('/treturjualpost', [ControllerTransReturPenjualan::class, 'post'])->name('treturjualpost');
    Route::get('treturjuallist', [ControllerTransReturPenjualan::class, 'list'])->name('treturjuallist');
    Route::get('/treturjual/{treturh}/edit', [ControllerTransReturPenjualan::class, 'getedit'])->name('treturjualedit');
    Route::post('/treturjual/{treturh}', [ControllerTransReturPenjualan::class, 'update'])->name('treturjualupdate');
    Route::post('/treturjual/delete/{treturh}', [ControllerTransReturPenjualan::class, 'delete'])->name('treturjualdelete');

    Route::get('tadjustmentstock', [ControllerTransAdjustmentStock::class, 'index'])->name('tadjustmentstock');
    Route::post('/tadjpost', [ControllerTransAdjustmentStock::class, 'post'])->name('tadjpost');
    Route::get('tadjlist', [ControllerTransAdjustmentStock::class, 'list'])->name('tadjlist');
    Route::get('/tadj/{tadjh}/edit', [ControllerTransAdjustmentStock::class, 'getedit'])->name('tadjedit');
    Route::post('/tadj/{tadjh}', [ControllerTransAdjustmentStock::class, 'update'])->name('tadjupdate');
    Route::post('/tadj/delete/{tadjh}', [ControllerTransAdjustmentStock::class, 'delete'])->name('tadjdelete');

    Route::get('tbonjual', [ControllerTransBonPenjualan::class, 'index'])->name('tbonjual');
    Route::post('/tbonjualpost', [ControllerTransBonPenjualan::class, 'post'])->name('tbonjualpost');
    Route::get('tbonjuallist', [ControllerTransBonPenjualan::class, 'list'])->name('tbonjuallist');
    Route::get('/tbonjual/{tpenjualanh}/edit', [ControllerTransBonPenjualan::class, 'getedit'])->name('tbonjualedit');
    Route::post('/tbonjual/{tpenjualanh}', [ControllerTransBonPenjualan::class, 'update'])->name('tbonjualupdate');
    Route::post('/tbonjual/delete/{tpenjualanh}', [ControllerTransBonPenjualan::class, 'delete'])->name('tbonjualdelete');
    Route::get('/tbonjual/{tpenjualanh}/print', [ControllerTransBonPenjualan::class, 'print'])->name('tbonjualprint');
    Route::get('/tbonjual/{tpenjualanh}/printmatrix', [ControllerTransBonPenjualan::class, 'printmatrix'])->name('tbonjualprintmatrix');
    Route::get('/tbonjual/{tpenjualanh}/printpdfbonjual', [ControllerTransBonPenjualan::class, 'printpdfbonjual'])->name('printpdfbonjual');

    Route::get('tsuratjalan', [ControllerTransSuratJalan::class, 'index'])->name('tsuratjalan');
    Route::post('/tsuratjalanpost', [ControllerTransSuratJalan::class, 'post'])->name('tsuratjalanpost');
    Route::post('/getnosobd', [ControllerTransSuratJalan::class, 'getnosob'])->name('getnosobd');
    Route::post('/getcounter', [ControllerTransSuratJalan::class, 'getcounter'])->name('getcounter');
    Route::get('tsuratjalanlist', [ControllerTransSuratJalan::class, 'list'])->name('tsuratjalanlist');
    Route::get('/tsuratjalan/{tsjh}/edit', [ControllerTransSuratJalan::class, 'getedit'])->name('tsuratjalanedit');
    Route::post('/tsuratjalan/{tsjh}', [ControllerTransSuratJalan::class, 'update'])->name('tsuratjalanupdate');
    Route::post('/tsuratjalan/delete/{tsjh}', [ControllerTransSuratJalan::class, 'delete'])->name('tsuratjalandelete');
    Route::get('/tsuratjalan/{tsjh}/print', [ControllerTransSuratJalan::class, 'print'])->name('tsuratjalanprint');
    Route::get('/tsuratjalan/{tsjh}/printitem', [ControllerTransSuratJalan::class, 'printItem'])->name('tsuratjalanprintitem');
    Route::get('/tsuratjalan/{tsjh}/printpdf', [ControllerTransSuratJalan::class, 'printpdf'])->name('tsuratjalanprintpdf');

    Route::get('tpembelianbarang', [ControllerTransPembelianBarang::class, 'index'])->name('tpembelianbarang');
    Route::post('/tpembelianbarangpost', [ControllerTransPembelianBarang::class, 'post'])->name('tpembelianbarangpost');
    Route::get('tpembelianbaranglist', [ControllerTransPembelianBarang::class, 'list'])->name('tpembelianbaranglist');
    Route::get('/tpembelianbarang/{tpembelianh}/edit', [ControllerTransPembelianBarang::class, 'getedit'])->name('tpembelianbarangedit');
    Route::post('/tpembelianbarang/{tpembelianh}', [ControllerTransPembelianBarang::class, 'update'])->name('tpembelianbarangupdate');
    Route::post('/tpembelianbarang/delete/{tpembelianh}', [ControllerTransPembelianBarang::class, 'delete'])->name('tpembelianbarangdelete');

    Route::get('texpense', [ControllerTransExpense::class, 'index'])->name('texpense');
    Route::post('texpensepost', [ControllerTransExpense::class, 'post'])->name('texpensepost');
    Route::get('texpense/{texpenseh}/edit', [ControllerTransExpense::class, 'getedit'])->name('texpenseedit');
    Route::post('texpense/{texpenseh}', [ControllerTransExpense::class, 'update'])->name('texpenseupdate');
    Route::post('texpense/delete/{texpenseh}', [ControllerTransExpense::class, 'delete'])->name('texpensedelete');
    // ---Report---
    Route::get('tstockopname', [ControllerTransStockOpname::class, 'index'])->name('tstockopname');

    Route::get('rlaperoutlet', [ControllerReportPerOutlet::class, 'index'])->name('rlaperoutlet');
    Route::get('rlaperoutletsearch', [ControllerReportPerOutlet::class, 'post'])->name('rlaperoutletpost');
    Route::get('rlaperoutletprint', [ControllerReportPerOutlet::class, 'print'])->name('rlaperoutletprint');

    Route::get('romsetitem', [ControllerReportOmsetItem::class, 'index'])->name('romsetitem');
    Route::get('romsetitemsearch', [ControllerReportOmsetItem::class, 'post'])->name('romsetitempost');
    Route::get('romsetitemexcl', [ControllerReportOmsetItem::class, 'exportExcel'])->name('romsetitemexcel');

    Route::get('romsetcounter', [ControllerReportOmsetPecounter::class, 'index'])->name('romsetcounter');
    Route::get('romsetcountersearch', [ControllerReportOmsetPecounter::class, 'post'])->name('romsetcounterpost');
    Route::get('romsetcounterexcl', [ControllerReportOmsetPecounter::class, 'exportExcel'])->name('romsetcounterexcl');

    Route::get('rmutasistock', [ControllerReportMutasiStock::class, 'index'])->name('rmutasistock');
    Route::get('rmutasistocksearch', [ControllerReportMutasiStock::class, 'post'])->name('rmutasistockpost');
    Route::get('rmutasistockexcl', [ControllerReportMutasiStock::class, 'exportExcel'])->name('rmutasistockexcl');

    Route::get('rlapstockpercounter', [ControllerReportStockCounter::class, 'index'])->name('rlapstockpercounter');
    Route::get('rlapstockpercountersearch', [ControllerReportStockCounter::class, 'post'])->name('rlapstockpercounterpost');
    Route::get('rlapstockpercounterexcl', [ControllerReportStockCounter::class, 'exportExcel'])->name('rlapstockpercounterexcl');

    Route::get('rstockoverview', [ControllerReportStockOverview::class, 'index'])->name('rstockoverview');
    Route::get('rstockoverviewsearch', [ControllerReportStockOverview::class, 'post'])->name('rstockoverviewpost');
    Route::get('rstockoverviewexcl', [ControllerReportStockOverview::class, 'exportExcel'])->name('rstockoverviewexcl');
});
