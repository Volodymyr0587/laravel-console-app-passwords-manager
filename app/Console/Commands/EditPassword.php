<?php

namespace App\Console\Commands;

use App\Models\PasswordRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use function Laravel\Prompts\error;
use function Laravel\Prompts\text;
use function Laravel\Prompts\info;

class EditPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:edit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit an existing password record';

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

        $newResourceName = text(
            label: 'Enter the new resource name (Leave blank to keep current):',
            placeholder: $record->resource_name,
            validate: ['string', 'min:2', 'max:255']
        );

        $newLogin = text(
            label: 'Enter the new username|login (Leave blank to keep current):',
            placeholder: $record->login,
            validate: ['string', 'min:2', 'max:255']
        );

        $newPassword = text(
            label: 'Enter the new password (Leave blank to keep current):',
            validate: ['string', 'min:2', 'max:255']
        );

        $newAdditionalInfo = text(
            label: 'Enter the new additional information (Leave blank to keep current):',
            placeholder: $record->additionalInfo ?? '',
            validate: ['string', 'max:500']
        );

        $record->update([
            'resource_name' => $newResourceName ?: $record->resource_name,
            'login' => $newLogin ?: $record->login,
            'password' => $newPassword ?: $record->password,
            'additional_info' => $newAdditionalInfo ?: $record->additional_info,
        ]);

        info('Password record updated successfully!');
        return 0;
    }
}
