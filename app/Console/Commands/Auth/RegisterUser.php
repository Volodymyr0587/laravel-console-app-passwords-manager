<?php

namespace App\Console\Commands\Auth;

use App\Models\User;
use App\Rules\PreventCommonPassword;
use Illuminate\Console\Command;
use Illuminate\Validation\Rules\Password;
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;
use function Laravel\Prompts\warning;
use function Laravel\Prompts\info;
use function Laravel\Prompts\error;



class RegisterUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text(
            label: 'Enter your name:',
            required: true,
            validate: ['min:2', 'max:50']
        );
        $email = text(
            label: 'Enter your email:',
            required: true,
            validate: ['string', 'email', 'unique:users,email']
        );
        $password = password(
            label: 'Enter your password:',
            required: true,
            validate: [Password::min(6), new PreventCommonPassword]
        );
        $passwordConfirmation = password(
            label: 'Confirm your password:',
            required: true,
            validate: [Password::min(6), new PreventCommonPassword]
        );

        if ($password !== $passwordConfirmation) {
            error('Password do not match!');
            return 1;
        }

        if (User::where('email', $email)->exists()) {
            warning('Email is already registered!');
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        info('Registration successful!');
        return 0;
    }
}
