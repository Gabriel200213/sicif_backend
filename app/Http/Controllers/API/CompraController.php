<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with(['usuario', 'proveedor', 'almacen', 'estado', 'detalles'])->get();
        return response()->json(['data' => $compras], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'total' => 'required|numeric|min:0',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $compra = Compra::create($request->all());
        return response()->json(['data' => $compra->load(['usuario', 'proveedor', 'almacen', 'estado', 'detalles'])], 201);
    }

    public function show($id)
    {
        $compra = Compra::with(['usuario', 'proveedor', 'almacen', 'estado', 'detalles'])->findOrFail($id);
        return response()->json(['data' => $compra], 200);
    }

    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'total' => 'required|numeric|min:0',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $compra->update($request->all());
        return response()->json(['data' => $compra->load(['usuario', 'proveedor', 'almacen', 'estado', 'detalles'])], 200);
    }

    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();
        return response()->json(['message' => 'Compra eliminada'], 200);
    }
}