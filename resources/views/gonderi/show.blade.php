@extends('layouts.app')

@section('title', 'Gönderi Detay')

@section('content')
<style>
    .card-img-top {
        border-radius: 25px;
    }
</style>

<div class="col-12">
    <div class="card">
        <div class="card-header">
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
        </div>

        <div class="card-body p-3">
            <div class="mb-3">
                <p class="fw-lighter">{{ $gonderi->icerik }}</p>
            </div>
            <div class="d-flex align-items-center ps-5 ms-5">
                @if ($gonderi->resim_yolu)
                    <img src="{{ asset($gonderi->resim_yolu) }}" class="card-img-top img-fluid" alt="Gönderi Resmi" style="max-width: 500px;">
                @endif
            </div>
        </div>

        <div class="d-flex flex-row align-items-center justify-content-center w-100 ps-3 mt-3">
            <div class="col-3">
                <form action="{{ route('gonderi.begen', $gonderi->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn {{ in_array($gonderi->id, $begenilenGonderiIds) ? 'btn-danger' : 'btn-outline-danger' }} btn-sm rounded-pill">
                        <i class="fas fa-heart"></i> {{ in_array($gonderi->id, $begenilenGonderiIds) ? 'Beğen' : 'Beğen' }}
                        <span class="badge text-bg-danger">{{ $gonderi->begeniler_count }}</span>
                    </button>
                </form>
            </div>


            <div class="col-9 p-2">
                <form action="{{ route('gonderi.yorum', $gonderi->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control" name="yorum" placeholder="Yorumunuzu yazın..." aria-label="Yorumunuzu yazın">
                        <button class="btn btn-outline-warning" type="submit"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-3">
            <!-- Paylaşılma Tarihi -->
            <p class="card-text small d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ $gonderi->created_at->diffForHumans() }}</small>
                @if ($gonderi->updated_at != $gonderi->created_at)
                    - <small class="text-muted">Düzenlenme Tarihi: {{ $gonderi->updated_at->format('d/m/Y H:i') }}</small>
                @endif
            </p>
        </div>
        <hr>
        <h5 class="p-3 align-items-center">Yorumlar</h5>
        <div class="p-3">
            <hr>
            @forelse ($gonderi->yorumlar as $yorum)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center p-2">
                        <!-- Kullanıcı adını link olarak ayarla -->
                        <strong>
                            @php
                                $user = auth()->user();
                                $isOwner = $user && $user->id == $yorum->kullanici_id;
                                $profileRoute = $isOwner ? 'profil' : 'profil.display';
                            @endphp
                            <a class="btn" href="{{ route($profileRoute, ['id' => $yorum->kullanici->id]) }}" style="text-decoration: none; color: inherit;">
                                <div class="justify-content-between align-items-center">
                                    <img src="{{ asset($yorum->kullanici->profil_resmi) }}" alt="Profil Resmi" class="rounded-circle me-2" style="width: 25px; height: 25px; object-fit: cover;">
                                    {{ $yorum->kullanici->ad }}
                                </div>
                            </a>
                        </strong>
                        @if (auth()->check() && auth()->id() == $yorum->kullanici_id)
                            <!-- Yorum Düzenle ve Sil Butonları -->
                            <div class="btn-group">
                                <a href="{{ route('yorum.edit', ['id' => $yorum->id]) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-outline-danger btn-sm" onclick="openConfirmYorumDeleteModal('{{ route('yorum.delete', ['id' => $yorum->id]) }}', '{{ $yorum->id }}')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="row w-100">
                            <div class="col-9">
                                <p class="text-muted">{{ $yorum->icerik }}</p>
                            </div>
                            <div class="col-3 text-end small">
                                <p class="text-muted small">{{ $yorum->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @empty
                <!-- Eğer yorum yoksa gösterilecek mesaj -->
                <div class="text-center py-5">
                    <p class="text-muted">Henüz yorum yapılmamış. İlk yorumu sen yap!</p>
                </div>
            @endforelse


        </div>
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
</div>

<!-- Yorum Silme Modalı -->
<div class="modal fade" id="confirmYorumDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmYorumDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmYorumDeleteModalLabel">Yorumu Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bu yorumu silmek istediğinize emin misiniz?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                <form id="deleteYorumForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
