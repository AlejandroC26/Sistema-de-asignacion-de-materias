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
            CREATE VIEW vista_asignatura_profesor AS
                SELECT 
            		ap.id as id_ap,
                    ap.id_asignatura,
                    a.nombre as nombre_asignatura,
                    a.creditos,
                    ap.id_profesor,
                    up.nombres as nombre_profesor,
                    ap.estado as estado
                FROM asignatura_profesor  ap

                JOIN asignaturas a 
                    ON a.id  = ap.id_asignatura
                JOIN profesores p 
                    ON p.id  = ap.id_profesor
                JOIN users up
                    ON up.id = p.id_user;
            SQL;
    }
   
    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS vista_asignatura_profesor;
        SQL;
    }
};
