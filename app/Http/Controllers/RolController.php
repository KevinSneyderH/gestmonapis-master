<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        return Rol::all();
    }

    public function store(Request $request)
    {
        try {
            // Check if rol already exists with the same name
            $existingRol = Rol::where('nombre', $request->nombre)->first();
            
            if ($existingRol) {
                return response()->json([
                    'error' => 'Ya existe un rol con este nombre'
                ], 409);
            }

            $rol = Rol::create($request->all());
            return response()->json($rol, 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el rol',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return Rol::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->update($request->all());
        return response()->json($rol, 200);
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();
        return response()->json(null, 204);
    }
}