<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AyarlarController extends Controller
{
    public function index()
    {
        $takip_istegi_sayisi = auth()->user()->takipIstekleri()->count();
        // Ayarlar sayfasını göstermek için view döndür
        return view('ayarlar', compact('takip_istegi_sayisi'));
    }

    public function kullanici_adi_degistir(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->ad = $request->ad;
        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı adı başarıyla güncellendi.');
    }

    public function aciklama_ekle(Request $request)
    {
        $request->validate([
            'aciklama' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();
        $user->aciklama = $request->aciklama;
        $user->save();

        return redirect()->back()->with('success', 'Açıklama başarıyla güncellendi.');
    }

    public function profil_fotografi_degistir(Request $request)
    {
        $request->validate([
            'profil_resmi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Eğer bir profil fotoğrafı dosyası yüklendi ise
        if ($request->hasFile('profil_resmi')) {
            // Mevcut profil fotoğrafını kontrol et ve gerekirse sil
            $currentImagePath = $user->profil_resmi;
            $defaultImagePath = 'images/profil_resmi/default.png';

            if ($currentImagePath && $currentImagePath != $defaultImagePath) {
                // Dosyanın var olup olmadığını kontrol et ve sil
                if (file_exists(public_path($currentImagePath))) {
                    unlink(public_path($currentImagePath));
                }
            }

            $image = $request->file('profil_resmi');

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->move(public_path('images/profil_resmi'), $imageName);

            if ($path) {
                $user->profil_resmi = 'images/profil_resmi/' . $imageName;
                $user->save();
                return redirect()->back()->with('success', 'Profil fotoğrafı başarıyla güncellendi.');
            } else {
                return redirect()->back()->with('error', 'Dosya yüklenemedi.');
            }
        } else {
            return redirect()->back()->with('error', 'Profil fotoğrafı seçilmedi.');
        }
    }




    public function sifre_degistir(Request $request)
    {
        $request->validate([
            'eski_sifre' => 'required|string|min:8',
            'sifre' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (password_verify($request->eski_sifre, $user->sifre)) {
            $user->sifre = bcrypt($request->sifre);
            $user->save();

            return redirect()->back()->with('success', 'Şifre başarıyla değiştirildi.');
        }

        return redirect()->back()->with('error', 'Eski şifre doğru değil.');
    }

    public function hesap_gizliligi_degistir(Request $request)
    {
        $user = auth()->user();
        $user->gizli = $user->gizli ? false : true;
        $user->save();

        return redirect()->back()->with('success', 'Hesap gizliliği başarıyla güncellendi.');
    }
}
