<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FolderPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // Basi Plan
            [
                'plan' => 'basic',
                'package_name' => 'Basic Monthly',
                'package_desc' => 'Langganan bulanan dengan total penyimpanan 25GB. Bebas membuat banyak event sekaligus.',
                'feature' => json_encode([
                    'Total storage 25GB',
                    'Event tanpa batas',
                    'Foto & video resolusi asli',
                    'Tamu dapat melihat dan mengunduh',
                    'Layanan Whatsapp bot customisasi',
                    'Akses selama langganan aktif',
                ]),
                'price' => 99000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 25,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pro Plan
            [
                'plan' => 'pro',
                'package_name' => 'Pro Monthly',
                'package_desc' => 'Cocok untuk fotografer aktif dengan kebutuhan penyimpanan besar.',
                'feature' => json_encode([
                    'Total storage 100GB',
                    'Event tanpa batas',
                    'Upload foto & video resolusi asli',
                    'Tanpa watermark',
                    'Layanan Whatsapp bot customisasi',
                    'Performa upload lebih cepat',
                ]),
                'price' => 199000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 100,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Premium Plan
            [
                'plan' => 'premium',
                'package_name' => 'Premium Monthly',
                'package_desc' => 'Untuk wedding organizer dan studio profesional.',
                'feature' => json_encode([
                    'Storage besar hingga 500GB',
                    'Event tanpa batas',
                    'Ideal untuk WO & studio',
                    'Layanan Whatsapp bot customisasi',
                    'Kecepatan upload tinggi',
                    'Support prioritas',
                ]),
                'price' => 499000,
                'billing_cycle' => 'monthly',
                'storage_limit_gb' => 500,
                'is_unlimited' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('package')->insert($packages);
    }
}
