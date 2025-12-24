<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleGroupPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = [
            [
                'role_group_id' => 1,
                'role_permission_id' => 1,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 2,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 3,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 4,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 5,
            ],
            [
                'role_group_id' => 2,
                'role_permission_id' => 6,
            ],
            [
                'role_group_id' => 2,
                'role_permission_id' => 7,
            ],
            [
                'role_group_id' => 2,
                'role_permission_id' => 8,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 9,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 10,
            ],
            [
                'role_group_id' => 2,
                'role_permission_id' => 11,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 12,
            ],
            [
                'role_group_id' => 2,
                'role_permission_id' => 13,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 14,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 15,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 15,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 16,
            ],
            [
                'role_group_id' => 1,
                'role_permission_id' => 17,
            ],
        ];

        DB::table('role_group_permission')->insert($post);
    }
}
