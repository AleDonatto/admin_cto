<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Categorias;

class ApiController extends Controller
{
    //
    public function pruebasUnitarias(){
        return response()->json([
            'message' => 'Pruebas unitarias satisfactoria',
        ]);
    }

    public function getCategorias(){
        //$categorias = Categorias::all();
        $categorias = DB::table('categorias')
        ->where('categorias.mostrar', 1)
        ->select('categorias.*')
        ->get();

        return response()->json([
            'categorias' => $categorias
        ]);
    }

    public function getProductosNuevos(){
        $productosNuevos = DB::table('productos')
        ->where('productos.mostrar', 1)
        ->select('productos.*')
        ->latest()
        ->limit(10)
        ->get();

        return response()->json([
            'productosNuevos' => $productosNuevos,
        ]);
    }

    public function getProductosDescuento(){
        $productosDescuento = DB::table('productos')
        ->join('categorias','productos.categoria_id','=','categorias.idCategoria')
        ->where('categorias.idCategoria', 1)
        ->where('productos.mostrar', 1)
        ->select('productos.*')
        ->latest()
        ->limit(10)
        ->get();

        return response()->json([
            'productosDescuento' => $productosDescuento
        ]);
    }

    public function getProductosCategoria($categoria){

        $productosCategoria = DB::table('productos')
        ->join('categorias','productos.categoria_id', '=', 'categorias.idCategoria')
        ->where('categorias.idCategoria', $categoria)
        ->where('productos.mostrar', 1)
        ->select('productos.*', 'categorias.nameCategoria')
        ->paginate(10);

        return response()->json([
            'productos' => $productosCategoria
        ]);

    }

    public function getProducto($producto){

        $dataProducto = DB::table('productos')
        ->join('categorias', 'productos.categoria_id', '=', 'categorias.idCategoria')
        ->where('productos.idProducto', $producto)
        ->select('productos.*', 'categorias.nameCategoria')
        ->get();
    }
}
