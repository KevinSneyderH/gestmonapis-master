<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    // Obtener todas las Materias
    public function index()
    {
        return response()->json(Materia::all(), 200);
    }

    // Crear una nueva Materia
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $Materia = Materia::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json($Materia, 201);
    }

    // Obtener una Materia por ID
    public function show($id)
    {
        $Materia = Materia::find($id);

        if (!$Materia) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }

        return response()->json($Materia, 200);
    }

    // Actualizar una Materia
    public function update(Request $request, $id)
    {
        $Materia = Materia::find($id);

        if (!$Materia) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $Materia->update(['nombre' => $request->nombre]);

        return response()->json($Materia, 200);
    }

    // Eliminar una Materia
    public function destroy($id)
    {
        $Materia = Materia::find($id);

        if (!$Materia) {
            return response()->json(['message' => 'Materia no encontrada'], 404);
        }

        $Materia->delete();

        return response()->json(['message' => 'Materia eliminada'], 200);
    }
}
