<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Categorias;
use App\Models\CompraCliente;

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
            'productosNuevos' => $productosNuevos
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
        ->get();

        $categoria = DB::table('categorias')
        ->select('categorias.nameCategoria')
        ->where('categorias.idCategoria', $categoria)
        ->first();

        return response()->json([
            'productos' => $productosCategoria,
            'categoria' => $categoria,
        ]);

    }

    public function getProducto($producto){

        $dataProducto = DB::table('productos')
        ->join('categorias', 'productos.categoria_id', '=', 'categorias.idCategoria')
        ->where('productos.idProducto', $producto)
        ->select('productos.*', 'categorias.nameCategoria')
        ->first();

        $moreProductos = DB::table('productos')
        ->join('categorias', 'productos.categoria_id', '=', 'categorias.idCategoria')
        ->where('productos.idProducto', '<>', $producto)
        ->where('categorias.idCategoria', $dataProducto->categoria_id)
        ->where('productos.mostrar', 1)
        ->select('productos.*', 'categorias.nameCategoria')
        ->latest()
        ->limit(4)
        ->get();

        return response()->json([
            'producto' => $dataProducto,
            'moreProductos' => $moreProductos,
        ]);
    }

    public function getAllProductos(){
        $allProductos = DB::table('productos')
        ->select('productos.*')
        //->paginate(10)
        ->get();

        return response()->json([
            'productos' => $allProductos
        ]);
    }

    public function storeShopClient(Request  $request){
        return $request;
        
        $validation = $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'required|numeric',
            'productos' => 'required'
        ]);

        $listaCompra = new CompraCliente;
        $listaCompra->NombreCliente = $request->nombre;
        $listaCompra->Telefono = $request->telefono;
        $listaCompra->productos =$request->productos;
        $listaCompra->save();

        return response()->json([
            'mensaje' => 'Su lista de compra a sido enviada en breve se pondran en contacto al numero que proporciono'
        ]);
    }
}
