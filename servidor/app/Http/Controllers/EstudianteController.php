<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\AsignaturaProfesor;
use App\Models\AsignaturaEstudiante;


class EstudianteController extends Controller
{
    public function index(Request $request)
    {
        $estudiantes = Estudiante::select(
            'estudiantes.id',
            'users.id as id_user', 
            'users.documento', 
            'users.nombres', 
            'users.telefono',
            'users.email',
            'users.direccion',
            'users.ciudad',
            'estudiantes.semestre',
        )
            ->join('users', 'users.id', '=', 'estudiantes.id_user')
            ->paginate();

        return response()->json($estudiantes, 200);
    }


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

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);

        if(!$estudiante)
            return response()->json(['status'=> 'error', 'message'=> 'Estudiante no encontrado'], 400);
        
        $estudiante->semestre = $request->semestre;
        $estudiante->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Estudiante actualizado exitosamente'
        ]);
    }

    public function assignCourse(Request $request)
    {
        $estudiante   = Estudiante::find($request->id_estudiante);

        if(!$estudiante)
            return response()->json(['status'=> 'error', 'message'=> 'Estudiante no encontrado'], 400);
 
        $creditos = 0;
        $asignaturas = [];

        $arreglo = $request->asignaturas;
        if(is_string($arreglo)) $arreglo = json_decode($request->asignaturas);

        foreach ($arreglo as $asignatura) {

            $asignatura_profesor = DB::table('vista_asignatura_profesor')
                ->where('id_ap', $asignatura)->first();
            
            if($asignatura_profesor) {
                $creditos += $asignatura_profesor->creditos;
                array_push($asignaturas, $asignatura_profesor);
            }
        }

        
        if($creditos < 7) 
            return response()->json([
                'status'=> 'error', 
                'message'=> 'No se cumplen los créditos mínimos para el registro'
            ], 400);

        $repetidos = [];

        DB::beginTransaction();

        foreach ($asignaturas as $asignatura) {

            $asignatura_estudiante = DB::table('vista_asignatura_estudiantes')
                ->where('id_asignatura', $asignatura->id_asignatura)
                ->first();

            if($asignatura_estudiante) array_push($repetidos, $asignatura_estudiante);

            AsignaturaEstudiante::create([
                'id_estudiante'          => $request->id_estudiante,
                'id_asignatura_profesor' => $asignatura->id_ap,
            ]);
        }

        if(count($repetidos) > 0) {
            DB::rollback();
            return response()->json([
                'status'=> 'error', 
                'message'=> 'Se están registrando asignaturas repetidas',
                "data"=>$repetidos
            ], 400);
        } else {
            DB::commit();
        }
        
        return response()->json([
            'status'  => 'success',
            'message' => 'Asignaturas de estudiante registradas exitosamente',
            'data'    => $asignaturas,
        ]);
    }

    public function listCourses(Request $request, $id){
        $asignaturas = DB::table('vista_asignatura_estudiantes')
            ->where('id_estudiante', $id)
            ->get();
        return response()->json($asignaturas);
    }
}
