<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoAlmacenController extends Controller
{
    public function index()
    {
        $tipos = TipoAlmacen::all();
        return response()->json(['data' => $tipos], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_tipo' => 'required|string|max:50|unique:tipos_almacen',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tipo = TipoAlmacen::create($request->all());
        return response()->json(['data' => $tipo], 201);
    }

    public function show($id)
    {
        $tipo = TipoAlmacen::findOrFail($id);
        return response()->json(['data' => $tipo], 200);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoAlmacen::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_tipo' => 'required|string|max:50|unique:tipos_almacen,nombre_tipo,' . $id . ',id_tipo_almacen',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $tipo->update($request->all());
        return response()->json(['data' => $tipo], 200);
    }

    public function destroy($id)
    {
        $tipo = TipoAlmacen::findOrFail($id);
        $tipo->delete();
        return response()->json(['message' => 'Tipo de almacén eliminado'], 200);
    }
}