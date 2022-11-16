<?php

namespace Database\Seeders;
use App\Models\Curso;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Inyeccion manual desde el seeder personalizado
        // $curso = new Curso();
        // $curso ->name='Laravel';
        // $curso ->description='El mejor framework de PHP';
        // $curso ->category='Desarrollor web';
        // $curso->save();
        
        //Si estuvieramos trabajando desde aquí la inyeccion de data a las tablas, DatabaseSeeder llama a CursoSeeder
        // Curso::factory(50)->create();
    }
}
