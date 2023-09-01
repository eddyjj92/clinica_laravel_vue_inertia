<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher',
        'voucher_id',
        'estado'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d/m/Y');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(Solicitud::class,'solicitude_id');
    }

    public function cuestionario(): HasOne
    {
        return $this->hasOne(Cuestionario::class);
    }
}
