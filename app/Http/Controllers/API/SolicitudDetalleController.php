<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SolicitudDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SolicitudDetalleController extends Controller
{
    public function index()
    {
        $detalles = SolicitudDetalle::with(['solicitud', 'producto'])->get();
        return response()->json(['data' => $detalles], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
            'id_producto' => 'required|exists:productos,id_producto',
            'cantidad_solicitada' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalle = SolicitudDetalle::create($request->all());
        return response()->json(['data' => $detalle->load(['solicitud', 'producto'])], 201);
    }

    public function show($id)
    {
        $detalle = SolicitudDetalle::with(['solicitud', 'producto'])->findOrFail($id);
        return response()->json(['data' => $detalle], 200);
    }

    public function update(Request $request, $id)
    {
        $detalle = SolicitudDetalle::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_solicitud' => 'required|exists:solicitudes,id_solicitud',
            'id_producto' => 'required|exists:productos,id_producto',
            'cantidad_solicitada' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $detalle->update($request->all());
        return response()->json(['data' => $detalle->load(['solicitud', 'producto'])], 200);
    }

    public function destroy($id)
    {
        $detalle = SolicitudDetalle::findOrFail($id);
        $detalle->delete();
        return response()->json(['message' => 'Detalle de solicitud eliminado'], 200);
    }
}