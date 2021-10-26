<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrador']);
        $role = Role::create(['name' => 'especialista']);
        $role = Role::create(['name' => 'funcionario']);
    }
}
