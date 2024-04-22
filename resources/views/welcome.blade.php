<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoş Geldiniz</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100 align-items-center">
            <div class="col text-center">
                <h1 class="mb-3">Hoş Geldiniz!</h1>
                <img src="\images\default.png" alt="Welcome Image" class="img-fluid rounded-pill mb-5">
                <p class="lead">Sitemize hoş geldiniz, aşağıdaki butonlarla giriş yapabilir veya kayıt olabilirsiniz.</p>
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Giriş Yap</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-lg ms-5">Kayıt Ol</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
