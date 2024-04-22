<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yorum extends Model
{
    protected $fillable = ['gonderi_id', 'kullanici_id', 'icerik'];
    protected $table = 'yorumlar';
    public function kullanici()
    {
        return $this->belongsTo(User::class);
    }

    public function gonderi()
    {
        return $this->belongsTo(Gonderi::class);
    }
}
