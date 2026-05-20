<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use App\Models\UsuarioRol;
use App\Models\Rol;
use App\Models\Carrera;
use App\Models\PersonaCarrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function index()
    {
        return Persona::all();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Check if persona exists
            $existingPersona = Persona::where('numeroDocumento', $request->numeroDocumento)->first();
            if ($existingPersona) {
                return response()->json([
                    'error' => 'Ya existe una persona registrada con este número de documento'
                ], 409);
            }

            // Validate role
            $rol = Rol::find($request->rol_id);
            if (!$rol) {
                return response()->json([
                    'error' => 'El rol especificado no existe'
                ], 404);
            }

            // Validate carrera if provided
            $carrera = null;
            if ($request->has('carrera_id')) {
                $carrera = Carrera::find($request->carrera_id);
                if (!$carrera) {
                    return response()->json([
                        'error' => 'La carrera especificada no existe'
                    ], 404);
                }
            }

            // Create persona
            $persona = Persona::create($request->all());

            // Create user account
            $usuario = Usuario::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'persona_idpersona' => $persona->idpersona
            ]);

            // Assign role
            UsuarioRol::create([
                'rol_idrol' => $request->rol_id,
                'usuario_idusuario' => $usuario->idusuario
            ]);

            // Assign carrera if provided
            if ($carrera) {
                PersonaCarrera::create([
                    'persona_idpersona' => $persona->idpersona,
                    'carrera_idcarrera' => $request->carrera_id
                ]);
            }

            DB::commit();

            $response = [
                'message' => 'Persona y usuario creados exitosamente',
                'persona' => $persona,
                'usuario' => [
                    'username' => $usuario->username,
                    'rol' => $rol->nombre
                ]
            ];

            if ($carrera) {
                $response['carrera'] = $carrera->nombre;
            }

            return response()->json($response, 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al crear la persona y usuario',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return Persona::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->update($request->all());
        return response()->json($persona, 200);
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();
        return response()->json(null, 204);
    }
}