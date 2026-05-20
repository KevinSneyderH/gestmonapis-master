<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAsesoria;
use App\Models\Persona;
use App\Models\Materia;
use Illuminate\Http\Request;

class SolicitudAsesoriaController extends Controller
{
    public function index()
    {
        return SolicitudAsesoria::with(['persona', 'materia'])->get();
    }

    public function store(Request $request)
    {
        try {
            // Verify if persona exists
            if (!Persona::find($request->persona_idpersona)) {
                return response()->json([
                    'error' => 'La persona especificada no existe'
                ], 404);
            }

            // Verify if materia exists
            if (!Materia::find($request->materia_idmateria)) {
                return response()->json([
                    'error' => 'La materia especificada no existe'
                ], 404);
            }

            $solicitud = SolicitudAsesoria::create($request->all());
            return response()->json($solicitud, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear la solicitud de asesoría',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return SolicitudAsesoria::with(['persona', 'materia'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $solicitud = SolicitudAsesoria::findOrFail($id);

            if ($request->has('persona_idpersona') && !Persona::find($request->persona_idpersona)) {
                return response()->json([
                    'error' => 'La persona especificada no existe'
                ], 404);
            }

            if ($request->has('materia_idmateria') && !Materia::find($request->materia_idmateria)) {
                return response()->json([
                    'error' => 'La materia especificada no existe'
                ], 404);
            }

            $solicitud->update($request->all());
            return response()->json($solicitud, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar la solicitud de asesoría',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $solicitud = SolicitudAsesoria::findOrFail($id);
        $solicitud->delete();
        return response()->json(null, 204);
    }
}