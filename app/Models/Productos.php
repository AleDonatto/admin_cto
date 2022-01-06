<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'idProducto';

    protected $fillable = [
        'nameProducto',
        'codigo',
        'descripcion',
        'precio',
        'image',
        'mostrar',
        'categoria_id',
    ];
}
