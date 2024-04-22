@extends('layouts.app')

@section('title', $user->ad . ' - Profil')

@section('content')
    <!-- Profil içeriği buraya gelecek -->
    <div class="card">
        <!-- Profil bilgileri -->
        <div class="card-header">Profil Sayfası - {{ $user->ad}}</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="d-flex align-items-center">
                    <!-- Profil Resmi -->
                    <img src="{{ asset($user->profil_resmi) }}" alt="Profil Resmi" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    <h5 class="ms-3 p-3">{{ $user->ad }}</h5>
                </div>
                <!-- Gönderi sayısı -->
                <span class="text-muted small align-items-center">Gönderi <br>{{ $user->gonderiler->count() }}</span>
                <!-- Takipçi sayısı -->
                <span class="text-muted small align-items-center">Takipçi <br>{{ $user->takipciler->count() }}</span>
                <!-- Takip edilen sayısı -->
                <span class="text-muted small align-items-center">Takip <br>{{ $user->takipEdilenler->count() }}</span>
            </div>
            <div class="small p-2">
                <p class="text-muted">
                    {!! nl2br(e($user->aciklama)) !!}
                </p>
            </div>

            <hr>
            @php
                $isFollowing = auth()->user()->isFollowing($user->id);
            @endphp
            @if ($user->gizli == 1 && !$isFollowing)
                <div class="alert alert-warning d-flex justify-content-between align-items-center p-3" role="alert">
                    Bu kullanıcının profili gizli. İçeriği görebilmek için takip etmelisiniz{{$isFollowing}}

                    @php
                        $takipIstegiVar = App\Models\TakipIstegi::where('takip_eden_id', auth()->id())->where('takip_edilen_id', $user->id)->exists();
                        $takipVar = App\Models\Takip::where('takipci_id', auth()->id())->where('takip_edilen_id', $user->id)->exists();
                    @endphp

                    @if (!$takipIstegiVar && !$takipVar)
                        <form action="{{ route('takip.istek.gonder', ['kullanici' => $user->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-user-plus"></i> Takip Et
                            </button>
                        </form>
                    @elseif ($takipIstegiVar)
                        <button type="button" class="btn btn-outline-secondary btn-sm" disabled>Takip İsteği Gönderildi</button>
                    @endif
                </div>
            @else
            <!-- Menü barı -->
            <div class="menu-bar mt-3 mb-3">
                <ul class="nav nav-tabs d-flex justify-content-between align-items-center nav-fill">
                    <li class="nav-item">
                        <a class="nav-link active" id="fotograflar-tab" data-bs-toggle="tab" href="#fotograflar" role="tab" aria-controls="fotograflar" aria-selected="true">Fotoğraflı Gönderiler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="yazilar-tab" data-bs-toggle="tab" href="#yazilar" role="tab" aria-controls="yazilar" aria-selected="false">Yazılar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="takipciler-tab" data-bs-toggle="tab" href="#takipciler" role="tab" aria-controls="takipciler" aria-selected="false">Takipçiler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="takip_edilen-tab" data-bs-toggle="tab" href="#takip_edilen" role="tab" aria-controls="takip_edilen" aria-selected="false">Takip Edilenler</a>
                    </li>
                </ul>
            </div>

            <!-- İçerik -->
            <div class="tab-content">
                <!-- Fotoğraflı Gönderiler sekmesi -->
                <div class="tab-pane fade show active" id="fotograflar" role="tabpanel" aria-labelledby="fotograflar-tab">
                    <!-- Fotoğraflı gönderiler -->
                    <div class="row">
                        @foreach($user->gonderiler->where('resim_yolu', '!=', null) as $gonderi)
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('gonderi.show', ['id' => $gonderi->id]) }}" class="card card123123" style="text-decoration: none;height:200px">
                                    <img src="{{ asset($gonderi->resim_yolu) }}" class="card-img-top" alt="Gönderi Resmi">
                                    <div class="card-body">
                                        <p class="card-text small d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $gonderi->created_at->diffForHumans() }}</small>
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Yazılar sekmesi -->
                <div class="tab-pane fade" id="yazilar" role="tabpanel" aria-labelledby="yazilar-tab">
                    <div class="row">
                        <!-- Yazılar -->
                        @foreach($gonderiler->reverse() as $gonderi)
                            @if(!$gonderi->resim_yolu)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('gonderi.show', ['id' => $gonderi->id]) }}" class="card card123123" style="text-decoration: none;">
                                        <div class="card-body">
                                            <p class="card-text">{{ $gonderi->icerik }}</p>
                                            <p class="card-text"><small class="text-muted">Paylaşılma Tarihi: {{ $gonderi->created_at->format('d/m/Y H:i') }}</small></p>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- Takipçiler sekmesi -->
                <div class="tab-pane fade" id="takipciler" role="tabpanel" aria-labelledby="takipciler-tab">
                    <!-- Takipçiler içeriği -->
                    <ul class="list-group">
                        @foreach($takipciler as $takipci)
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            @php
                                $user = auth()->user();
                                $isCurrentUser = $user && $user->id == $takipci->takipci->id;
                                $profileRoute = $isCurrentUser ? 'profil' : 'profil.display'; // Eğer kullanıcı, listelenen kişi ise kendi profil sayfası, değilse genel profil görüntüleme sayfası
                            @endphp
                            <a class="btn" href="{{ route($profileRoute, ['id' => $takipci->takipci->id]) }}" style="text-decoration: none; color: inherit;">
                                <div class="justify-content-between align-items-center">
                                    <img src="{{ asset($takipci->takipci->profil_resmi) }}" alt="Profil Resmi" class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover;">
                                    {{ $takipci->takipci->ad }}
                                </div>
                            </a>
                        </li>
                    @endforeach

                    </ul>
                </div>


                <!-- Takip Edilenler sekmesi -->
                <div class="tab-pane fade" id="takip_edilen" role="tabpanel" aria-labelledby="takip_edilen-tab">
                    <!-- Takip Edilenler içeriği -->
                    <ul class="list-group">
                        @foreach($takipEdilenler as $takipEdilen)
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                @php
                                    $user = auth()->user();
                                    $isCurrentUser = $user && $user->id == $takipEdilen->takipEdilen->id;
                                    $profileRoute = $isCurrentUser ? 'profil' : 'profil.display'; // Eğer kullanıcı, listelenen kişi ise kendi profil sayfası, değilse genel profil görüntüleme sayfası
                                @endphp
                                <a class="btn" href="{{ route($profileRoute, ['id' => $takipEdilen->takipEdilen->id]) }}" style="text-decoration: none; color: inherit;">
                                    <div class="justify-content-between align-items-center">
                                        <img src="{{ asset($takipEdilen->takipEdilen->profil_resmi) }}" alt="Profil Resmi" class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover;">
                                        {{ $takipEdilen->takipEdilen->ad }}
                                    </div>
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>


                </div>
                </div>
                </div>
                <!-- Gönderi Modalı -->
                <div class="modal fade" id="gonderiModal" tabindex="-1" role="dialog" aria-labelledby="gonderiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="gonderiModalLabel">Gönderi Detayı</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body" id="gonderiDetay">
                <!-- Gönderi detayları burada gösterilecek -->
                </div>
                </div>
                </div>
                </div>
                @endif
                @endsection

