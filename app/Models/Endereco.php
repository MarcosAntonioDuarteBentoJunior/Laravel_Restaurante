<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'logradouro', 'numero', 'bairro', 'principal', 'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pedidos() {
        return $this->hasMany(Pedido::class);
    }
}
