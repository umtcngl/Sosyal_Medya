<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Takip;
use App\Models\Gonderi;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Form geçerlilik denetimi
        $validatedData = $request->validate([
            'ad' => 'required|string|max:255',
            'eposta' => 'required|email|unique:kullanicilar,eposta',
            'sifre' => 'required|string|min:8|confirmed',
        ]);

        // Yeni kullanıcı oluştur
        $user = User::create([
            'ad' => $validatedData['ad'],
            'eposta' => $validatedData['eposta'],
            'sifre' => Hash::make($validatedData['sifre']),
        ]);

        // Kullanıcıyı oturum açmaya giriş yap
        auth()->login($user);

        // Başarılı kayıt olduktan sonra yönlendirme
        return redirect('/')->with('success', 'Kayıt işlemi başarıyla tamamlandı!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'kimlik' => 'required|string', // Kullanıcı adı veya e-posta
            'sifre' => 'required|string',
        ]);

        // Kullanıcı adı veya e-posta ile giriş yapmayı desteklemek için kontrol ekleyelim
        $field = filter_var($credentials['kimlik'], FILTER_VALIDATE_EMAIL) ? 'eposta' : 'ad';

        // Kimlik bilgilerini güncelleyelim
        $credentials[$field] = $credentials['kimlik'];
        unset($credentials['kimlik']);

        // Kullanıcıyı bulalım
        $user = User::where($field, $credentials[$field])->first();

        // Kullanıcıyı doğrula
        if ($user && Hash::check($credentials['sifre'], $user->sifre)) {
            // Başarılı giriş
            $remember = $request->has('hatirla'); // "Beni Hatırla" seçeneği kontrol ediliyor
            Auth::login($user, $remember);

            return redirect()->intended('/anasayfa');
        }

        // Başarısız giriş
        return back()->withErrors([
            'kimlik' => 'Girdiğiniz kimlik bilgileri kayıtlarımızla eşleşmiyor.',
        ])->withInput();
    }

    public function logout(Request $request)
{
    Auth::logout();

    return redirect('/')->with('success', 'Başarıyla çıkış yaptınız.');
}
}
