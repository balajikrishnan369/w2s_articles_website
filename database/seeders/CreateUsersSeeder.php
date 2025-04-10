<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\DB;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->truncate(); 

        $users = [
            [
               'name'=>'Admin',
               'email'=>'admin@gmail.com',
               'role'=> RoleEnum::ADMIN,
               'password'=> bcrypt('admin123'),
            ],
            [
               'name'=>'Sub-Admin 1',
               'email'=>'subadmin1@gmail.com',
               'role'=> RoleEnum::SUBADMIN,
               'password'=> bcrypt('subadmin123'),
            ],
            [
               'name'=>'Sub-Admin 2',
               'email'=>'subadmin2@gmail.com',
               'role'=> RoleEnum::SUBADMIN,
               'password'=> bcrypt('subadmin123'),
            ],
            [
                'name'=>'Sub-Admin 3',
                'email'=>'subadmin3@gmail.com',
                'role'=> RoleEnum::SUBADMIN,
                'password'=> bcrypt('subadmin123'),
             ]
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
