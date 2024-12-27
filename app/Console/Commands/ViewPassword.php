<?php

namespace App\Console\Commands;

use App\Models\PasswordRecord;
use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Cache;

class ViewPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View details of a password record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $authenticatedUserId = Cache::get('authenticated_user_id');
        if (!$authenticatedUserId) {
            $this->error('You must log in first!');
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

        info("Resource Name: {$record->resource_name}");
        info("Username: {$record->login}");
        info("Password: {$record->password}");
        info("Additional information: {$record->additional_info}");

        return 0;
    }
}
