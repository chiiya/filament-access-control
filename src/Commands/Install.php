<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Commands;

use Chiiya\FilamentAccessControl\Database\Seeders\FilamentAccessControlSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-access-control:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the necessary roles and permissions in database.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        Artisan::call('db:seed', [
            '--class' => FilamentAccessControlSeeder::class,
            '--force' => true,
        ]);

        $this->output->success('Filament Access Control has been installed successfully.');

        return self::SUCCESS;
    }
}
