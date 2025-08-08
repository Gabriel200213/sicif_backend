<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Entrega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EntregaController extends Controller
{
    public function index()
    {
        $entregas = Entrega::with(['solicitud', 'usuario_entrega', 'estado', 'detalles'])->get();
        return response()->json(['data' => $entregas], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
            'id_usuario_entrega' => 'required|exists:usuario,id_usuario',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $entrega = Entrega::create($request->all());
        return response()->json(['data' => $entrega->load(['solicitud', 'usuario_entrega', 'estado', 'detalles'])], 201);
    }

    public function show($id)
    {
        $entrega = Entrega::with(['solicitud', 'usuario_entrega', 'estado', 'detalles'])->findOrFail($id);
        return response()->json(['data' => $entrega], 200);
    }

    public function update(Request $request, $id)
    {
        $entrega = Entrega::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
            'id_usuario_entrega' => 'required|exists:usuario,id_usuario',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $entrega->update($request->all());
        return response()->json(['data' => $entrega->load(['solicitud', 'usuario_entrega', 'estado', 'detalles'])], 200);
    }

    public function destroy($id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->delete();
        return response()->json(['message' => 'Entrega eliminada'], 200);
    }
}