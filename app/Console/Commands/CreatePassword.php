<?php

namespace App\Console\Commands;

use App\Models\PasswordRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use function Laravel\Prompts\error;
use function Laravel\Prompts\text;
use function Laravel\Prompts\info;


class CreatePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new password record';

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

        $resourceName = text(
            label: 'Enter the resource name:',
            required: true,
            validate: ['string', 'min:2', 'max:255']
        );

        $login = text(
            label: 'Enter the username (login):',
            required: true,
            validate: ['string', 'min:2', 'max:255']
        );

        $password = text(
            label: 'Enter the password:',
            required: true,
            validate: ['string', 'min:2', 'max:255']
        );

        $additionalInfo = text(
            label: 'Enter the additional information (email, note, etc.):',
            required: false,
            validate: ['string', 'max:500']
        );

        PasswordRecord::create([
            'resource_name' => $resourceName,
            'login' => $login,
            'password' => $password,
            'additional_info' => $additionalInfo,
            'user_id' => $authenticatedUserId,
        ]);

        info('Password record created successfully!');
        return 0;
    }
}
