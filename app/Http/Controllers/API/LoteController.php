<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoteController extends Controller
{
    public function index()
    {
        $lotes = Lote::with(['producto', 'almacen'])->get();
        return response()->json(['data' => $lotes], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'fecha_compra' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'cantidad_inicial' => 'required|numeric|min:0',
            'cantidad_actual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $lote = Lote::create($request->all());
        return response()->json(['data' => $lote->load(['producto', 'almacen'])], 201);
    }

    public function show($id)
    {
        $lote = Lote::with(['producto', 'almacen'])->findOrFail($id);
        return response()->json(['data' => $lote], 200);
    }

    public function update(Request $request, $id)
    {
        $lote = Lote::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|exists:productos,id_producto',
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'fecha_compra' => 'required|date',
            'fecha_vencimiento' => 'nullable|date',
            'cantidad_inicial' => 'required|numeric|min:0',
            'cantidad_actual' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $lote->update($request->all());
        return response()->json(['data' => $lote->load(['producto', 'almacen'])], 200);
    }

    public function destroy($id)
    {
        $lote = Lote::findOrFail($id);
        $lote->delete();
        return response()->json(['message' => 'Lote eliminado'], 200);
    }
}