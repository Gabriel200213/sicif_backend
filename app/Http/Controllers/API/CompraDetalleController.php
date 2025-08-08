<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompraDetalleController extends Controller
{
    public function index()
    {
        $detalles = CompraDetalle::with(['compra', 'producto'])->get();
        return response()->json(['data' => $detalles], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_compra' => 'required|exists:compras,id_compra',
            'id_producto' => 'required|exists:productos,id_producto',
            'cantidad' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalle = CompraDetalle::create($request->all());
        return response()->json(['data' => $detalle->load(['compra', 'producto'])], 201);
    }

    public function show($id)
    {
        $detalle = CompraDetalle::with(['compra', 'producto'])->findOrFail($id);
        return response()->json(['data' => $detalle], 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = CompraDetalle::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_compra' => 'required|exists:compras,id_compra',
            'id_producto' => 'required|exists:productos,id_producto',
            'cantidad' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalle->update($request->all());
        return response()->json(['data' => $detalle->load(['compra', 'producto'])], 200);
    }

    public function destroy($id)
    {
        $detalle = CompraDetalle::findOrFail($id);
        $detalle->delete();
        return response()->json(['message' => 'Detalle de compra eliminado'], 200);
    }
}