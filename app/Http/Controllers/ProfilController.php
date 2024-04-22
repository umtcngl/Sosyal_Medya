<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Gonderi;
use App\Models\User;
use App\Models\Takip;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show()
    {
        // Auth kullanıcısının gönderilerini getir
        $gonderiler = Gonderi::where('kullanici_id', auth()->user()->id)->get();

        // Kullanıcının gönderi sayısını doğrudan sayarak alabilirsiniz
        $gonderiSayisi = auth()->user()->gonderiler()->count();

        // Kullanıcının takipçi sayısını doğrudan sayarak alabilirsiniz
        $takipciSayisi = auth()->user()->takipciler()->count();

        // Kullanıcının takip edilen sayısını doğrudan sayarak alabilirsiniz
        $takipEdilenSayisi = auth()->user()->takipEdilenler()->count();

        $takip_istegi_sayisi = auth()->user()->takipIstekleri()->count();

        $takipciler = auth()->user()->takipciler()->with('takipci')->get();
        $takipEdilenler = auth()->user()->takipEdilenler()->with('takipEdilen')->get();

        // Profil sayfasını göster ve gerekli verileri ile
        return view('profile', compact('gonderiler', 'gonderiSayisi', 'takipciSayisi', 'takipEdilenSayisi','takip_istegi_sayisi','takipciler','takipEdilenler'));
    }
    public function takiptenCik(Request $request)
    {
        $takipciId = auth()->user()->id;
        $takipEdilenId = $request->input('takip_edilen_id');

        // Takipten çıkarma işlemini gerçekleştir
        if (Takip::takiptenCik($takipciId, $takipEdilenId)) {
            return redirect()->back()->with('success', 'Takipten çıkarıldı.');
        } else {
            return redirect()->back()->with('error', 'Takip bulunamadı veya zaten çıkarılmış.');
        }
    }

    public function takipci_kaldır(Request $request)
{
    $takipciId = $request->input('takip_edilen_id');
    $takipEdilenId = auth()->user()->id;

    // Takip modelinde tanımlı olan takiptenCik yöntemini kullanarak takipten çıkarma işlemini gerçekleştir
    if (Takip::takiptenCik($takipciId, $takipEdilenId)) {
        return redirect()->back()->with('success', 'Takipten çıkarıldı.');
    } else {
        return redirect()->back()->with('error', 'Takip bulunamadı veya zaten çıkarılmış.');
    }
}


public function display($id)
{
    $user = User::findOrFail($id);
    // Eğer giriş yapan kullanıcı ile profiline tıklanan kullanıcı aynıysa
    if (auth()->id() == $id) {
        // Auth kullanıcısının gönderilerini getir
        $gonderiler = Gonderi::where('kullanici_id', auth()->user()->id)->get();

        // Kullanıcının gönderi sayısını doğrudan sayarak alabilirsiniz
        $gonderiSayisi = auth()->user()->gonderiler()->count();

        // Kullanıcının takipçi sayısını doğrudan sayarak alabilirsiniz
        $takipciSayisi = auth()->user()->takipciler()->count();

        // Kullanıcının takip edilen sayısını doğrudan sayarak alabilirsiniz
        $takipEdilenSayisi = auth()->user()->takipEdilenler()->count();

        $takip_istegi_sayisi = auth()->user()->takipIstekleri()->count();

        $takipciler = auth()->user()->takipciler()->with('takipci')->get();
        $takipEdilenler = auth()->user()->takipEdilenler()->with('takipEdilen')->get();

        // Profil sayfasını göster ve gerekli verileri ile
        return view('profile', compact('gonderiler', 'gonderiSayisi', 'takipciSayisi', 'takipEdilenSayisi','takip_istegi_sayisi','takipciler','takipEdilenler'));
    }
    else{
            // Auth kullanıcısının gönderilerini getir
    $gonderiler = Gonderi::where('kullanici_id', $user->id)->get();

    // Kullanıcının gönderi sayısını doğrudan sayarak alabilirsiniz
    $gonderiSayisi = $user->gonderiler()->count();

    // Kullanıcının takipçi sayısını doğrudan sayarak alabilirsiniz
    $takipciSayisi = $user->takipciler()->count();

    // Kullanıcının takip edilen sayısını doğrudan sayarak alabilirsiniz
    $takipEdilenSayisi = $user->takipEdilenler()->count();

    $takip_istegi_sayisi = auth()->user()->takipIstekleri()->count();

    $takipciler = $user->takipciler()->with('takipci')->get();
    $takipEdilenler = $user->takipEdilenler()->with('takipEdilen')->get();

    // Burada, kullanıcıyla ilgili diğer verileri de yükleyebilirsiniz.
    return view('profiles.display', compact('user','gonderiler', 'gonderiSayisi', 'takipciSayisi', 'takipEdilenSayisi','takip_istegi_sayisi','takipciler','takipEdilenler'));
    }
}
}
