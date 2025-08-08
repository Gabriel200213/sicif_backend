<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['unidad_medida'])->get();
        return response()->json(['data' => $categorias], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_categoria' => 'required|string|max:50',
            'id_unidad_medida' => 'required|exists:unidades_medida,id_unidad_medida',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $categoria = Categoria::create($request->all());
        return response()->json(['data' => $categoria->load(['unidad_medida'])], 201);
    }

    public function show($id)
    {
        $categoria = Categoria::with(['unidad_medida'])->findOrFail($id);
        return response()->json(['data' => $categoria], 200);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nombre_categoria' => 'required|string|max:50',
            'id_unidad_medida' => 'required|exists:unidades_medida,id_unidad_medida',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $categoria->update($request->all());
        return response()->json(['data' => $categoria->load(['unidad_medida'])], 200);
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json(['message' => 'Categoria eliminada'], 200);
    }
}