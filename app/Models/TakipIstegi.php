<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class TakipIstegi extends Model
{
    protected $fillable = [
        'takip_eden_id',
        'takip_edilen_id',
        'onaylandi_mi',
        'iptal_edildi_mi',
    ];
    protected $table = 'takip_istekleri';
    // User modeli ile ilişkiyi tanımladık
    public function takipci()
    {
        return $this->belongsTo(User::class, 'takip_eden_id');
    }

    // User modeli ile ilişkiyi tanımladık
    public function takipEdilen()
    {
        return $this->belongsTo(User::class, 'takip_edilen_id');
    }

}
