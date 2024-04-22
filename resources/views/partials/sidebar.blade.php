<!-- Sol menü -->
<div class="card border-info">
        <div class="card-body">
            <h5 class="card-title mb-3">Hoş Geldiniz, {{ auth()->user()->ad }} !</h5>
            <div class="mb-3">
                <a href="{{ route('anasayfa') }}" class="btn btn-outline-primary btn-block rounded-pill"><i class="fas fa-home"></i> Anasayfa</a>
            </div>

            <div class="mb-3">
                <a href="{{ route('kesfet') }}" class="btn btn-outline-primary btn-block rounded-pill">
                    <i class="fas fa-compass"></i> Keşfet
                </a>
            </div>

            <div class="mb-3">
                <a href="{{ route('profil') }}" class="btn btn-outline-primary btn-block rounded-pill"><i class="fas fa-user"></i> Profil</a>
            </div>

            <div class="mb-3">
                <a href="{{ route('gonderi.create') }}" class="btn btn-outline-primary btn-block rounded-pill">
                    <i class="fas fa-plus"></i> Gönderi Ekle
                </a>
            </div>

            <div class="mb-3">
                <a href="{{ route('takip.istekleri') }}" class="btn btn-block rounded-pill @if($takip_istegi_sayisi > 0) btn-outline-warning @else btn-outline-primary @endif">
                    <i class="fas fa-envelope"></i> Takip İstekleri
                    @if($takip_istegi_sayisi > 0)
                        <span class="badge text-bg-warning">{{$takip_istegi_sayisi}}</span>
                    @else
                    <span class="badge text-bg-primary">{{$takip_istegi_sayisi}}</span>
                    @endif
                </a>
            </div>

            <div>
                <!-- Ayarlar sayfasına yönlendirme bağlantısı -->
                <a href="{{ route('ayarlar') }}" class="btn btn-outline-secondary mb-3 btn-block rounded-pill"><i class="fas fa-cog"></i> Ayarlar</a>
            </div>



            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-block rounded-pill"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</button>
                </form>
            </div>
        </div>
    </div>
