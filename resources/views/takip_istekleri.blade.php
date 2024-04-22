@extends('layouts.app')

@section('title', 'Takip İstekleri')

@section('content')

                    <div class="card mb-3">
                        <div class="card-header"><h4>Takip İstekleri</h4></div>
                        <div class="card-body p-3">
                            @if($takipIstekleri->isEmpty())
                                <div class="text-center">
                                    <p class="text-muted">Henüz takip isteği bulunmamaktadır.</p>
                                </div>
                            @else
                                @foreach($takipIstekleri as $istek)
                                <hr>
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div>
                                        <!-- Gönderi Sahibi Profil Fotoğrafı -->
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a class="btn" href="{{ route('profil.display', ['id' => $istek->takipci->id]) }}" style="text-decoration: none; color: inherit;">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($istek->takipci->profil_resmi) }}" alt="Profil Resmi" class="rounded-circle me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                <span>{{ $istek->takipci->ad }}</span>
                                            </div>
                                            </a>
                                            <div class="small">
                                                <small class="ps-5 text-muted">Takip isteği gönderdi : {{ $istek->created_at->diffForHumans() }}</small>
                                            </div>

                                            <form class="ps-5" action="{{ route('takip.onayla', ['id' => $istek->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success"><i class="fas fa-check"></i> Onayla</button>
                                            </form>

                                            <form class="ps-5" action="{{ route('takip.reddet', ['id' => $istek->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger "><i class="fas fa-times"></i> Reddet</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

@endsection
