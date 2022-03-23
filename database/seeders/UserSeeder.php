<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles
        $roleAdmin = new Role();
        $roleAdmin->name = 'admin';
        $roleAdmin->display_name = 'administrator';
        $roleAdmin->save();

        //Users
        $userAdmin = new User();
        $userAdmin->name = 'admin';
        $userAdmin->email = 'admin@gmail.com';
        $userAdmin->password = Hash::make('12345678');
        $userAdmin->is_admin = 1;
        $userAdmin->save();

        //asign roles
        $userAdmin->roles()->attach($roleAdmin->id);

        ######## guess ########
        //Roles
        $roleGuess = new Role();
        $roleGuess->name = 'guess';
        $roleGuess->display_name = 'Guess';
        $roleGuess->save();

        //Users
        $userGuess = new User();
        $userGuess->name = 'orici';
        $userGuess->email = 'oriana@gmail.com';
        $userGuess->password = Hash::make('12345678');
        $userGuess->is_admin = 0;
        $userGuess->save();

        //asign roles
        $userGuess->roles()->attach($roleGuess->id);
    }
}
