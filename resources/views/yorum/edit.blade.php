@extends('layouts.app')

@section('title', 'Yorum Düzenle')

@section('content')
<div class="container">
    <h2>Yorum Düzenle</h2>
    <form method="POST" action="{{ route('yorum.update', $yorum->id) }}">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="icerik" class="form-label">Yorum</label>
            <textarea class="form-control" id="icerik" name="icerik" rows="3" required>{{ $yorum->icerik }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</div>
@endsection
