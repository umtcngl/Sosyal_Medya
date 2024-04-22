@extends('layouts.app')

@section('title', 'Ayarlar')

@section('content')
            <div class="card">
                <div class="card-header">Ayarlar</div>

                <div class="card-body">
                    <!-- Kullanıcı adı değiştirme formu -->
                    <form class="d-flex justify-content-between align-items-center p-3" method="POST" action="{{ route('kullanici_adi_degistir') }}">
                        @csrf
                        <div class="mb-5">
                            <label for="ad" class="form-label">Kullanıcı Adı</label>
                            <input type="text" class="form-control" id="ad" name="ad" value="{{ auth()->user()->ad }}" required>
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Kullanıcı Adını Değiştir</button>
                    </form>
                    <hr>
                    <!-- Açıklama değiştirme formu -->
                    <form class="d-flex justify-content-between align-items-center p-3" method="POST" action="{{ route('aciklama_ekle') }}">
                        @csrf

                        <div class="mb-5">
                            <label for="aciklama" class="form-label">Açıklama</label>
                            <textarea style="width:400px;height:100px" class="form-control form-control-sm" id="aciklama" name="aciklama">{{ auth()->user()->aciklama }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-primary btn-sm">Açıklamayı Kaydet</button>
                    </form>
                    <hr>
                    <!-- Profil fotoğrafı ekleme/değiştirme formu -->
                    <form class="d-flex justify-content-between align-items-center p-3" method="POST" action="{{ route('profil_fotografi_degistir') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-5">
                            <label for="profil_resmi" class="form-label">Profil Fotoğrafı</label>
                            <input type="file" class="form-control" id="profil_resmi" name="profil_resmi">
                        </div>

                        <button type="submit" class="btn btn-outline-primary btn-sm">Profil Fotoğrafını Değiştir</button>
                    </form>
                    <hr>

                    <!-- Şifre değiştirme formu -->
                    <form  method="POST" action="{{ route('sifre_degistir') }}">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <div class="mb-5">
                                <label for="eski_sifre" class="form-label">Eski Şifre</label>
                                <input type="password" class="form-control form-control-sm" id="eski_sifre" name="eski_sifre" required>
                            </div>

                            <div class="mb-5">
                                <label for="sifre" class="form-label">Yeni Şifre</label>
                                <input type="password" class="form-control form-control-sm" id="sifre" name="sifre" required>
                            </div>

                            <div class="mb-5">
                                <label for="sifre_confirmation" class="form-label">Yeni Şifre Tekrar</label>
                                <input type="password" class="form-control form-control-sm" id="sifre_confirmation" name="sifre_confirmation" required>
                            </div>


                            <button type="submit" class="btn btn-outline-primary btn-sm">Şifreyi Değiştir</button>
                        </div>

                    </form>
                    <hr>



                    <!-- Hesap gizliliği ayarı -->
                    <form class="d-flex justify-content-between align-items-center p-3" method="POST" action="{{ route('hesap_gizliligi_degistir') }}">
                        @csrf

                        <label class="form-check-label me-2">Hesabımı Gizle</label>
                        <input type="hidden" name="gizli" value="{{ auth()->user()->gizli ? '0' : '1' }}">
                        <button type="submit" class="btn btn-outline-primary">{{ auth()->user()->gizli ? 'Gizliliği Kaldır' : 'Gizliliği Aktif Et' }}</button>
                    </form>

                    <hr>
                </div>
            </div>
@endsection
