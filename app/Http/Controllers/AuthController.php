<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            // Load usuario with persona, roles, and persona's carreras
            $usuario = Usuario::with(['persona', 'roles.rol', 'persona.carreras.carrera'])
                ->where('username', $request->username)
                ->first();

            if (!$usuario || !Hash::check($request->password, $usuario->password)) {
                return response()->json([
                    'error' => 'Credenciales incorrectas'
                ], 401);
            }

            $token = $usuario->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $usuario->idusuario,
                    'username' => $usuario->username,
                    'persona' => [
                        'nombres' => $usuario->persona->nombres,
                        'apellidos' => $usuario->persona->apellidos,
                        'email' => $usuario->persona->email
                    ],
                    'roles' => $usuario->roles->map(function($userRole) {
                        return [
                            'id' => $userRole->rol->idrol,
                            'nombre' => $userRole->rol->nombre
                        ];
                    }),
                    'carreras' => $usuario->persona->carreras->map(function($personaCarrera) {
                        return [
                            'id' => $personaCarrera->carrera->idcarrera,
                            'nombre' => $personaCarrera->carrera->nombre
                        ];
                    })
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error en el inicio de sesión',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!$request->user()) {
                return response()->json([
                    'error' => 'No hay sesión activa'
                ], 401);
            }

            // Check if user has any active tokens
            if ($request->user()->tokens()->count() === 0) {
                return response()->json([
                    'error' => 'No se encontraron tokens activos'
                ], 400);
            }

            // Revoke all tokens for the current user
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Sesión cerrada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al cerrar sesión',
                'details' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }
    }
}