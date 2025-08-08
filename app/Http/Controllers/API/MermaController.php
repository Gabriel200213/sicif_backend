<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MermaController extends Controller
{
    public function index()
    {
        $mermas = Merma::with(['almacen', 'lote', 'usuario'])->get();
        return response()->json(['data' => $mermas], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'id_lote' => 'required|exists:lotes,id_lote',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'motivo' => 'required|string|max:255',
            'cantidad_perdida' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $merma = Merma::create($request->all());
        return response()->json(['data' => $merma->load(['almacen', 'lote', 'usuario'])], 201);
    }

    public function show($id)
    {
        $merma = Merma::with(['almacen', 'lote', 'usuario'])->findOrFail($id);
        return response()->json(['data' => $merma], 200);
    }

    public function update(Request $request, $id)
    {
        $merma = Merma::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_almacen' => 'required|exists:almacenes,id_almacen',
            'id_lote' => 'required|exists:lotes,id_lote',
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'motivo' => 'required|string|max:255',
            'cantidad_perdida' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $merma->update($request->all());
        return response()->json(['data' => $merma->load(['almacen', 'lote', 'usuario'])], 200);
    }

    public function destroy($id)
    {
        $merma = Merma::findOrFail($id);
        $merma->delete();
        return response()->json(['message' => 'Merma eliminada'], 200);
    }
}