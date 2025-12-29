<?php

namespace App\Imports;

use App\Models\EventGuestModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class EventGuestImport implements ToCollection, WithHeadingRow
{
    protected $folder_id;
    protected $client_id;

    public function __construct($folder_id, $client_id)
    {
        $this->folder_id = $folder_id;
        $this->client_id = $client_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $name   = trim($row['name'] ?? '');
                $number = trim($row['number'] ?? '');

                if (!$name || !$number) {
                    Log::info("Row ".($index+2)." dilewati: nama / nomor kosong");
                    continue;
                }

                if (!str_starts_with($number, '62')) {
                    $number = '62' . $number;
                }

                EventGuestModel::create([
                    'folder_id' => $this->folder_id,
                    'client_id' => $this->client_id,
                    'name'      => $name,
                    'number'    => $number,
                ]);

                Log::info("Row ".($index+2)." sukses: $name - $number");

            } catch (\Exception $e) {
                Log::error("Row ".($index+2)." gagal: ".$e->getMessage());
            }
        }
    }
}
