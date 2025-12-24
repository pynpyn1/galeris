<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts =[
            // Akun Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone' => '628975363100',
                'password' => Hash::make('admin'),
                'role_group_id' => 1,

            ],
            [
                'name' => 'Admin',
                'email' => 'dirajadanu@gmail.com',
                'phone' => '6289524863306',
                'password' => Hash::make('1'),
                'role_group_id' => 1,

            ],
            // Akun Dana
            [
                'name' => 'Client',
                'email' => 'client@gmail.com',
                'phone' => '628975363100',
                'password' => Hash::make('client'),
                'role_group_id' => 2,

            ],
            // Akun Danu
            [
                'name' => 'Client2',
                'email' => 'client2@gmail.com',
                'phone' => '6289524863306',
                'password' => Hash::make('client2'),
                'role_group_id' => 2,

            ],
        ];
        User::insert($posts);
    }
}
