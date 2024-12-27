<?php

namespace App\Console\Commands\Auth;

use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use function Laravel\Prompts\password;

class LoginUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log in as an existing user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = text(
            label: 'Enter your email:',
            required: true,
            validate: ['string', 'email']
        );
        $password = password(
            label: 'Enter your password:',
            required: true,
            validate: ['min:2', 'max:50']
        );

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            $this->error('Invalid email or password!');
            return 1;
        }

        Cache::put('authenticated_user_id', $user->id, now()->addHours(1));

        $this->info('Login successful! Welcome back, ' . $user->name);
        return 0;
    }
}
