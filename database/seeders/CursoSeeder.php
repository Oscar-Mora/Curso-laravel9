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
        //inyectando por "php artisan make:seeder ...Curso", en DatabaseSeeders.php llamo a ésta clase
        $curso = new Curso;
        $curso->name='laravel';
        $curso->description='Mejor framework de PHP';
        $curso->save();
        
    }
}
