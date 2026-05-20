<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;

class CarreraController extends Controller
{
    // Obtener todas las carreras
    public function index()
    {
        return response()->json(Carrera::all(), 200);
    }

    // Crear una nueva carrera
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $carrera = Carrera::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json($carrera, 201);
    }

    // Obtener una carrera por ID
    public function show($id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json(['message' => 'Carrera no encontrada'], 404);
        }

        return response()->json($carrera, 200);
    }

    // Actualizar una carrera
    public function update(Request $request, $id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json(['message' => 'Carrera no encontrada'], 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $carrera->update(['nombre' => $request->nombre]);

        return response()->json($carrera, 200);
    }

    // Eliminar una carrera
    public function destroy($id)
    {
        $carrera = Carrera::find($id);

        if (!$carrera) {
            return response()->json(['message' => 'Carrera no encontrada'], 404);
        }

        $carrera->delete();

        return response()->json(['message' => 'Carrera eliminada'], 200);
    }
}
