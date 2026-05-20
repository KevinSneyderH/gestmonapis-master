<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nombre' => 'Estudiante'],
            ['nombre' => 'Estudiante Monitor'],
            ['nombre' => 'Administrativo']
        ];

        foreach ($roles as $role) {
            Rol::create($role);
        }
    }
}