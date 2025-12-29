<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FolderPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // Hemat
            [
                'plan' => 'beginner',
                'package_name' => 'Beginner',
                'package_desc' => 'Paket Hemat dirancang untuk pengguna pemula yang ingin mengelola satu event dengan fitur esensial dan biaya terjangkau.',
                'feature' => json_encode([
                    'Buat event / folder tanpa batas',
                    'Upload foto & video HD',
                    'Download video HD',
                    'Chat bot kirim pesan otomatis (template default)',
                    'Template Scan QR standar',
                ]),
                'price' => 55000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 6,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Basic
            [
                'plan' => 'basic',
                'package_name' => 'Basic',
                'package_desc' => 'Paket Basic dengan fitur standar untuk penggunaan personal.',
                'feature' => json_encode([
                    'Storage 12GB',
                    'Buat event & folder tanpa batas',
                    'Upload foto & video HD',
                    'Download video HD',
                    'Chat bot kirim pesan otomatis (template default)',
                    'Template Scan QR standar',
                ]),
                'price' => 99000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 12,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pro
            [
                'plan' => 'pro',
                'package_name' => 'Pro',
                'package_desc' => 'Paket Pro cocok untuk fotografer aktif dan event organizer.',
                'feature' => json_encode([
                    'Storage 20GB',
                    'Menyesuaikan lagu digallery wall',
                    'Buat event & folder tanpa batas',
                    'Upload foto & video resolusi asli',
                    'Download video HD',
                    'Chat bot kirim & custom pesan',
                    'Template Scan QR premium',
                    'Import nomor tamu event dari Excel',
                    'Bandwidth download lebih cepat',
                ]),
                'price' => 199000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 20,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Premium
            [
                'plan' => 'premium',
                'package_name' => 'Premium',
                'package_desc' => 'Paket Premium untuk wedding organizer dan studio profesional.',
                'feature' => json_encode([
                    'Storage 30GB',
                    'Buat event & folder tanpa batas',
                    'Upload foto & video resolusi asli',
                    'Download video resolusi asli',
                    'Import nomor tamu event dari Excel',
                    'Download prioritas',
                    'Support prioritas',
                ]),
                'price' => 499000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 30,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('package')->insert($packages);
    }
}
