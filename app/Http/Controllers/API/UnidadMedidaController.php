<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UnidadMedida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnidadMedidaController extends Controller
{
    public function index()
    {
        $unidades = UnidadMedida::all();
        return response()->json(['data' => $unidades], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_unidad' => 'required|string|max:50|unique:unidades_medida',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $unidad = UnidadMedida::create($request->all());
        return response()->json(['data' => $unidad], 201);
    }

    public function show($id)
    {
        $unidad = UnidadMedida::findOrFail($id);
        return response()->json(['data' => $unidad], 200);
    }

    public function update(Request $request, $id)
    {
        $unidad = UnidadMedida::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_unidad' => 'required|string|max:50|unique:unidades_medida,nombre_unidad,' . $id . ',id_unidad_medida',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $unidad->update($request->all());
        return response()->json(['data' => $unidad], 200);
    }

    public function destroy($id)
    {
        $unidad = UnidadMedida::findOrFail($id);
        $unidad->delete();
        return response()->json(['message' => 'Unidad de medida eliminada'], 200);
    }
}