<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AreaConocimiento;

class AreaConocimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AreaConocimiento::create([ 'nombre'=> 'Area 1' ]);
        AreaConocimiento::create([ 'nombre'=> 'Area 2' ]);
        AreaConocimiento::create([ 'nombre'=> 'Area 3' ]);
        
    }
}
