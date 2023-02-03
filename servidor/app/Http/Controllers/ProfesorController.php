<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Asignatura;
use App\Models\AsignaturaProfesor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $profesores = Profesor::select(
            'profesores.id',
            'users.id as id_user', 
            'users.documento', 
            'users.nombres', 
            'users.telefono',
            'users.email',
            'users.direccion',
            'users.ciudad',
        )
            ->join('users', 'users.id', '=', 'profesores.id_user')
            ->paginate();
        return response()->json($profesores, 200);
    }

    public function register(Request $request) 
    {
        $user = User::find($request->id_user);

        if(!$user)
            return response()->json(['status'=> 'error', 'message'=> 'User not found'], 400);

        $validator = Validator::make($request->all(), [
            'id_user'  => 'required',
        ]);

        if($validator->fails()) 
            return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
        $profesor = Profesor::create($validator->validate());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Profesor registrado exitosamente',
            'data' => $profesor,
        ]);
    }

    public function assignCourse(Request $request)
    {
        $profesor   = Profesor::find($request->id_profesor);

        if(!$profesor)
            return response()->json(['status'=> 'error', 'message'=> 'Profesor no encontrado'], 400);
 
        $asignatura = Asignatura::find($request->id_asignatura);

        if(!$asignatura)
            return response()->json(['status'=> 'error', 'message'=> 'Asignatura no encontrada'], 400);

        $encuenta_asignatura_profesor = 
            AsignaturaProfesor::where('id_profesor', $request->id_profesor)
            ->where('id_asignatura', $request->id_asignatura)
            ->count();
        
        if($encuenta_asignatura_profesor) 
            return response()->json(['status'=> 'error', 'message'=> 'Este profesor ya tiene asignada esta asignatura'], 400);

        $asignatura_profesor = AsignaturaProfesor::create([
            'id_profesor'   => $request->id_profesor,
            'id_asignatura' => $request->id_asignatura
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asignatura de profesor registrada exitosamente',
            'data' => $asignatura_profesor,
        ]);
    }

    public function listCourses(Request $request, $id){
        $asignaturas = DB::table('vista_asignatura_profesor')
            ->where('id_profesor', $id)
            ->get();
        return response()->json($asignaturas);
    }
}
