<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\AsignaturaProfesor;
use App\Models\AsignaturaEstudiante;
use Illuminate\Support\Facades\Validator;

class EstudianteController extends Controller
{
    public function register(Request $request) 
    {
        $user = User::find($request->id_user);

        if(!$user)
            return response()->json(['status'=> 'error', 'message'=> 'User not found'], 400);

        $validator = Validator::make($request->all(), [
            'id_user'  => 'required',
            'semestre' => 'required'
        ]);

        if($validator->fails()) 
            return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
        if($request->semestre <= 0)
            return response()->json(['message' => 'semestre no válido'], 400);


        $estudiante = Estudiante::create($validator->validate());
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Estudiante registrado exitosamente',
            'data'    => $estudiante,
        ]);
    }

    public function assignCourse(Request $request)
    {
        $estudiante   = Estudiante::find($request->id_estudiante);

        if(!$estudiante)
            return response()->json(['status'=> 'error', 'message'=> 'Estudiante no encontrado'], 400);
 
        $asignatura_profesor = AsignaturaProfesor::find($request->id_asignatura_profesor);

        if(!$asignatura_profesor)
            return response()->json(['status'=> 'error', 'message'=> 'Asignatura de profesor no encontrada'], 400);

        $asignatura_estudiante = AsignaturaEstudiante::create([
            'id_estudiante'          => $request->id_estudiante,
            'id_asignatura_profesor' => $request->id_asignatura_profesor
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Asignatura de estudiante registrada exitosamente',
            'data'    => $asignatura_estudiante,
        ]);
    }
}
