<?php

namespace Database\Seeders;
use App\Models\Curso;



// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //Inyectar manualmente seeders:
        // $curso = new Curso;
        // $curso->name='laravel';
        // $curso->description='Mejor framework de PHP';
        // $curso->save();

        //inyectando por ModelSeeder.php
        // $this->call(CursoSeeder::class); // llama CursoSeeder al correr "php artisan migrate:fresh --seed"

        //Inyeccion directa desde aquí al model y del model al factory
        Curso::factory(50)->create();
    }
}
