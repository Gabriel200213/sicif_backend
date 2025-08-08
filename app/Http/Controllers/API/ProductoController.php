<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'proveedor'])->get();
        return response()->json(['data' => $productos], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_unico' => 'required|string|max:50|unique:productos',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $producto = Producto::create($request->all());
        return response()->json(['data' => $producto->load(['categoria', 'proveedor'])], 201);
    }

    public function show($id)
    {
        $producto = Producto::with(['categoria', 'proveedor'])->findOrFail($id);
        return response()->json(['data' => $producto], 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'codigo_unico' => 'required|string|max:50|unique:productos,codigo_unico,' . $id . ',id_producto',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $producto->update($request->all());
        return response()->json(['data' => $producto->load(['categoria', 'proveedor'])], 200);
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}