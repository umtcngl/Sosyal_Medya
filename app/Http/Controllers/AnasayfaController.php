<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Gonderi;
use App\Models\Takip;
use Illuminate\Support\Facades\DB;

class AnasayfaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Giriş yapmış kullanıcının ve onun takip ettikleri kişilerin gönderilerini çek
        $takipEdilenIds = Takip::where('takipci_id', $user->id)->pluck('takip_edilen_id')->toArray();
        array_push($takipEdilenIds, $user->id);  // Kendi ID'sini de ekle

        $takip_istegi_sayisi = $user->takipIstekleri()->count();
        $gonderiler = Gonderi::whereIn('kullanici_id', $takipEdilenIds)->withCount('begeniler')->latest()->get();

        // Kullanıcının beğendiği gönderilerin ID'lerini al
        $begenilenGonderiIds = $user->begenilenGonderiler()->pluck('gonderi_id')->toArray();

        return view('anasayfa', compact('gonderiler', 'takip_istegi_sayisi', 'begenilenGonderiIds'));
    }

}

