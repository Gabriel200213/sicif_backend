<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return response()->json(['data' => $roles], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_rol' => 'required|string|max:50|unique:roles',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $rol = Rol::create($request->all());
        return response()->json(['data' => $rol], 201);
    }

    public function show($id)
    {
        $rol = Rol::findOrFail($id);
        return response()->json(['data' => $rol], 200);
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_rol' => 'required|string|max:50|unique:roles,nombre_rol,' . $id . ',id_rol',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $rol->update($request->all());
        return response()->json(['data' => $rol], 200);
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();
        return response()->json(['message' => 'Rol eliminado'], 200);
    }
}