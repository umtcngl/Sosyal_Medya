@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')
<style>
    .card-img-top{
        border-radius: 25px;
    }
</style>

                <!-- İçerik Alanı -->
                <h1 class="mb-4">Akış</h1>
                    <div class="card-body">
                        @foreach ($gonderiler as $gonderi)
                            <div class="card border-info mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center p-2">
                                        <div>
                                            @if ($gonderi->kullanici)
                                                <!-- Kullanıcı İsmine Tıklanınca Profiline Git -->
                                                <h3 class="card-title">
                                                    <!-- Kullanıcı Profiline Gitme Linki -->
                                                    @php
                                                        $user = auth()->user();
                                                        $isOwner = $user && $user->id == $gonderi->kullanici_id;
                                                        $profileRoute = $isOwner ? 'profil' : 'profil.display'; // Profil rotası, kullanıcı sahipse direkt profil sayfası, değilse genel profil görüntüleme sayfası
                                                    @endphp
                                                    <a class="btn" href="{{ route($profileRoute, ['id' => $gonderi->kullanici->id]) }}" style="text-decoration: none; color: inherit;">
                                                        <div class="justify-content-between align-items-center">
                                                            <img src="{{ asset($gonderi->kullanici->profil_resmi) }}" alt="Profil Resmi" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                            {{ $gonderi->kullanici->ad }}
                                                        </div>
                                                    </a>
                                                </h3>

                                            @else
                                                <p class="text-danger">Kullanıcı bulunamadı!</p>
                                            @endif
                                        </div>
                                        <div>
                                            <!-- Kullanıcı Kontrolü ve Düzenle Butonu -->
                                            @if (auth()->check() && $gonderi->kullanici_id == auth()->user()->id)
                                            <div class="btn-group">
                                                <a href="{{ route('gonderi.edit', ['id' => $gonderi->id]) }}" class="btn btn-outline-warning btn-sm" aria-label="Düzenle">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-warning btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="visually-hidden">Ayarlar</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#" onclick="openConfirmDeleteModal('{{ route('gonderi.delete', ['id' => $gonderi->id]) }}')">
                                                        <i class="fas fa-trash-alt"></i> Sil
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        @if (auth()->check() && $gonderi->kullanici_id != auth()->id())
                                        @php
                                            $takipIstegiVar = App\Models\TakipIstegi::where('takip_eden_id', auth()->id())->where('takip_edilen_id', $gonderi->kullanici_id)->exists();
                                            $takipVar = App\Models\Takip::where('takipci_id', auth()->id())->where('takip_edilen_id', $gonderi->kullanici_id)->exists();
                                        @endphp
                                        @if (!$takipIstegiVar && !$takipVar)
                                            <form action="{{ route('takip.istek.gonder', ['kullanici' => $gonderi->kullanici]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-user-plus"></i> Takip Et
                                                </button>
                                            </form>
                                        @elseif ($takipIstegiVar)
                                            <button type="button" class="btn btn-outline-secondary btn-sm" disabled>Takip İsteği Gönderildi</button>
                                        @endif
                                    @endif

                                    </div>

                                    <p class="card-text p-3">{{ $gonderi->icerik }}</p>


                                    <div class="d-flex align-items-center ms-5 ps-5">
                                        @if ($gonderi->resim_yolu)
                                            <img src="{{ asset($gonderi->resim_yolu) }}" class="card-img-top img-fluid" alt="Gönderi Resmi" style="max-width: 500px;">
                                        @endif
                                    </div>

                                    <div class="d-flex flex-row align-items-center justify-content-center w-100 ps-3 mt-3">
                                        <div class="col-2">
                                            <form action="{{ route('gonderi.begen', $gonderi->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn {{ in_array($gonderi->id, $begenilenGonderiIds) ? 'btn-danger' : 'btn-outline-danger' }} btn-sm rounded-pill">
                                                    <i class="fas fa-heart"></i> {{ in_array($gonderi->id, $begenilenGonderiIds) ? 'Beğen' : 'Beğen' }}
                                                    <span class="badge text-bg-danger">{{ $gonderi->begeniler_count }}</span>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-9"></div>


                                        <div class="col-1">
                                            <a href="{{ route('gonderi.show', ['id' => $gonderi->id]) }}" class="btn btn-outline-primary" style="text-decoration: none;">
                                            <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>






                                    <!-- Paylaşılma Tarihi -->
                                    <p class="card-text small d-flex justify-content-between align-items-center p-3">
                                        <small class="text-muted">{{ $gonderi->created_at->diffForHumans() }}</small>
                                        @if ($gonderi->updated_at != $gonderi->created_at)
                                            <small class="text-muted">Düzenlenme Tarihi: {{ $gonderi->updated_at->format('d/m/Y H:i') }}</small>
                                        @endif
                                    </p>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

<!-- Silme Modalı -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Gönderiyi Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bu gönderiyi silmek istediğinize emin misiniz?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Sil</button>
                </form>
            </div>
        </div>
</div>
@endsection
