<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Estudiante;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([ 
            'documento'=> '312',
            'nombres' => 'Admin',
            'telefono' => '315',
            'direccion' => 'Cra1a',
            'ciudad' => 'Pitalito',
            'email' => 'admin@gmail.com',
            'tipo' => 'admin',
            'password' => Hash::make('123'),
        ]);

        User::create([ 
            'documento'=> '1116912149',
            'nombres' => 'Alexander Guzmán',
            'telefono' => '3134039711',
            'direccion' => 'Cra 17 # 1 - 27',
            'ciudad' => 'Pitalito',
            'email' => 'alex@gmail.com',
            'password' => Hash::make('regis'),
        ]);

        User::create([ 
            'documento'=> '1116912143',
            'nombres' => 'Miller Cubillos',
            'telefono' => '3107602311',
            'direccion' => 'Cra 17 # 1 - 27',
            'ciudad' => 'Pitalito',
            'email' => 'miller@gmail.com',
            'password' => Hash::make('123'),
        ]);

        User::create([ 
            'documento'=> '11169135148',
            'nombres' => 'Alejandro Cubillos',
            'telefono' => '3134029719',
            'direccion' => 'Cra 17 # 1 - 27',
            'ciudad' => 'Pitalito',
            'email' => 'cubillosa862@gmail.com',
            'password' => Hash::make('123'),
        ]);

        Profesor::create(['id_user' => 2]);
        Profesor::create(['id_user' => 3]);
        Estudiante::create(['id_user'=> 4, 'semestre' => 1]);
        
        
    }
}
