<?php

namespace Database\Seeders;



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

        $this->call(CursoSeeder::class); // se corre "php artisan migrate:fresh --seed"
    }
}
