<?php

namespace Database\Seeders;

use App\Models\ChatBotModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatBotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('chatbot')->insert([
            [
                'user_id' => 1,
                'message' => 'Halo {name}, QR kamu sudah dibuat! Scan link berikut: {url}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'message' => 'Halo {name}, QR kamu sudah dibuat! Scan link berikut: {url}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'message' => 'Halo {name}, QR kamu sudah dibuat! Scan link berikut: {url}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}
