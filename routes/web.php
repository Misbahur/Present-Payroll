<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\{
    PolaController,
    JabatanController,
    Kelompok_kerjaController,
    Bon_kasController,
    PegawaiController,
    SettingController,
    PengecualianController,
    UserController,
    Komponen_gajiController,
    KehadiranController,
    FingerprintController,
    PenggajianController,
    JadwalController,

};

use App\Models\Pegawai;


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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');

Route::middleware('loggedin')->group(function() {
    Route::get('login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'registerView'])->name('register-view');
    Route::post('register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [PageController::class, 'dashboardOverview1'])->name('dashboard-overview-1');
    Route::get('dashboard-overview-2-page', [PageController::class, 'dashboardOverview2'])->name('dashboard-overview-2');
    Route::get('dashboard-overview-3-page', [PageController::class, 'dashboardOverview3'])->name('dashboard-overview-3');
    Route::get('inbox-page', [PageController::class, 'inbox'])->name('inbox');
    Route::get('file-manager-page', [PageController::class, 'fileManager'])->name('file-manager');
    Route::get('point-of-sale-page', [PageController::class, 'pointOfSale'])->name('point-of-sale');
    Route::get('chat-page', [PageController::class, 'chat'])->name('chat');
    Route::get('post-page', [PageController::class, 'post'])->name('post');
    Route::get('calendar-page', [PageController::class, 'calendar'])->name('calendar');
    Route::get('crud-data-list-page', [PageController::class, 'crudDataList'])->name('crud-data-list');
    Route::get('crud-form-page', [PageController::class, 'crudForm'])->name('crud-form');
    Route::get('users-layout-1-page', [PageController::class, 'usersLayout1'])->name('users-layout-1');
    Route::get('users-layout-2-page', [PageController::class, 'usersLayout2'])->name('users-layout-2');
    Route::get('users-layout-3-page', [PageController::class, 'usersLayout3'])->name('users-layout-3');
    Route::get('profile-overview-1-page', [PageController::class, 'profileOverview1'])->name('profile-overview-1');
    Route::get('profile-overview-2-page', [PageController::class, 'profileOverview2'])->name('profile-overview-2');
    Route::get('profile-overview-3-page', [PageController::class, 'profileOverview3'])->name('profile-overview-3');
    Route::get('wizard-layout-1-page', [PageController::class, 'wizardLayout1'])->name('wizard-layout-1');
    Route::get('wizard-layout-2-page', [PageController::class, 'wizardLayout2'])->name('wizard-layout-2');
    Route::get('wizard-layout-3-page', [PageController::class, 'wizardLayout3'])->name('wizard-layout-3');
    Route::get('blog-layout-1-page', [PageController::class, 'blogLayout1'])->name('blog-layout-1');
    Route::get('blog-layout-2-page', [PageController::class, 'blogLayout2'])->name('blog-layout-2');
    Route::get('blog-layout-3-page', [PageController::class, 'blogLayout3'])->name('blog-layout-3');
    Route::get('pricing-layout-1-page', [PageController::class, 'pricingLayout1'])->name('pricing-layout-1');
    Route::get('pricing-layout-2-page', [PageController::class, 'pricingLayout2'])->name('pricing-layout-2');
    Route::get('invoice-layout-1-page', [PageController::class, 'invoiceLayout1'])->name('invoice-layout-1');
    Route::get('invoice-layout-2-page', [PageController::class, 'invoiceLayout2'])->name('invoice-layout-2');
    Route::get('faq-layout-1-page', [PageController::class, 'faqLayout1'])->name('faq-layout-1');
    Route::get('faq-layout-2-page', [PageController::class, 'faqLayout2'])->name('faq-layout-2');
    Route::get('faq-layout-3-page', [PageController::class, 'faqLayout3'])->name('faq-layout-3');
    Route::get('login-page', [PageController::class, 'login'])->name('login');
    Route::get('register-page', [PageController::class, 'register'])->name('register');
    Route::get('error-page-page', [PageController::class, 'errorPage'])->name('error-page');
    Route::get('update-profile-page', [PageController::class, 'updateProfile'])->name('update-profile');
    Route::get('change-password-page', [PageController::class, 'changePassword'])->name('change-password');
    Route::get('regular-table-page', [PageController::class, 'regularTable'])->name('regular-table');
    Route::get('tabulator-page', [PageController::class, 'tabulator'])->name('tabulator');
    Route::get('modal-page', [PageController::class, 'modal'])->name('modal');
    Route::get('slide-over-page', [PageController::class, 'slideOver'])->name('slide-over');
    Route::get('notification-page', [PageController::class, 'notification'])->name('notification');
    Route::get('accordion-page', [PageController::class, 'accordion'])->name('accordion');
    Route::get('button-page', [PageController::class, 'button'])->name('button');
    Route::get('alert-page', [PageController::class, 'alert'])->name('alert');
    Route::get('progress-bar-page', [PageController::class, 'progressBar'])->name('progress-bar');
    Route::get('tooltip-page', [PageController::class, 'tooltip'])->name('tooltip');
    Route::get('dropdown-page', [PageController::class, 'dropdown'])->name('dropdown');
    Route::get('typography-page', [PageController::class, 'typography'])->name('typography');
    Route::get('icon-page', [PageController::class, 'icon'])->name('icon');
    Route::get('loading-icon-page', [PageController::class, 'loadingIcon'])->name('loading-icon');
    Route::get('regular-form-page', [PageController::class, 'regularForm'])->name('regular-form');
    Route::get('datepicker-page', [PageController::class, 'datepicker'])->name('datepicker');
    Route::get('tail-select-page', [PageController::class, 'tailSelect'])->name('tail-select');
    Route::get('file-upload-page', [PageController::class, 'fileUpload'])->name('file-upload');
    Route::get('wysiwyg-editor-page', [PageController::class, 'wysiwygEditor'])->name('wysiwyg-editor');
    Route::get('validation-page', [PageController::class, 'validation'])->name('validation');
    Route::get('chart-page', [PageController::class, 'chart'])->name('chart');
    Route::get('slider-page', [PageController::class, 'slider'])->name('slider');
    Route::get('image-zoom-page', [PageController::class, 'imageZoom'])->name('image-zoom');
    
    
    // Gocay Routing
    Route::get('/', [KehadiranController::class, 'index'])->name('kehadiran');

    //Fingerprint Manage
    Route::get('fingerprint', [FingerprintController::class, 'index'])->name('fingerprint');
    Route::get('getDataFingerprint', [FingerprintController::class, 'getDataFingerprint'])->name('getDataFingerprint');
    Route::get('cekDataFingerprint', [FingerprintController::class, 'cekDataFingerprint'])->name('cekDataFingerprint');
    Route::get('addPegawaiToFingerprint', [FingerprintController::class, 'addPegawaiToFingerprint'])->name('addPegawaiToFingerprint');
    Route::get('updateFingerData', [FingerprintController::class, 'updateFingerData'])->name('updateFingerData');
    Route::get('cekUserFingerprint', [FingerprintController::class, 'cekUserFingerprint'])->name('cekUserFingerprint');
    Route::post('setUserFingerprint', [FingerprintController::class, 'setUserFingerprint'])->name('setUserFingerprint');
    Route::get('deleteAllUserFingerptint', [FingerprintController::class, 'deleteAllUserFingerptint'])->name('deleteAllUserFingerptint');
    Route::get('deleteAllLogFingerptint', [FingerprintController::class, 'deleteAllLogFingerptint'])->name('deleteAllLogFingerptint');

    //kehadiran Manage
    Route::get('kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
    Route::get('kehadiran_bulanan', [KehadiranController::class, 'kehadiran_bulanan'])->name('kehadiran_bulanan');
    Route::post('kehadiranadd', [KehadiranController::class, 'store'])->name('kehadiranadd');
    Route::get('kehadiranedit', [KehadiranController::class, 'edit'])->name('kehadiranedit');
    Route::POST('kehadiranupdate', [KehadiranController::class, 'update'])->name('kehadiranupdate');
    Route::get('kehadirandelete/{id}', [KehadiranController::class, 'destroy'])->name('kehadirandelete');
    Route::get('filterkehadiran', [KehadiranController::class, 'filterkehadiran'])->name('filter-kehadiran');
    Route::get('getpolakerja', [KehadiranController::class, 'getpolakerja'])->name('getpolakerja');
    Route::get('telatlembur', [KehadiranController::class, 'telatlembur'])->name('telatlembur');
    Route::get('bonusMingguan', [KehadiranController::class, 'bonusMingguan'])->name('bonusMingguan');
    Route::get('bonusBulanan', [KehadiranController::class, 'bonusBulanan'])->name('bonusBulanan');

    // //Kehadian Manage
    // Route::get('kehadiran', [KehadiranController::class, 'index'])->name('kehadiran');
    // Route::post('kehadianadd', [KehadiranController::class, 'store'])->name('kehadianadd');
    // Route::get('kehadianedit', [KehadiranController::class, 'edit'])->name('kehadianedit');
    // Route::POST('kehadianupdate', [KehadiranController::class, 'update'])->name('kehadianupdate');
    // Route::get('kehadiandelete/{id}', [KehadiranController::class, 'destroy'])->name('kehadiandelete');

    
    //Pegawai Manage
    Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::post('pegawaiadd', [PegawaiController::class, 'store'])->name('pegawaiadd');
    Route::get('pegawaiedit', [PegawaiController::class, 'edit'])->name('pegawaiedit');
    Route::POST('pegawaiupdate', [PegawaiController::class, 'update'])->name('pegawaiupdate');
    Route::get('pegawaidelete/{id}', [PegawaiController::class, 'destroy'])->name('pegawaidelete');
    
    
    //Kelompok Kerja Manage
    Route::get('kelompok-kerja', [Kelompok_kerjaController::class, 'index'])->name('kelompok-kerja');
    Route::post('kelompok-kerjaadd', [Kelompok_kerjaController::class, 'store'])->name('kelompok-kerjaadd');
    Route::get('kelompok-kerjaedit', [Kelompok_kerjaController::class, 'edit'])->name('kelompok-kerjaedit');
    Route::POST('kelompok-kerjaupdate', [Kelompok_kerjaController::class, 'update'])->name('kelompok-kerjaupdate');
    Route::get('kelompok-kerjadelete/{id}', [Kelompok_kerjaController::class, 'destroy'])->name('kelompok-kerjadelete');

    //Jadwal Manage
    Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::post('jadwaladd', [JadwalController::class, 'store'])->name('jadwaladd');
    Route::get('jadwaledit', [JadwalController::class, 'edit'])->name('jadwaledit');
    Route::POST('jadwalupdate', [JadwalController::class, 'update'])->name('jadwalupdate');
    Route::get('jadwaldelete/{id}', [JadwalController::class, 'destroy'])->name('jadwaldelete');
    Route::get('filterjadwal', [JadwalController::class, 'filterjadwal'])->name('filter-jadwal');
    
    //Jabatan Manage
    Route::get('jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::post('jabatanadd', [JabatanController::class, 'store'])->name('jabatanadd');
    Route::get('jabatanedit', [JabatanController::class, 'edit'])->name('jabatanedit');
    Route::POST('jabatanupdate', [JabatanController::class, 'update'])->name('jabatanupdate');
    Route::get('jabatandelete/{id}', [JabatanController::class, 'destroy'])->name('jabatandelete');
    
    //Bon-Kas Manage
    Route::get('bon-kas', [Bon_kasController::class, 'index'])->name('bon-kas');
    Route::post('bon-kasadd', [Bon_kasController::class, 'store'])->name('bon-kasadd');
    Route::get('bon-kasedit', [Bon_kasController::class, 'edit'])->name('bon-kasedit');
    Route::POST('bon-kasupdate', [Bon_kasController::class, 'update'])->name('bon-kasupdate');
    Route::get('bon-kasdelete/{id}', [Bon_kasController::class, 'destroy'])->name('bon-kasdelete');
    Route::get('dropdown_jabatan', [Bon_kasController::class, 'dropdown_jabatan'])->name('dropdown_jabatan');
    
    // Pola Kerja Manage
    Route::get('pola-kerja', [PolaController::class, 'index'])->name('pola-kerja');
    Route::post('polakerjaadd', [PolaController::class, 'store'])->name('polakerjaadd');
    Route::get('polakerjaedit', [PolaController::class, 'edit'])->name('polakerjaedit');
    Route::POST('polakerjaupdate', [PolaController::class, 'update'])->name('polakerjaupdate');
    Route::get('polakerjadelete/{id}', [PolaController::class, 'destroy'])->name('polakerjadelete');

    //Kehadian Manage
    Route::get('pengecualian', [PengecualianController::class, 'index'])->name('pengecualian');
    Route::post('pengecualianadd', [PengecualianController::class, 'store'])->name('pengecualianadd');
    Route::get('pengecualianedit', [PengecualianController::class, 'edit'])->name('pengecualianedit');
    Route::POST('pengecualianupdate', [PengecualianController::class, 'update'])->name('pengecualianupdate');
    Route::get('pengecualiandelete/{id}', [PengecualianController::class, 'destroy'])->name('pengecualiandelete');
    Route::get('dropdown_jabatan', [PengecualianController::class, 'dropdown_jabatan'])->name('dropdown_jabatan');

    //Management User 
    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::post('useradd', [UserController::class, 'store'])->name('useradd');
    Route::get('useredit', [UserController::class, 'edit'])->name('useredit');
    Route::post('userupdate', [UserController::class, 'update'])->name('userupdate');
    Route::get('userdelete/{id}', [UserController::class, 'destroy'])->name('userdelete');



    Route::get('kalender', [PageController::class, 'kalender'])->name('kalender');
    // Route::get('gaji', [PageController::class, 'gaji'])->name('gaji');


    Route::get('komponen-gaji', [Komponen_gajiController::class, 'index'])->name('komponen-gaji');
    Route::POST('komponengajiadd', [Komponen_gajiController::class, 'store'])->name('komponengajiadd');
    // Route::POST('bonusharianupdate', [Komponen_gajiController::class, 'bonusharianupdate'])->name('bonusharianupdate');
    Route::POST('bonusmingguanupdate', [Komponen_gajiController::class, 'bonusmingguanupdate'])->name('bonusmingguanupdate');
    Route::POST('bonusbulananupdate', [Komponen_gajiController::class, 'bonusbulananupdate'])->name('bonusbulananupdate');
    Route::POST('lembur', [Komponen_gajiController::class, 'lembur'])->name('lembur');
    Route::POST('keterlambatan', [Komponen_gajiController::class, 'keterlambatan'])->name('keterlambatan');
    Route::POST('liburmasuk', [Komponen_gajiController::class, 'liburmasuk'])->name('liburmasuk');
    Route::POST('masuklibur', [Komponen_gajiController::class, 'masuklibur'])->name('masuklibur');



    Route::post('periodeadd', [PenggajianController::class, 'tambahperiode'])->name('periodeadd');

    Route::get('penggajian', [PenggajianController::class, 'index'])->name('penggajian');
    Route::get('filterperiode', [PenggajianController::class, 'filterperiode'])->name('filterperiode');

    Route::get('lembur', [PageController::class, 'lembur'])->name('lembur');

    Route::get('setting-perusahaan', [SettingController::class, 'index'])->name('setting-perusahaan');
    Route::get('setting-perusahaan/edit/{id}', [SettingController::class, 'edit'])->name('setting-edit');
    Route::post('setting-perusahaan/update/{id}', [SettingController::class, 'update'])->name('setting-update');

});
