<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuestionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'data'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d/m/Y');
    }
}