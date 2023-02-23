<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function resumenPDF()
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
        )->join('users', 'users.id', '=', 'estudiantes.id_user')
        ->get();

        $asignaturas = Asignatura::select(
            "asignaturas.id",
            "asignaturas.nombre",
            "asignaturas.descripcion",
            "asignaturas.creditos",
            "asignaturas.tipo",
            "asignaturas.id_area",
            "areas_conocimiento.nombre as area_nombre",
        )->join('areas_conocimiento', 'areas_conocimiento.id', '=', 'asignaturas.id_area')
        ->get();

        $asignaturas_estudiantes = DB::table('vista_asignatura_estudiantes')->get();

        $head = '<head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Document</title><style>.styled-table {width: 100%;border-collapse: collapse;margin: 1rem 0;font-size: 0.9em;font-family: sans-serif;min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);}.styled-table thead tr {background-color: #0275d8;color: #ffffff;text-align: left;}.styled-table th,.styled-table td {padding: 12px 15px;}.styled-table tbody tr:nth-of-type(2n) {background-color: #f3f3f3;}.styled-table tbody tr {border-bottom: 1px solid #dddddd;}.page-break {page-break-after: always;} .title-text {color: #00539b;font-size: 1.8em;font-family: sans-serif;}</style></head>';
        
        $rows_estudiantes = '';
        $rows_asignaturas  = '';
        $rows_asignaturas_estudiante = '';

        foreach ($estudiantes as $estudiante) {
            $rows_estudiantes = $rows_estudiantes. "<tr>
                <td>$estudiante->documento</td>
                <td>$estudiante->nombre</td>
                <td>$estudiante->telefono</td>
                <td>$estudiante->ciudad</td>
                <td>$estudiante->semestre</td>
            </tr>";
        }

        foreach ($asignaturas as $asignatura) {
            $rows_asignaturas = $rows_asignaturas. "<tr>
                <td>$asignatura->nombre</td>
                <td>$asignatura->descripcion</td>
                <td>$asignatura->creditos</td>
                <td>$asignatura->area_nombre</td>
                <td>$asignatura->tipo</td>
            </tr>";
        }


        foreach ($asignaturas_estudiantes as $asignatura_estudiante) {
            $rows_asignaturas_estudiante = $rows_asignaturas_estudiante. "<tr>
                <td>$asignatura_estudiante->nombre_asignatura</td>
                <td>$asignatura_estudiante->nombre_estudiante</td>
                <td>$asignatura_estudiante->nombre_profesor</td>
            </tr>";
        }

        $table_estudiantes = '<table class="styled-table"><thead><tr><td colspan="5"><center>Estudiantes</center></td></tr><tr><td>Documento</td><td>Nombres</td><td>Teléfono</td><td>Ciudad</td><td>Semestre</td></tr></thead><tbody>'.$rows_estudiantes.'</tbody></table>';
        $table_asignaturas = '<table class="styled-table"><thead><tr><td colspan="5"><center>Asignaturas</center></td></tr><tr><td>Nombre</td><td>Descripción</td><td>Créditos</td><td>Area</td><td>Tipo</td></tr></thead><tbody>'.$rows_asignaturas.'</tbody></table>';
        $table_asignaturas_estudiante = '<table class="styled-table"><thead><tr><td colspan="3"><center>Asignaturas por estudiantes</center></td></tr><tr><td>Asignatura</td><td>Estudiante</td><td>Profesor</td></tr></thead><tbody>'.$rows_asignaturas_estudiante.'</tbody></table>';


        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML("
        <!DOCTYPE html>
            <html lang='en'>
            $head
            <body>
                <h1 class='title-text'>SISTEMA DE ASIGNACIÓN DE MATERIAS</h1>
                $table_asignaturas              <div class='page-break'></div>
                $table_asignaturas_estudiante   <div class='page-break'></div>
                $table_estudiantes
            </body>
        </html>
        ");

        return $pdf->download('mi-archivo.pdf');
    }
}
