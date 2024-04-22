<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Takip extends Model
{
    protected $fillable = [
        'takipci_id',
        'takip_edilen_id',
    ];
    protected $table = 'takipler';
    // Belongsto ilişkileri tanımlayabilirsiniz
    public function takipci()
    {
        return $this->belongsTo(User::class, 'takipci_id');
    }

    public function takipEdilen()
    {
        return $this->belongsTo(User::class, 'takip_edilen_id');
    }
    // Takipten çıkarma işlemini gerçekleştiren yöntem
    public static function takiptenCik($takipciId, $takipEdilenId)
    {
        // Belirtilen ilişkiyi bul
        $takip = static::where('takipci_id', $takipciId)
                       ->where('takip_edilen_id', $takipEdilenId)
                       ->first();

        // Eğer ilişki bulunduysa, sil
        if ($takip) {
            $takip->delete();
            return true; // Başarı durumunu döndür
        }
        return false; // Başarısız durumu döndür
    }
}
