<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Sol Menü -->
            <div class="col-md-3 position-fixed" style="top: 50px; bottom: 0; left: 50px; overflow-y: auto;">
                @include('partials.sidebar')
            </div>

            <!-- İçerik -->
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- Başarı mesajı alert -->
                @if(session('success'))
                <div id="successAlert" class="alert alert-success alert-dismissible show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Hata mesajı alert -->
                @if(session('error'))
                <div id="errorAlert" class="alert alert-danger alert-dismissible show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <!-- JavaScript Dosyaları -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sayfa yüklendiğinde alert mesajlarını kontrol et
        document.addEventListener('DOMContentLoaded', function() {
            var successAlert = document.getElementById('successAlert');
            var errorAlert = document.getElementById('errorAlert');

            // Başarı ve hata mesajı alert'lerini otomatik olarak kapat
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 2000);
            }

            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 2000);
            }

            // Başarı ve hata mesajı alert'lerini çarpı simgesine tıklayarak kapat
            if (successAlert) {
                successAlert.querySelector('.btn-close').addEventListener('click', function() {
                    successAlert.style.display = 'none';
                });
            }

            if (errorAlert) {
                errorAlert.querySelector('.btn-close').addEventListener('click', function() {
                    errorAlert.style.display = 'none';
                });
            }
        });
    </script>
    <script>
        function openConfirmDeleteModal(deleteUrl) {
            $('#deleteForm').attr('action', deleteUrl); // Silme formunun action'ını belirli URL'ye ayarla
            $('#confirmDeleteModal').modal('show'); // Modalı göster
        }
    </script>
    <script>
        function openConfirmYorumDeleteModal(url) {
            $('#deleteYorumForm').attr('action', url);
            $('#confirmYorumDeleteModal').modal('show');
        }
        </script>
</body>
</html>
