<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::all();
        return response()->json(['data' => $estados], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_estado' => 'required|string|max:50|unique:estados',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $estado = Estado::create($request->all());
        return response()->json(['data' => $estado], 201);
    }

    public function show($id)
    {
        $estado = Estado::findOrFail($id);
        return response()->json(['data' => $estado], 200);
    }

    public function update(Request $request, $id)
    {
        $estado = Estado::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_estado' => 'required|string|max:50|unique:estados,nombre_estado,' . $id . ',id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $estado->update($request->all());
        return response()->json(['data' => $estado], 200);
    }

    public function destroy($id)
    {
        $estado = Estado::findOrFail($id);
        $estado->delete();
        return response()->json(['message' => 'Estado eliminado'], 200);
    }
}