<?php

namespace App\Http\Controllers;

use App\Models\PersonaMateria;
use App\Models\Persona;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaMateriaController extends Controller
{
    public function index()
    {
        $monitors = PersonaMateria::with(['persona.carreras.carrera', 'materia'])
            ->get()
            ->groupBy('persona_idpersona')
            ->map(function ($personaMaterias) {
                $persona = $personaMaterias->first()->persona;
                return [
                    'nombre' => $persona->nombres . ' ' . $persona->apellidos,
                    'carrera' => $persona->carreras->first()?->carrera?->nombre ?? 'No asignada',
                    'materias' => $personaMaterias->map(function ($item) {
                        return [
                            'nombre' => $item->materia->nombre,
                            'estado' => $item->activo ? 'Activo' : 'Inactivo',
                            'id' => $item->idpersona_materia
                        ];
                    })->values()
                ];
            })->values();
    
        return response()->json($monitors);
    }
    

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate request
            $request->validate([
                'persona_idpersona' => 'required|exists:persona,idpersona',
                'materia_idmateria' => 'required|exists:materia,idmateria'
            ]);

            // Check if relationship already exists
            $existing = PersonaMateria::where('persona_idpersona', $request->persona_idpersona)
                                    ->where('materia_idmateria', $request->materia_idmateria)
                                    ->first();

            if ($existing) {
                return response()->json([
                    'error' => 'Esta persona ya es monitor de esta materia'
                ], 409);
            }

            $personaMateria = PersonaMateria::create($request->all());

            DB::commit();

            return response()->json([
                'message' => 'Monitor asignado exitosamente',
                'data' => $personaMateria->load(['persona', 'materia'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al asignar monitor',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return PersonaMateria::with(['persona', 'materia'])
                            ->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $personaMateria = PersonaMateria::findOrFail($id);
            $personaMateria->update($request->all());

            return response()->json([
                'message' => 'Monitoria actualizada exitosamente',
                'data' => $personaMateria->load(['persona', 'materia'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar monitoria',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $personaMateria = PersonaMateria::findOrFail($id);
            $personaMateria->delete();

            return response()->json([
                'message' => 'Monitoria eliminada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar monitoria',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}