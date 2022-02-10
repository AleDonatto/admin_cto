<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Http\File;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\ComparaCliente;

class AdminController extends Controller
{
    //
    public function viewCategorias(){
        //$list_Cat = Categorias::all();
        $listaCat = $this->consCategorias();

        return Inertia::render('Admin/Categorias', [
            'list_Cat'=>$listaCat,
        ]);
    }

    private function consCategorias(){
        $list = DB::table('categorias')
        ->select('categorias.*')
        ->orderBy('categorias.idCategoria', 'asc')
        ->get();

        return $list;
    }

    private function consProductos(){
        $list = DB::table('productos')
        ->join('categorias', 'productos.categoria_id','=','categorias.idCategoria')
        ->select('productos.*', 'categorias.nameCategoria')
        ->orderBy('productos.idProducto')
        ->get();

        return $list;
    }

    public function StoreCategorias(Request $request){
        $validated = $request->validate([
            'categoria' => 'required|string',
            'image' => 'image|max:25600|mimes:jpeg,jpg,png,svg'
        ]);

        $path = $request->file('image')->store('images', 'public');

        $categoria = new Categorias;
        $categoria->nameCategoria = $request->categoria;
        $categoria->mostrar = true;
        $categoria->image = $path;
        $categoria->save();

        $listCategorias = $this->consCategorias();

        return response()->json([
            'message' => 'Categoria creada',
            'listcategoria' => $listCategorias,
        ]);
    }

    public function viewProductos(){

        $list_Prod = $this->consProductos();
        $list_Cat = $this->consCategorias();

        return Inertia::render('Admin/Productos', [
            'list_Prod' => $list_Prod,
            'list_Cat' => $list_Cat,
        ]);
    }

    public function StoreProductos(Request $request){
        $validation = $request->validate([
            'producto' => 'required|string',
            'codigo' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'categoria' => 'required|integer',
            'image' => 'image|max:25600|mimes:jpeg,jpg,png,svg'
        ]);

        $path = $request->file('image')->store('images', 'public');

        $producto = new Productos;
        $producto->nameProducto = $request->producto;
        $producto->codigo = $request->codigo;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->categoria_id = $request->categoria;
        $producto->mostrar = true;
        $producto->image = $path;
        $producto->save();

        $list_Prod = $this->consProductos();

        return response()->json([
            'message' => 'Producto agregado correctamente',
            'listproductos' => $list_Prod,
        ]);
    }

    public function updateCategorias(Request $request){
        $validated = $request->validate([
            'categoriaEdit' => 'required|string',
        ]);

        if( is_object($request->imageEdit) ){
            $validation = $request->validate([
                'imageEdit' => 'nullable|image|max:25600|mimes:jpeg,jpg,png,svg',
            ]);

            $path = $request->file('imageEdit')->store('images', 'public');
            Storage::delete('public/'.$request->oldImage);

            $categoria = Categorias::where('idCategoria', $request->idcategoria)
            ->update([
                'nameCategoria' => $request->categoriaEdit,
                'mostrar' => $request->mostrar,
                'image' => $path,
            ]);

            $listCategorias = $this->consCategorias();

            return response()->json([
                'message' => 'Categoria Modificada',
                'listcategoria' => $listCategorias,
            ]);
            
        }

        $categoria = Categorias::where('idCategoria', $request->idcategoria)
        ->update([
            'nameCategoria' => $request->categoriaEdit,
            'mostrar' => $request->mostrar,
        ]);

        $listCategorias = $this->consCategorias();

        return response()->json([
            'message' => 'Categoria Modificada',
            'listcategoria' => $listCategorias,
        ]);
    }

    public function updateProductos(Request $request){
        $validate = $request->validate([
            'productoEdit' => 'required|string',
            'descripcionEdit' => 'required|string',
            'codigoEdit' => 'required|numeric',
            'precioEdit' => 'required|numeric',
            'categoriaEdit' => 'required|numeric',
        ]);

        if(is_object($request->imageEdit)){
            $validate = $request->validate([
                'imageEdit' => 'image|max:25600|mimes:jpeg,jpg,png,svg'
            ]);

            $path = $request->file('imageEdit')->store('images', 'public');
            Storage::delete('public/'.$request->oldImage);

            $producto = Productos::where('idProducto', $request->idproducto)
            ->update([
                'nameProducto' => $request->productoEdit,
                'codigo' => $request->codigoEdit,
                'descripcion' => $request->descripcionEdit,
                'precio' => $request->precioEdit,
                'mostrar' => $request->mostrarEdit,
                'image' => $path,
                'categoria_id' => $request->categoriaEdit,
            ]);

            $list_Prod = $this->consProductos();

            return response()->json([
                'message' => 'Producto Modificado',
                'listproductos' => $list_Prod
            ]);
        }

        $producto = Productos::where('idProducto', $request->idproducto)
        ->update([
            'nameProducto' => $request->productoEdit,
            'codigo' => $request->codigoEdit,
            'descripcion' => $request->descripcionEdit,
            'precio' => $request->precioEdit,
            'mostrar' => $request->mostrarEdit,
            'categoria_id' => $request->categoriaEdit,
        ]);

        $list_Prod = $this->consProductos();

        return response()->json([
            'message' => 'Producto Modificado',
            'listproductos' => $list_Prod
        ]);

    }

    public function deleteProducto($producto){
        $image = DB::table('productos')
        ->where('productos.idProducto', $producto)
        ->select('productos.image')
        ->first();

        try{
            $delete = DB::table('productos')
            ->where('productos.idProducto', $producto)
            ->delete();

            Storage::delete('public/'.$image->image);
            $listProductos = $this->consProductos();

            return response()->json([
                'message'=> 'Producto Eliminado',
                'listproductos' => $listProductos,
            ]);
        }catch(QueryException $ex){
            return response()->json([
                'message' => 'No es posible eliminar el registro seleccionado, otros datos dependen de este',
                'status'=> 'error',
            ]);
        }

    }

    public function deleteCategorias($categoria){
        $image = DB::table('categorias')
        ->where('categorias.idCategoria', $categoria)
        ->select('categorias.image')
        ->first();
        
        try{
            $delete = DB::table('categorias')
            ->where('categorias.idCategoria', $categoria)
            ->delete();

            Storage::delete('public/'.$image->image);
            $listCategorias = $this->consCategorias();

            return response()->json([
                'message' => 'Categoria Eliminada',
                'listcategorias' => $listCategorias,
            ]);
        }catch(QueryException $ex){
            return response()->json([
                'message' => 'No es posible eliminar el registro seleccionado, otras datos dependen de este',
                'status' => 'error'
            ]);
        }
    }

    public function viewPedidos(){

        $listaPedidos = $this->getComprasClientes();

        return Inertia::render('Admin/Pedidos', [
            'listapedidos' => $listaPedidos
        ]);
    }

    public function getListaPedidoCliente($idCompra){

        $listaCompra = DB::table('compracliente')
        ->select('compracliente.productos')
        ->where('compracliente.idCompra', $idCompra)
        ->first();

        $unzip = json_decode($listaCompra->productos);

        return response()->json([
            'lista_productos' => $unzip,
        ]);
    }

    public function updateEstatusCompra($id, Request $request){

        $validation = $request->validate([
            'estatus' => 'required|integer'
        ]);

        $affected = DB::table('compracliente')
        ->where('idCompra', $id)
        ->update([
            'estatus' => $request->estatus,
        ]);

        $updateListaPedidos = $this->getComprasClientes();

        return response()->json([
            'message' => 'Compra actualizada',
            'updateListaPedidos' => $updateListaPedidos,
        ]);
    }

    private function getComprasClientes(){

        $listaPedidos = DB::table('compracliente')
        ->select('idCompra','NombreCliente', 'Telefono', 'estatus', 'created_at')
        ->orderBy('compracliente.estatus')
        ->get();

        return $listaPedidos;
    }
}
