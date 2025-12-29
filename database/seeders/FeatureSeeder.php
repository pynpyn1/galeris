<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'key' => 'unlimited_event_folder',
                'name' => 'Event & Folder Tanpa Batas',
            ],
            [
                'key' => 'upload_hd',
                'name' => 'Upload Foto & Video HD',
            ],
            [
                'key' => 'upload_original_resolution',
                'name' => 'Upload Resolusi Asli',
            ],
            [
                'key' => 'download_hd',
                'name' => 'Download Video HD',
            ],
            [
                'key' => 'download_original_resolution',
                'name' => 'Download Resolusi Asli',
            ],
            [
                'key' => 'chatbot_default_message',
                'name' => 'Chatbot Pesan Otomatis (Default)',
            ],
            [
                'key' => 'chatbot_custom_message',
                'name' => 'Chatbot Custom Message',
            ],
            [
                'key' => 'qr_template_standard',
                'name' => 'Template Scan QR Standar',
            ],
            [
                'key' => 'qr_template_premium',
                'name' => 'Template Scan QR Premium',
            ],
            [
                'key' => 'gallery_music_custom',
                'name' => 'Custom Lagu Gallery Wall',
            ],
            [
                'key' => 'import_guest_excel',
                'name' => 'Import Nomor Tamu dari Excel',
            ],
            [
                'key' => 'priority_download',
                'name' => 'Download Prioritas',
            ],
            [
                'key' => 'priority_support',
                'name' => 'Support Prioritas',
            ],
            [
                'key' => 'fast_download_bandwidth',
                'name' => 'Bandwidth Download Lebih Cepat',
            ],
        ];

        DB::table('features')->insert($features);

    }
}
