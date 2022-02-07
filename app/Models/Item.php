<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'preco', 'image'
    ];

    public function pedidos() {
        return $this->belongsToMany(Pedido::class);
    }
}
