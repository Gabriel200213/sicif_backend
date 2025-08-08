<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovimientoInventarioController extends Controller
{
    public function index()
    {
        $movimientos = MovimientoInventario::with(['almacen', 'lote', 'tipo_movimiento', 'usuario', 'compra', 'entrega', 'merma'])->get();
        return response()->json(['data' => $movimientos], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'id_lote' => 'required|exists:lotes,id_lote',
            'id_tipo_movimiento' => 'required|exists:tipos_movimiento,id_tipo_movimiento',
            'cantidad' => 'required|numeric|min:0',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_compra' => 'nullable|exists:compras,id_compra',
            'id_entrega' => 'nullable|exists:entregas,id_entrega',
            'id_merma' => 'nullable|exists:mermas,id_merma',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $movimiento = MovimientoInventario::create($request->all());
        return response()->json(['data' => $movimiento->load(['almacen', 'lote', 'tipo_movimiento', 'usuario', 'compra', 'entrega', 'merma'])], 201);
    }

    public function show($id)
    {
        $movimiento = MovimientoInventario::with(['almacen', 'lote', 'tipo_movimiento', 'usuario', 'compra', 'entrega', 'merma'])->findOrFail($id);
        return response()->json(['data' => $movimiento], 200);
    }

    public function update(Request $request, $id)
    {
        $movimiento = MovimientoInventario::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'id_lote' => 'required|exists:lotes,id_lote',
            'id_tipo_movimiento' => 'required|exists:tipos_movimiento,id_tipo_movimiento',
            'cantidad' => 'required|numeric|min:0',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_compra' => 'nullable|exists:compras,id_compra',
            'id_entrega' => 'nullable|exists:entregas,id_entrega',
            'id_merma' => 'nullable|exists:mermas,id_merma',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $movimiento->update($request->all());
        return response()->json(['data' => $movimiento->load(['almacen', 'lote', 'tipo_movimiento', 'usuario', 'compra', 'entrega', 'merma'])], 200);
    }

    public function destroy($id)
    {
        $movimiento = MovimientoInventario::findOrFail($id);
        $movimiento->delete();
        return response()->json(['message' => 'Movimiento de inventario eliminado'], 200);
    }
}