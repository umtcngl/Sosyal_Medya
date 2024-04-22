<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Begeni extends Model
{
    protected $fillable = ['gonderi_id', 'kullanici_id'];
    protected $table = 'begeniler';
    public function kullanici()
    {
        return $this->belongsTo(User::class);
    }

    public function gonderi()
    {
        return $this->belongsTo(Gonderi::class);
    }

}
