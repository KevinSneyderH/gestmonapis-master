<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::with('persona')->get();
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

            // Check if username already exists
            if (Usuario::where('username', $request->username)->exists()) {
                return response()->json([
                    'error' => 'El nombre de usuario ya está en uso'
                ], 409);
            }

            $usuario = new Usuario($request->all());
            $usuario->password = Hash::make($request->password);
            $usuario->save();

            return response()->json($usuario, 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el usuario',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return Usuario::with('persona')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            if ($request->has('persona_idpersona') && !Persona::find($request->persona_idpersona)) {
                return response()->json([
                    'error' => 'La persona especificada no existe'
                ], 404);
            }

            if ($request->has('username') && 
                Usuario::where('username', $request->username)
                      ->where('idusuario', '!=', $id)
                      ->exists()) {
                return response()->json([
                    'error' => 'El nombre de usuario ya está en uso'
                ], 409);
            }

            if ($request->has('password')) {
                $request->merge([
                    'password' => Hash::make($request->password)
                ]);
            }

            $usuario->update($request->all());
            return response()->json($usuario, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el usuario',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(null, 204);
    }
}