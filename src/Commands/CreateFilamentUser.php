<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Commands;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Filament\Support\Commands\Concerns\CanValidateInput;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    use CanValidateInput;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-access-control:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new filament admin user.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $values = [
            'first_name' => $this->validateInput(fn () => $this->ask('First Name'), 'first_name', ['required']),
            'last_name' => $this->validateInput(fn () => $this->ask('Last Name'), 'last_name', ['required']),
            'email' => $this->validateInput(
                fn () => $this->ask('Email address'),
                'email',
                ['required', 'email', 'unique:filament_users'],
            ),
            'password' => Hash::make(
                $this->validateInput(fn () => $this->secret('Password'), 'password', ['required', 'min:8']),
            ),
        ];

        if (Feature::enabled(Feature::ACCOUNT_EXPIRY)) {
            $values = array_merge($values, [
                'expires_at' => now()->addMonths(6)->endOfDay(),
            ]);
        }

        $user = config('filament-access-control.user_model')::query()->create($values);
        $user->assignRole(RoleName::SUPER_ADMIN);
        $user->save();
        $loginUrl = route('filament.auth.login');
        $this->info("Success! {$user->email} may now log in at {$loginUrl}.");

        return self::SUCCESS;
    }
}
