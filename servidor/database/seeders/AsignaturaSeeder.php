<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asignatura;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asignatura::create([ 
            'nombre'=> 'Física I',
            'descripcion' => 'Se da a conocer......',
            'creditos' => 3,
            'id_area' => 1,
        ]);

        Asignatura::create([ 
            'nombre'=> 'Cálculo I',
            'descripcion' => 'Se da a conocer......',
            'creditos' => 3,
            'id_area' => 1,
        ]);

        Asignatura::create([ 
            'nombre'=> 'Matemática Básica',
            'descripcion' => 'Se da a conocer......',
            'creditos' => 2,
            'id_area' => 1,
        ]);
    }
}
