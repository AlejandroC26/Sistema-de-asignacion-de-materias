<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Profesor;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function me(Request $request)
    {
        $user = Auth::user();

        $profesor = Profesor::where('id_user', $user->id)->first();
        $estudiante = Estudiante::where('id_user', $user->id)->first();

        $permiso_admin      = false;
        $permiso_profesor   = false;
        $permiso_estudiante = false;

        if($user->tipo == 'admin') $permiso_admin      = true; 
        if($profesor)              $permiso_profesor   = $profesor->id;
        if($estudiante)            $permiso_estudiante = $estudiante->id;

        

        return response()->json([
            "data"=>$user,
            'permisos'=> [
                "admin"=>$permiso_admin,
                "profesor"=>$permiso_profesor,
                "estudiante"=>$permiso_estudiante,
            ],
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if($validator->fails()) 
            return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);

        $credentials = $request->only('email', 'password');


        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 400);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}