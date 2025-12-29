<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            // 1
            ['name' => 'admin'],
            // 2
            ['name' => 'client'],
            // 3
            ['name' => 'free'],
            // 4
            ['name' => 'basic'],
            // 5
            ['name' => 'pro'],
            // 6
            ['name' => 'premium'],
        ];

        DB::table('role_group')->insert($posts);
    }
}
