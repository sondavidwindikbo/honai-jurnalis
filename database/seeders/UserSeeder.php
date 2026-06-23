<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
     public function run(): void
    {
        User::create([
            'name'     => 'Admin Honai',
            'email'    => 'admin@honai.test',
            'password' => bcrypt('password'),
            'role'     => 'admin',
            'is_active'=> true,
        ]);

        User::create([
            'name'     => 'Editor Honai',
            'email'    => 'editor@honai.test',
            'password' => bcrypt('password'),
            'role'     => 'editor',
            'is_active'=> true,
        ]);

        User::create([
            'name'     => 'Penulis Honai',
            'email'    => 'penulis@honai.test',
            'password' => bcrypt('password'),
            'role'     => 'penulis',
            'is_active'=> true,
        ]);
    }
}
