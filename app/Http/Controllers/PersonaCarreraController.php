<?php

namespace App\Http\Controllers;

use App\Models\PersonaCarrera;
use App\Models\Persona;
use App\Models\Carrera;
use Illuminate\Http\Request;

class PersonaCarreraController extends Controller
{
    public function index()
    {
        return PersonaCarrera::with(['persona', 'carrera'])->get();
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

            // Verify if carrera exists
            if (!Carrera::find($request->carrera_idcarrera)) {
                return response()->json([
                    'error' => 'La carrera especificada no existe'
                ], 404);
            }

            $personaCarrera = PersonaCarrera::create($request->all());
            return response()->json($personaCarrera, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear la relación persona-carrera',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($persona_id)
    {
        $carreras = PersonaCarrera::where('persona_idpersona', $persona_id)
            ->with(['carrera:idcarrera,nombre'])
            ->get()
            ->map(function ($item) {
                return [
                    'nombre_carrera' => $item->carrera->nombre
                ];
            });
            
        if ($carreras->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron carreras registradas para esta persona'
            ], 404);
        }

        return response()->json($carreras);
    }

    public function update(Request $request, $id)
    {
        $personaCarrera = PersonaCarrera::findOrFail($id);
        $personaCarrera->update($request->all());
        return response()->json($personaCarrera, 200);
    }

    public function destroy($id)
    {
        $personaCarrera = PersonaCarrera::findOrFail($id);
        $personaCarrera->delete();
        return response()->json(null, 204);
    }
}