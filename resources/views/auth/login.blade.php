<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Giriş Yap</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="kimlik" class="form-label">E-posta Adresi veya Ad Soyad</label>
                                <input id="kimlik" type="text" class="form-control @error('kimlik') is-invalid @enderror" name="kimlik" value="{{ old('kimlik') }}" required autofocus>
                                @error('kimlik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sifre" class="form-label">Şifre</label>
                                <input id="sifre" type="password" class="form-control @error('sifre') is-invalid @enderror" name="sifre" required autocomplete="current-password">
                                @error('sifre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="hatirla" id="hatirla">
                                <label class="form-check-label" for="hatirla">
                                    Beni Hatırla
                                </label>
                            </div>

                            <button type="submit" class="btn btn-outline-primary">Giriş Yap</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        Henüz bir hesabınız yok mu? <a href="{{ route('register') }}" class="card-link">Kayıt Ol</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
