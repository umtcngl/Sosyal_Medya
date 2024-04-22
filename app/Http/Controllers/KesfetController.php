<?php

namespace App\Http\Controllers;

use App\Models\Gonderi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KesfetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // 'takipEdilenler()' fonksiyonu ile takip edilenlerin ID'lerini çekiyoruz.
        $userIds = $user->takipEdilenler()->pluck('takip_edilen_id')->toArray();

        // Gizli olmayan, takip edilmeyen ve kendi olmayan kullanıcıların gönderilerini getir
        $gonderiler = Gonderi::whereHas('kullanici', function ($query) use ($user, $userIds) {
            $query->where('gizli', 0) // Kullanıcı hesabı gizli olmayan
                  ->whereNotIn('id', $userIds) // Giriş yapmış kullanıcının takip etmediği kullanıcılar
                  ->where('id', '!=', $user->id); // Giriş yapmış kullanıcının kendi ID'si hariç
        })->withCount('begeniler')->latest()->get();

        $takip_istegi_sayisi = $user->takipIstekleri()->count();
        $begenilenGonderiIds = $user->begenilenGonderiler()->pluck('gonderi_id')->toArray();
        return view('kesfet', compact('gonderiler', 'takip_istegi_sayisi','begenilenGonderiIds'));
    }
}
