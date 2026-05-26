<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $fillable = [
        'nome',
        'alcunha',
        'telemovel',
        'email',
        'localidade',
        'observacoes',
        'tema',
        'mensagem',
    ];
}
