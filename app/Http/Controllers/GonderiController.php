<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Gonderi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Takip;
class GonderiController extends Controller
{

    // Gönderi oluşturma formunu göstermek için kullanılır
    public function create()
    {
        return view('gonderi.create');
    }
    public function show($id)
    {
        $user = Auth::user();

        // Kullanıcının giriş yapmış olduğu gönderiyi çek ve beğeni sayısını hesapla
        $gonderi = Gonderi::with(['begeniler', 'yorumlar.kullanici'])
                          ->withCount('begeniler')  // Beğeni sayısını çek
                          ->findOrFail($id);

        // Giriş yapmış kullanıcının ve onun takip ettikleri kişilerin gönderilerini çek
        $takipEdilenIds = Takip::where('takipci_id', $user->id)->pluck('takip_edilen_id')->toArray();
        array_push($takipEdilenIds, $user->id);  // Kendi ID'sini de ekle

        $takip_istegi_sayisi = $user->takipIstekleri()->count();

        // Kullanıcının beğendiği gönderilerin ID'lerini al
        $begenilenGonderiIds = $user->begenilenGonderiler()->pluck('gonderi_id')->toArray();

        return view('gonderi.show', compact('gonderi', 'takip_istegi_sayisi', 'begenilenGonderiIds'));
    }




    // Gönderi oluşturulan verileri kaydetmek için kullanılır
    public function store(Request $request)
    {
        // Gönderi oluşturma formundan gelen verilerin doğrulaması yapılır
        $request->validate([
            'resim' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Resim dosyası doğrulama kuralları
            'icerik' => 'required|string|max:255', // İçerik doğrulama kuralları
        ]);

        // Eğer bir resim dosyası yüklendi ise
        if ($request->hasFile('resim')) {
            // Resim dosyasını belirtilen klasöre yükle (public/images)
            $file_name = time() . '.' . $request->file('resim')->getClientOriginalExtension();
            $request->file('resim')->move(public_path('images'), $file_name);
            // Resim yolunu uygun formata getir
            $resimPath = 'images/' . $file_name;
        } else {
            $resimPath = null; // Eğer resim yüklenmediyse null olarak ayarla
        }



        // Yeni bir Gönderi modeli oluştur
        $gonderi = new Gonderi();
        // Kullanıcıya ait ID'yi ata
        $gonderi->kullanici_id = auth()->user()->id;
        // Resim yolunu ata
        $gonderi->resim_yolu = $resimPath;
        // İçeriği ata
        $gonderi->icerik = $request->icerik;
        // Gönderiyi veritabanına kaydet
        $gonderi->save();

        // Kullanıcıyı ana sayfaya yönlendir ve başarı mesajıyla birlikte
        return redirect()->route('anasayfa')->with('success', 'Gönderi başarıyla oluşturuldu.');
    }


    public function edit($id)
    {
        // Düzenleme formunu göstermek için gerekli verileri hazırla
        $gonderi = Gonderi::findOrFail($id);

        // Düzenleme formunu göster
        return view('gonderi.edit', compact('gonderi'));
    }

    public function update(Request $request, $id)
    {
        // Gönderiyi bul
        $gonderi = Gonderi::findOrFail($id);

        // Gönderi güncelleme formundan gelen verilerin doğrulaması yap
        $request->validate([
            'icerik' => 'required|string|max:255', // İçerik doğrulama kuralları
        ]);

        // Eğer "resim_kaldir" checkbox'u işaretli ise
        if ($request->has('resim_kaldir')) {
            // Eğer gönderinin resim yolu mevcutsa, resmi sil
            if ($gonderi->resim_yolu) {
                File::delete(public_path($gonderi->resim_yolu));
                // Veritabanındaki resim_yolu sütununu null yap
                $gonderi->resim_yolu = null;
            }
        } elseif ($request->hasFile('resim')) {
            // Eğer yeni bir resim yüklendi ise
            // Eski resmi sil
            if ($gonderi->resim_yolu) {
                File::delete(public_path($gonderi->resim_yolu));
            }

            // Yeni resimi yükle
            $file_name = time() . '.' . $request->file('resim')->getClientOriginalExtension();
            $request->file('resim')->move(public_path('images'), $file_name);
            $resimPath = 'images/' . $file_name;

            // Yeni resim yolu ata
            $gonderi->resim_yolu = $resimPath;
        }

        // İçeriği ata
        $gonderi->icerik = $request->icerik;

        // Gönderiyi veritabanında güncelle
        $gonderi->save();

        // Kullanıcıyı ana sayfaya yönlendir ve başarı mesajı ile birlikte
        return redirect()->route('anasayfa')->with('success', 'Gönderi başarıyla güncellendi.');
    }





    public function destroy($id)
{
    // Gönderiyi veritabanından bul
    $gonderi = Gonderi::findOrFail($id);

    // Gönderiye ait resmi sil
    if ($gonderi->resim_yolu) {
        File::delete(public_path($gonderi->resim_yolu));
    }

    // Gönderiyi sil
    $gonderi->delete();

    // Kullanıcıyı ana sayfaya yönlendir ve başarı mesajıyla birlikte
    return redirect()->route('anasayfa')->with('success', 'Gönderi başarıyla silindi.');
}


public function begen(Request $request, $id)
{
    $user = auth()->user();

    // Önce kullanıcının bu gönderi için mevcut bir beğeni olup olmadığını kontrol et
    $begeni = \App\Models\Begeni::where('gonderi_id', $id)
                                ->where('kullanici_id', $user->id)
                                ->first();

    if ($begeni) {
        // Eğer beğeni varsa, beğeniyi sil
        $begeni->delete();
        return back()->with('success', 'Beğeni kaldırıldı!');
    } else {
        // Eğer beğeni yoksa, yeni bir beğeni ekle
        $begeni = new \App\Models\Begeni();
        $begeni->gonderi_id = $id;
        $begeni->kullanici_id = $user->id;
        $begeni->save();
        return back()->with('success', 'Gönderi beğenildi!');
    }
}


public function yorum(Request $request, $id)
{
    $request->validate([
        'yorum' => 'required|string|max:255', // Yorum için basit bir doğrulama
    ]);

    $user = auth()->user();

    // Yorum veritabanına eklenir
    $yorum = new \App\Models\Yorum();
    $yorum->gonderi_id = $id;
    $yorum->kullanici_id = $user->id;
    $yorum->icerik = $request->yorum;
    $yorum->save();

    return back()->with('success', 'Yorum yapıldı!');
}


}
