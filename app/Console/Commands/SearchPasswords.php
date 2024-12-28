<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\PasswordRecord;

class SearchPasswords extends Command
{
    protected $signature = 'password:search';
    protected $description = 'Search for specific password records by resource name or login';

    public function handle()
    {
        $authenticatedUserId = Cache::get('authenticated_user_id');
        if (!$authenticatedUserId) {
            $this->error('You must log in first!');
            return 1;
        }

        $query = $this->ask('Enter search term (resource name or login)');

        $records = PasswordRecord::where('user_id', $authenticatedUserId)
                    ->where(function($queryBuilder) use ($query) {
                        $queryBuilder->where('resource_name', 'LIKE', "%{$query}%")
                                     ->orWhere('login', 'LIKE', "%{$query}%");
                    })
                    ->get(['id', 'resource_name', 'login', 'password', 'additional_info'])
                    ->toArray();

        if (empty($records)) {
            $this->info('No records found matching your search criteria.');
            return 1;
        }

        $this->table(
            ['ID', 'Resource Name', 'Login', 'Password', 'Additional information'],
            $records
        );

        return 0;
    }
}
