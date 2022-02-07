<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraCliente extends Model
{
    use HasFactory;

    protected $table = 'compracliente';
    protected $primaryKey = 'idCompra';

    protected $fillable = [
        'NombreCliente',
        'Telefono',
        'productos',
        'estatus'
    ];
}
