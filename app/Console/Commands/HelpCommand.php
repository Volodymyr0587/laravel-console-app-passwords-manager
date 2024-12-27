<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class HelpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all custom commands for this application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve all available commands
        $commands = collect(Artisan::all())
            ->filter(fn($command) => str_starts_with($command->getName(), 'password:') || str_starts_with($command->getName(), 'user:')) // Filter custom commands
            ->map(fn($command) => [
                'Command' => $command->getName(),
                'Description' => $command->getDescription(),
            ])
            ->toArray();

        if (empty($commands)) {
            $this->info('No custom commands found.');
            return 1;
        }

        // Display the commands in a table
        $this->table(['Command', 'Description'], $commands);

        return 0;
    }
}
