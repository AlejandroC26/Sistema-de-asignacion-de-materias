<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW vista_asignatura_estudiantes AS
                SELECT 
                    ae.id as id_ae,
                    ae.id_estudiante,
                    ue.nombres as nombre_estudiante,
                    ap.id_asignatura,
                    a.nombre as nombre_asignatura,
                    a.creditos,
                    ap.id_profesor,
                    up.nombres as nombre_profesor
                FROM `asignatura_estudiante`  ae
                JOIN estudiantes e 
                    ON e.id  = ae.id_estudiante
                JOIN asignatura_profesor ap 
                    ON ap.id = ae.id_asignatura_profesor
                JOIN asignaturas a 
                    ON a.id  = ap.id_asignatura
                JOIN profesores p 
                    ON p.id  = ap.id_profesor
                JOIN users ue 
                    ON ue.id = ae.id_estudiante
                JOIN users up
                    ON up.id = ap.id_profesor;
            SQL;
    }
   
    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS vista_asignatura_estudiantes;
        SQL;
    }
};
