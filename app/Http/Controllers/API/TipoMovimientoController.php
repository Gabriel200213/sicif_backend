<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoMovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoMovimientoController extends Controller
{
    public function index()
    {
        $tipos = TipoMovimiento::all();
        return response()->json(['data' => $tipos], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_movimiento' => 'required|string|max:50|unique:tipos_movimiento',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tipo = TipoMovimiento::create($request->all());
        return response()->json(['data' => $tipo], 201);
    }

    public function show($id)
    {
        $tipo = TipoMovimiento::findOrFail($id);
        return response()->json(['data' => $tipo], 200);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoMovimiento::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_movimiento' => 'required|string|max:50|unique:tipos_movimiento,nombre_movimiento,' . $id . ',id_tipo_movimiento',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tipo->update($request->all());
        return response()->json(['data' => $tipo], 200);
    }

    public function destroy($id)
    {
        $tipo = TipoMovimiento::findOrFail($id);
        $tipo->delete();
        return response()->json(['message' => 'Tipo de movimiento eliminado'], 200);
    }
}