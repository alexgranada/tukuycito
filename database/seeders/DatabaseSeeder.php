<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nombres' => 'Admin',
            'apellidos' => 'Principal',
            'dni' => '12345678',
            'telefono' => '987654321',
            'correo' => 'admin@example.com',
            'clave' => bcrypt('123456'),
            'tipo' => 'admin',
            'almacen_id' => 1,
        ]);

    }
}
