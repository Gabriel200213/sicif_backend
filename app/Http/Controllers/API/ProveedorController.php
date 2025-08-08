<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return response()->json(['data' => $proveedores], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_proveedor' => 'required|string|max:100',
            'direccion_proveedor' => 'nullable|string|max:255',
            'telefono_proveedor' => 'nullable|string|max:20',
            'correo_proveedor' => 'nullable|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $proveedor = Proveedor::create($request->all());
        return response()->json(['data' => $proveedor], 201);
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return response()->json(['data' => $proveedor], 200);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_proveedor' => 'required|string|max:100',
            'direccion_proveedor' => 'nullable|string|max:255',
            'telefono_proveedor' => 'nullable|string|max:20',
            'correo_proveedor' => 'nullable|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $proveedor->update($request->all());
        return response()->json(['data' => $proveedor], 200);
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return response()->json(['message' => 'Proveedor eliminado'], 200);
    }
}