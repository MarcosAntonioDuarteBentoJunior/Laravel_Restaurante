<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaHorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'dataHora', 'reservado'
    ];
}
