<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\AreaConocimiento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AsignaturaController extends Controller
{
    public function index(Request $request)
    {
        $asignaturas = Asignatura::select(
            "asignaturas.id",
            "asignaturas.nombre",
            "asignaturas.descripcion",
            "asignaturas.creditos",
            "asignaturas.tipo",
            "asignaturas.id_area",
            "areas_conocimiento.nombre as area_nombre",
        )->join('areas_conocimiento', 'areas_conocimiento.id', '=', 'asignaturas.id_area')
        ->paginate();
       return response()->json($asignaturas, 200); 
    }

    public function listTeachers(Request $request, $id)
    {
        $asignaturas = DB::table('vista_asignatura_profesor')
            ->where('id_asignatura', $id)
            ->get();
        return response()->json($asignaturas);
    }


    public function showAreas(Request $request)
    {
        $areas = AreaConocimiento::all();
        return response()->json($areas, 200); 
    }

    public function listStudents(Request $request){
        $asignaturas = DB::table('vista_asignatura_estudiantes')->get();
        return response()->json($asignaturas);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required',
            'creditos' => 'required',
            'id_area' => 'required',
            'tipo' => Rule::in(['electiva', 'obligatoria']),
        ]);

        if($validator->fails()) return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
        $area = AreaConocimiento::find($request->id_area);

        if(!$area)
            return response()->json(['status'=> 'error', 'message'=> 'Area no encontrada'], 400);

        $asignatura = Asignatura::create($validator->validate());

        return response()->json([
            'status' => 'success',
            'message' => 'Asignatura registrada exitosamente',
            'data' => $asignatura
        ]);
    }

    public function update(Request $request, $id)
    {
        $asignatura = Asignatura::find($id);

        if(!$asignatura)
            return response()->json(['status'=> 'error', 'message'=> 'Asignatura no encontrada'], 400);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required',
            'creditos' => 'required',
            'id_area' => 'required',
            'tipo' => Rule::in(['electiva', 'obligatoria']),
        ]);

        if($validator->fails()) return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);

        $asignatura->nombre = $request->nombre;
        $asignatura->descripcion = $request->descripcion;
        $asignatura->creditos = $request->creditos;
        $asignatura->id_area = $request->id_area;
        $asignatura->tipo = $request->tipo;

        $asignatura->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Asignatura actualizada exitosamente',
            'data' => $asignatura
        ]);
    }
}
