<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "admin";
        $user->email = "admin@conapes.com";
        $user->password = bcrypt("987412365");
        $user->save();

        $user->assignRole('administrador');

        $user = new User();
        $user->name = "funcionario";
        $user->email = "funcionario@conapes.com";
        $user->password = bcrypt("987412365");
        $user->save();

        $user->assignRole('funcionario');

        $user = new User();
        $user->name = "especialista";
        $user->email = "especialista@conapes.com";
        $user->password = bcrypt("987412365");
        $user->save();

        $user->assignRole('especialista');
    }
}
