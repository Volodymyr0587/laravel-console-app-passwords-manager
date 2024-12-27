<?php

namespace App\Console\Commands;

use App\Models\PasswordRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use function Laravel\Prompts\table;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;


class ListPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View the entire list of passwords';

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

        // Fetch records for the authenticated user
        $records = PasswordRecord::where('user_id', $authenticatedUserId)
                    ->get(['id', 'resource_name', 'login', 'password', 'additional_info'])
                    ->toArray();

        if (!$records) {
            info('You have no records yet');
            return 1;
        }

        table(
            headers: ['ID', 'Resource Name', 'Login', 'Password', 'Additional information'],
            rows: $records
        );

        return 0;
    }
}
