<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gonderi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kullanici_id',
        'resim_yolu',
        'icerik',
    ];

    protected $table = 'gonderiler';

    public function kullanici()
    {
        return $this->belongsTo(User::class, 'kullanici_id');
    }

    public function begeniler()
    {
        return $this->hasMany(Begeni::class);
    }


    // Beğeni sayısını hesaplamak için bir accessor tanımlayabilirsiniz
    public function getBegeniSayisiAttribute()
    {
        return $this->begeniler->count();
    }

    public function yorumlar()
{
    return $this->hasMany(Yorum::class)->orderBy('created_at', 'desc');
}
    // Diğer ilişkiler ve metotlar buraya eklenebilir

}
