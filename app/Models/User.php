<?php

namespace App\Models;

use App\Models\TakipIstegi;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ad',
        'eposta',
        'sifre',
        'profil_resmi', // Yeni eklenen sütun
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kullanicilar'; // Tablo adını 'kullanicilar' olarak ayarlayın

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'sifre',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function takipEdenler()
    {
        return $this->belongsToMany(User::class, 'takip_istekleri', 'takip_edilen_id', 'takip_eden_id')->withPivot('onaylandi_mi', 'iptal_edildi_mi')->withTimestamps();
    }

    public function takipIstekleri()
    {
        return $this->hasMany(TakipIstegi::class, 'takip_edilen_id');
    }

    public function gonderiler()
    {
        return $this->hasMany(Gonderi::class, 'kullanici_id');
    }

    public function takipciler()
    {
        return $this->hasMany(Takip::class, 'takip_edilen_id');
    }

    public function takipEdilenler()
    {
        return $this->hasMany(Takip::class, 'takipci_id');
    }

    public function isFollowing($userId)
    {
        return Takip::where('takipci_id', $this->id)
                    ->where('takip_edilen_id', $userId)
                    ->exists();
    }

    public function begenilenGonderiler()
    {
        return $this->belongsToMany(Gonderi::class, 'begeniler', 'kullanici_id', 'gonderi_id');
    }

}
