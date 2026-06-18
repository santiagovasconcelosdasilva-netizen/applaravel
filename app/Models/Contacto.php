<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable = [
        'nome',
        'alcunha',
        'telemovel',
        'email',
        'localidade_id',
        'localidade',
        'grupo',
        'foto_perfil',
        'observacoes',
        'tema',
        'mensagem',
    ];

    public function localidadeRegisto(): BelongsTo
    {
        return $this->belongsTo(Localidade::class, 'localidade_id');
    }
}
