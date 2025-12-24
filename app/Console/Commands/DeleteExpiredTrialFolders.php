<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FolderModel;
use Carbon\Carbon;

class DeleteExpiredTrialFolders extends Command
{
    protected $signature = 'folder:delete-expired-trial';
    protected $description = 'Soft delete 7 hari & force delete 30 hari untuk folder trial';

    public function handle()
    {

        $softDeleteDate = Carbon::now()->subDays(7);

        $softDeleted = FolderModel::where('is_trial', 1)
            ->whereNull('deleted_at')
            ->where('created_at', '<=', $softDeleteDate)
            ->get();

        foreach ($softDeleted as $folder) {
            $folder->delete();
        }


        $forceDeleteDate = Carbon::now()->subDays(30);

        $forceDeleted = FolderModel::withTrashed()
            ->where('is_trial', 1)
            ->where('created_at', '<=', $forceDeleteDate)
            ->get();

        foreach ($forceDeleted as $folder) {
            $folder->forceDelete();
        }

        $this->info(
            "Soft deleted: {$softDeleted->count()} | Permanently deleted: {$forceDeleted->count()}"
        );
    }
}
