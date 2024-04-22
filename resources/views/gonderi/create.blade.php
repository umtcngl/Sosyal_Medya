<!-- create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gönderi Oluştur</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Gönderi Oluştur</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('gonderi.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="resim">Resim Seç</label>
                                <input type="file" class="form-control" id="resim" name="resim">
                            </div>

                            <div class="mb-3">
                                <label for="icerik">İçerik</label>
                                <textarea class="form-control" id="icerik" name="icerik" rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn btn-outline-success">Gönderi Oluştur</button>
                            <a href="{{ route('anasayfa') }}" class="btn btn-outline-danger">İptal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
