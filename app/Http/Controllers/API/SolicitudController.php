<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SolicitudController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitud::with(['almacen_origen', 'almacen_destino', 'usuario_solicitante', 'estado', 'detalles'])->get();
        return response()->json(['data' => $solicitudes], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_almacen_origen' => 'required|exists:almacenes,id_almacen',
            'id_almacen_destino' => 'required|exists:almacenes,id_almacen',
            'id_usuario_solicitante' => 'required|exists:usuario,id_usuario',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $solicitud = Solicitud::create($request->all());
        return response()->json(['data' => $solicitud->load(['almacen_origen', 'almacen_destino', 'usuario_solicitante', 'estado', 'detalles'])], 201);
    }

    public function show($id)
    {
        $solicitud = Solicitud::with(['almacen_origen', 'almacen_destino', 'usuario_solicitante', 'estado', 'detalles'])->findOrFail($id);
        return response()->json(['data' => $solicitud], 200);
    }

    public function update(Request $request, $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_almacen_origen' => 'required|exists:almacenes,id_almacen',
            'id_almacen_destino' => 'required|exists:almacenes,id_almacen',
            'id_usuario_solicitante' => 'required|exists:usuario,id_usuario',
            'id_estado' => 'required|exists:estados,id_estado',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $solicitud->update($request->all());
        return response()->json(['data' => $solicitud->load(['almacen_origen', 'almacen_destino', 'usuario_solicitante', 'estado', 'detalles'])], 200);
    }

    public function destroy($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->delete();
        return response()->json(['message' => 'Solicitud eliminada'], 200);
    }
}