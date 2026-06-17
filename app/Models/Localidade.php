<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Localidade extends Model
{
    protected $fillable = [
    'nome',
    'localidade',
    'ativa',
];

    protected $casts = [
        'ativa' => 'boolean',
    ];

    public function contactos(): HasMany
    {
        return $this->hasMany(Contacto::class);
    }
}
