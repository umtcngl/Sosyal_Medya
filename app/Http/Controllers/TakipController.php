<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TakipIstegi;
use App\Models\Takip;
use App\Models\Gonderi;

class TakipController extends Controller
{
    public function takipEt(Request $request, User $kullanici)
    {
        // Giriş yapmış kullanıcının ID'sini al
        $takip_eden_id = auth()->id();

        // Takip isteğini oluştur
        $kullanici->takipIstekleri()->create([
            'takip_eden_id' => $takip_eden_id,
            'onaylandi_mi' => false,
            'iptal_edildi_mi' => false,
        ]);

        return back()->with('success', 'Takip isteği gönderildi!');
    }

    public function takipIstekleriGoster()
    {
        // Giriş yapan kullanıcının ID'sini al
        $kullanici_id = auth()->id();

        // Giriş yapan kullanıcının aldığı takip isteklerini çek
        $takipIstekleri = TakipIstegi::where('takip_edilen_id', $kullanici_id)->get();
        $takip_istegi_sayisi = auth()->user()->takipIstekleri()->count();
        return view('takip_istekleri', compact('takipIstekleri','takip_istegi_sayisi'));

    }

    public function onayla(Request $request, $istek_id)
    {
        // İlgili takip isteğini bul
        $istek = TakipIstegi::findOrFail($istek_id);

        // Onaylanmış takiplere ekle
        Takip::create([
            'takipci_id' => $istek->takip_eden_id,
            'takip_edilen_id' => $istek->takip_edilen_id,
        ]);

        // Takip isteğini sil
        $istek->delete();

        return redirect()->back()->with('success', 'Takip isteği onaylandı.');
    }

    public function reddet(Request $request, $istek_id)
    {
        // İlgili takip isteğini bul ve sil
        $istek = TakipIstegi::findOrFail($istek_id);
        $istek->delete();

        return redirect()->back()->with('success', 'Takip isteği reddedildi.');
    }
}
