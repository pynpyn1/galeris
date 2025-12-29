<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            // Admin Permissions
            [
                'name' => 'Manage Users',
                'slug' => 'manage_users',
            ],
            [
                'name' => 'Manage Folder',
                'slug' => 'manage_folder',
            ],
            [
                'name' => 'Manage Photo',
                'slug' => 'manage_photo',
            ],
            [
                'name' => 'Manage URL',
                'slug' => 'manage_url',
            ],
            [
                'name' => 'Manage Invoice',
                'slug' => 'manage_invoice',
            ],

            // Client Permissions
            [
                'name' => 'Create Folder',
                'slug' => 'create_folder',
            ],
            [
                'name' => 'Upload Photo',
                'slug' => 'upload_photo',
            ],
            [
                'name' => 'Manage QR Code',
                'slug' => 'manage_qr_code',
            ],


            // Role Management Permissions
            [
                'name' => 'Manage Roles',
                'slug' => 'manage_roles',
            ],

            // ChatBOT
            // Admin
            [
                'name' => 'Manage Chat Bot',
                'slug' => 'manage_chatbot',
            ],
            // Client
            [
                'name' => 'Setting Chat Bot',
                'slug' => 'setting_chatbot',
            ],

            [
                'name' => 'Dashboard',
                'slug' => 'dashboard'
            ],
            [
                'name' => 'Dashboard Client',
                'slug' => 'dashboard_client'
            ],
            // Admin
            [
                'name' => 'Manage Video',
                'slug' => 'manage_video'
            ],
            [
                'name' => 'Manage Discount',
                'slug' => 'manage_discount'
            ],
            [
                'name' => 'Manage Package',
                'slug' => 'manage_package'
            ],
            [
                'name' => 'Manage QR Template',
                'slug' => 'manage_qrtemplate'
            ],

            // Client
            [
                'name' => 'Download uploads',
                'slug' => 'download_uploads'
            ],
            [
                'name' => 'Qr Code Template',
                'slug' => 'qrcode_template'
            ],
            [
                'name' => 'Live Gallery Wall',
                'slug' => 'gallery_wall'
            ],
            [
                'name' => 'Upload HD Resolution',
                'slug' => 'upload_hd_resolution'
            ],
            [
                'name' => 'Upload Original Resolution',
                'slug' => 'upload_original_resolution'
            ],
            [
                'name' => 'Edit Qr Code',
                'slug' => 'edit_qr_code'
            ],

            // Client
            [
                'name' => 'Upload Video',
                'slug' => 'upload_video'
            ],

        ];

        DB::table('role_permission')->insert($posts);
    }
}
