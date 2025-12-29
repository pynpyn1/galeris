<?php

namespace Database\Seeders;

use App\Models\FeaturesModel;
use App\Models\PackageModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = FeaturesModel::pluck('id', 'key');

        $packages = PackageModel::pluck('id', 'plan');

        // BEGINNER
        PackageModel::find($packages['beginner'])->features()->sync([
            $features['unlimited_event_folder'] => ['is_enabled' => true],
            $features['upload_hd'] => true,
            $features['download_hd'] => true,
            $features['chatbot_default_message'] => true,
            $features['qr_template_standard'] => true,
        ]);

        // BASIC
        PackageModel::find($packages['basic'])->features()->sync([
            $features['unlimited_event_folder'] => true,
            $features['upload_hd'] => true,
            $features['download_hd'] => true,
            $features['chatbot_default_message'] => true,
            $features['qr_template_standard'] => true,
        ]);

        // PRO
        PackageModel::find($packages['pro'])->features()->sync([
            $features['unlimited_event_folder'] => true,
            $features['upload_hd'] => true,
            $features['upload_original_resolution'] => true,
            $features['download_hd'] => true,
            $features['chatbot_default_message'] => true,
            $features['chatbot_custom_message'] => true,
            $features['qr_template_premium'] => true,
            $features['gallery_music_custom'] => true,
            $features['fast_download_bandwidth'] => true,
        ]);

        // PREMIUM
        PackageModel::find($packages['premium'])->features()->sync([
            $features['unlimited_event_folder'] => true,
            $features['upload_hd'] => true,
            $features['upload_original_resolution'] => true,
            $features['download_original_resolution'] => true,
            $features['import_guest_excel'] => true,
            $features['priority_download'] => true,
            $features['priority_support'] => true,
        ]);
    }
}
