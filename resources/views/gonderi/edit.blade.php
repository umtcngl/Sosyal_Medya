<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gönderi Düzenle</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-thumbnail{
            width: 50%
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Gönderi Düzenle</div>
                    <div class="card-body">
                        <form action="{{ route('gonderi.update', $gonderi->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- _method alanı ile güncelleme işleminin PUT metodu ile olduğunu belirtiyoruz -->
                            <input type="hidden" name="_method" value="PUT">
                            <div class="mb-3">
                                <label for="icerik" class="form-label">İçerik</label>
                                <textarea class="form-control" id="icerik" name="icerik" rows="3">{{ $gonderi->icerik }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="resim" class="form-label">Resim</label>
                                @if($gonderi->resim_yolu)
                                    <img src="{{ asset($gonderi->resim_yolu) }}" class="img-thumbnail mb-3" alt="Mevcut Resim">
                                    <input type="checkbox" id="resim-kaldir" name="resim_kaldir">
                                    <label for="resim-kaldir">Fotoğrafı Kaldır</label>
                                @endif
                                <input type="file" class="form-control" id="resim" name="resim">
                            </div>
                            <button type="submit" class="btn btn-outline-success">Gönderiyi Güncelle</button>
                            <a href="{{ route('anasayfa') }}" class="btn btn-outline-danger">İptal</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
