<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Kayıt Ol</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Ad Soyad</label>
                                <input id="ad" type="text" class="form-control @error('ad') is-invalid @enderror" name="ad" value="{{ old('ad') }}" required autofocus>
                                @error('ad')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-posta Adresi</label>
                                <input id="eposta" type="email" class="form-control @error('eposta') is-invalid @enderror" name="eposta" value="{{ old('eposta') }}" required>
                                @error('eposta')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input id="sifre" type="password" class="form-control @error('sifre') is-invalid @enderror" name="sifre" required autocomplete="new-sifre">
                                @error('sifre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="sifre-confirm" class="form-label">Şifre Onayı</label>
                                <input id="sifre-confirm" type="password" class="form-control" name="sifre_confirmation" required autocomplete="new-sifre">
                            </div>

                            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        Hesabınız var mı? <a href="{{ route('login') }}" class="card-link">Giriş Yap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
