<?php

namespace App\Console\Commands;

use App\Models\PasswordRecord;
use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\error;
use function Laravel\Prompts\confirm;
use Illuminate\Support\Facades\Cache;

class DeletePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing password record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $authenticatedUserId = Cache::get('authenticated_user_id');
        if (!$authenticatedUserId) {
            error('You must log in first!');
            return 1;
        }

        $recordId = text(
            label: "Enter the ID (use the 'password:list' command to view all IDs) of the password record to edit:",
        );
        $record = PasswordRecord::where('id', $recordId)
                    ->where('user_id', $authenticatedUserId)
                    ->first();

        if (!$record) {
            error('Record not found or access denied!');
            return 1;
        }

        $confirmed = confirm(
            label: 'Are you sure you want to delete the record?',
        );

        if (!$confirmed) {
            info('You have canceled the delete operation');
            return 1;
        }

        $record->delete();
        info('Password record deleted successfully!');
        return 0;
    }
}
