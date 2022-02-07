<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'finalizado', 'endereco_id'
    ];

    public function items(){
        return $this->belongsToMany(Item::class);
    }

    public function endereco(){
        return $this->belongsTo(Endereco::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
