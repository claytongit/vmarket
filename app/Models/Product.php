<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'descricao', 'preco', 'estoque'
    ];

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class);
    }
}