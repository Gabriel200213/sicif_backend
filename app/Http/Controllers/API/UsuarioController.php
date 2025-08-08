<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['rol', 'estado'])->get();
        return response()->json(['data' => $usuarios], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'ap_paterno' => 'required|string|max:50',
            'ap_materno' => 'nullable|string|max:50',
            'correo' => 'required|email|max:100|unique:usuario',
            'contraseña_hash' => 'required|string',
            'id_rol' => 'required|exists:roles,id_rol',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = $request->all();
        $data['contraseña_hash'] = Hash::make($request->contraseña_hash);
        $usuario = Usuario::create($data);
        return response()->json(['data' => $usuario->load(['rol', 'estado'])], 201);
    }

    public function show($id)
    {
        $usuario = Usuario::with(['rol', 'estado'])->findOrFail($id);
        return response()->json(['data' => $usuario], 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'ap_paterno' => 'required|string|max:50',
            'ap_materno' => 'nullable|string|max:50',
            'correo' => 'required|email|max:100|unique:usuario,correo,' . $id . ',id_usuario',
            'contraseña_hash' => 'nullable|string',
            'id_rol' => 'required|exists:roles,id_rol',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = $request->all();
        if ($request->has('contraseña_hash') && !empty($request->contraseña_hash)) {
            $data['contraseña_hash'] = Hash::make($request->contraseña_hash);
        } else {
            unset($data['contraseña_hash']);
        }

        $usuario->update($data);
        return response()->json(['data' => $usuario->load(['rol', 'estado'])], 200);
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado'], 200);
    }
}