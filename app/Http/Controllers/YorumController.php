<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yorum;
use Illuminate\Support\Facades\Auth;
class YorumController extends Controller
{
    // Yorum Düzenleme Formu
    public function edit($id)
    {
        $yorum = Yorum::findOrFail($id);
        $takip_istegi_sayisi = Auth::user()->takipIstekleri()->count();
        return view('yorum.edit', compact('yorum','takip_istegi_sayisi'));
    }

    // Yorum Güncelleme
    public function update(Request $request, $id)
    {
        $request->validate([
            'icerik' => 'required|string|max:255',
        ]);

        $yorum = Yorum::findOrFail($id);
        $yorum->icerik = $request->icerik;
        $yorum->save();

        return redirect()->route('gonderi.show', $yorum->gonderi_id)
                         ->with('success', 'Yorum başarıyla güncellendi!');
    }

    // Yorum Silme
    public function destroy($id)
    {
        $yorum = Yorum::findOrFail($id);
        $yorum->delete();

        return back()->with('success', 'Yorum silindi!');
    }
}
