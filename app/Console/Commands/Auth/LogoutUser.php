<?php

namespace App\Console\Commands\Auth;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LogoutUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:logout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log out auth user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        Cache::forget('authenticated_user_id');

        $this->info('You are logout!');

        return 0;
    }
}
