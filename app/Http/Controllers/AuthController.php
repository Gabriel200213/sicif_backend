<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'ap_paterno' => 'required|string|max:50',
            'ap_materno' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuario,correo|max:100',
            'contraseña' => 'required|string|min:6',
            'id_rol' => 'required|exists:rol,id_rol',
            'id_estado' => 'required|exists:estado,id_estado',
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'correo' => $request->correo,
            'contraseña_hash' => Hash::make($request->contraseña),
            'id_rol' => $request->id_rol,
            'id_estado' => $request->id_estado,
        ]);

        $token = JWTAuth::fromUser($usuario);

        return response()->json([
            'user' => $usuario,
            'access_token' => $token,
            'token_type' => 'bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $credentials = $request->only('correo', 'contraseña');

        $user = Usuario::where('correo', $credentials['correo'])->first();

        if (!$user || !Hash::check($credentials['contraseña'], $user->contraseña_hash)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        try {
            $token = JWTAuth::fromUser($user);
            $refreshToken = JWTAuth::fromUser($user, ['exp' => now()->addDays(30)->timestamp]);

            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'refresh_token' => $refreshToken,
                'token_type' => 'bearer',
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
    }

    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::refresh($request->bearerToken());

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo refrescar el token'], 401);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar la sesión'], 500);
        }
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['user' => $user]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        }
    }
}