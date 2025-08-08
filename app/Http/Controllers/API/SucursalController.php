<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::with(['almacenes'])->get();
        return response()->json(['data' => $sucursales], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_sucursal' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $sucursal = Sucursal::create($request->all());
        return response()->json(['data' => $sucursal->load(['almacenes'])], 201);
    }

    public function show($id)
    {
        $sucursal = Sucursal::with(['almacenes'])->findOrFail($id);
        return response()->json(['data' => $sucursal], 200);
    }

    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_sucursal' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $sucursal->update($request->all());
        return response()->json(['data' => $sucursal->load(['almacenes'])], 200);
    }

    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();
        return response()->json(['message' => 'Sucursal eliminada'], 200);
    }
}