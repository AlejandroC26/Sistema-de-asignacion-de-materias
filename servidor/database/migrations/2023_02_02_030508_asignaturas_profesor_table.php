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
        Schema::create('asignatura_profesor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_profesor')
                    ->constrained('profesores')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->foreignId('id_asignatura')
                    ->constrained('asignaturas')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesor');
    }
};
