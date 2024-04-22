<?php
use App\Http\Controllers\TakipController;
use App\Http\Controllers\GonderiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AyarlarController;
use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\KesfetController;
use App\Http\Controllers\YorumController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('anasayfa');
    } else {
        return view('welcome');
    }
});
Route::get('/yorum/{id}/edit', [YorumController::class, 'edit'])->name('yorum.edit');

Route::patch('/yorum/{id}', [YorumController::class, 'update'])->name('yorum.update');

Route::delete('/yorum/{id}', [YorumController::class, 'destroy'])->name('yorum.delete');


Route::get('/begeni-sayisi/{id}', 'GonderiController@getBegeniSayisi');


Route::post('/gonderi/{id}/begen', [GonderiController::class, 'begen'])->name('gonderi.begen');
Route::post('/gonderi/{id}/yorum', [GonderiController::class, 'yorum'])->name('gonderi.yorum');



Route::get('/kesfet', [KesfetController::class, 'index'])->name('kesfet');

Route::post('kullanici/{kullanici}/takip-et', 'TakipController@store')->name('takip.istek.gonder');

Route::get('/profil/{id}', [ProfilController::class, 'display'])->name('profil.display');


Route::post('/aciklama_ekle', [AyarlarController::class, 'aciklama_ekle'])->name('aciklama_ekle');
Route::post('/hesap_gizliligi_degistir', [AyarlarController::class, 'hesap_gizliligi_degistir'])->name('hesap_gizliligi_degistir');
Route::post('/profil_fotografi_degistir', [AyarlarController::class, 'profil_fotografi_degistir'])->name('profil_fotografi_degistir');
Route::post('/sifre_degistir', [AyarlarController::class, 'sifre_degistir'])->name('sifre_degistir');
Route::post('/kullanici_adi_degistir', [AyarlarController::class, 'kullanici_adi_degistir'])->name('kullanici_adi_degistir');
Route::get('/ayarlar', [AyarlarController::class, 'index'])->name('ayarlar');



Route::post('/takipci_kaldır', [ProfilController::class, 'takipci_kaldır'])->name('takipci_kaldır');
Route::post('/takiptencik', [ProfilController::class, 'takiptenCik'])->name('takiptencik');

Route::post('/takip-reddet/{id}', [TakipController::class, 'reddet'])->name('takip.reddet');

Route::post('/takip-onayla/{id}', [TakipController::class, 'onayla'])->name('takip.onayla');

Route::get('/takip-istekleri', [TakipController::class, 'takipIstekleriGoster'])->name('takip.istekleri');



Route::post('kullanici/{kullanici}/takip-et', [TakipController::class, 'takipEt'])->name('takip.istek.gonder');



Route::post('/takip-et/{takip_edilen_id}', 'TakipController@takipEt')->name('takip.et');



Route::get('/gonderi/{id}', [GonderiController::class, 'show'])->name('gonderi.show');

Route::get('/profil', [ProfilController::class, 'show'])->name('profil');


Route::delete('/gonderi/{id}', [GonderiController::class, 'destroy'])->name('gonderi.delete');

Route::put('/gonderi/{id}', [GonderiController::class, 'update'])->name('gonderi.update');


Route::get('/gonderi-edit/{id}', [GonderiController::class, 'edit'])->name('gonderi.edit');

Route::get('/gonderi-olustur', [GonderiController::class, 'create'])->name('gonderi.create');
Route::post('/gonderi', [GonderiController::class, 'store'])->name('gonderi.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/anasayfa', [AnasayfaController::class, 'index'])->name('anasayfa');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Kayıt olma işlemi
Route::post('/register', [AuthController::class, 'register'])->name('register');
// Giriş yapma işlemi
Route::post('/login', [AuthController::class, 'login'])->name('login');
