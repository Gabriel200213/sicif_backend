<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::with(['sucursal', 'tipo_almacen', 'usuario'])->get();
        return response()->json(['data' => $almacenes], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_sucursal' => 'required|exists:sucursales,id_sucursal',
            'id_tipo_almacen' => 'required|exists:tipos_almacen,id_tipo_almacen',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'nombre_almacen' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $almacen = Almacen::create($request->all());
        return response()->json(['data' => $almacen->load(['sucursal', 'tipo_almacen', 'usuario'])], 201);
    }

    public function show($id)
    {
        $almacen = Almacen::with(['sucursal', 'tipo_almacen', 'usuario'])->findOrFail($id);
        return response()->json(['data' => $almacen], 200);
    }

    public function update(Request $request, $id)
    {
        $almacen = Almacen::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_sucursal' => 'required|exists:sucursales,id_sucursal',
            'id_tipo_almacen' => 'required|exists:tipos_almacen,id_tipo_almacen',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'nombre_almacen' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $almacen->update($request->all());
        return response()->json(['data' => $almacen->load(['sucursal', 'tipo_almacen', 'usuario'])], 200);
    }

    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->delete();
        return response()->json(['message' => 'Almacen eliminado'], 200);
    }
}