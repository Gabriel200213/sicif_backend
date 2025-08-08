<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\EntregaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntregaDetalleController extends Controller
{
    public function index()
    {
        $detalles = EntregaDetalle::with(['entrega', 'lote'])->get();
        return response()->json(['data' => $detalles], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_entrega' => 'required|exists:entregas,id_entrega',
            'id_lote' => 'required|exists:lotes,id_lote',
            'cantidad_entregada' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalle = EntregaDetalle::create($request->all());
        return response()->json(['data' => $detalle->load(['entrega', 'lote'])], 201);
    }

    public function show($id)
    {
        $detalle = EntregaDetalle::with(['entrega', 'lote'])->findOrFail($id);
        return response()->json(['data' => $detalle], 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = EntregaDetalle::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_entrega' => 'required|exists:entregas,id_entrega',
            'id_lote' => 'required|exists:lotes,id_lote',
            'cantidad_entregada' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalle->update($request->all());
        return response()->json(['data' => $detalle->load(['entrega', 'lote'])], 200);
    }

    public function destroy($id)
    {
        $detalle = EntregaDetalle::findOrFail($id);
        $detalle->delete();
        return response()->json(['message' => 'Detalle de entrega eliminado'], 200);
    }
}