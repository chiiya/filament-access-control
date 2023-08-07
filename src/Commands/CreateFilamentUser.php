<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Commands;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateFilamentUser extends Command
{
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
     * @return class-string<Model>
     */
    protected static function getUserModel(): string
    {
        return config('filament-access-control.user_model');
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $values = [
            'first_name' => text(label: 'First Name', required: true),
            'last_name' => text(label: 'Last Name', required: true),
            'email' => text(
                label: 'Email address',
                required: true,
                validate: fn (string $email): ?string => match (true) {
                    ! filter_var($email, FILTER_VALIDATE_EMAIL) => 'The email address must be valid.',
                    static::getUserModel()::query()->where(
                        'email',
                        '=',
                        $email,
                    )->exists() => 'A user with this email address already exists',
                    default => null,
                },
            ),
            'password' => Hash::make(password(label: 'Password', required: true)),
        ];

        if (Feature::enabled(Feature::ACCOUNT_EXPIRY)) {
            $values = array_merge($values, [
                'expires_at' => now()->addMonths(6)->endOfDay(),
            ]);
        }

        $user = static::getUserModel()::query()->create($values);
        $user->assignRole(RoleName::SUPER_ADMIN);
        $user->save();
        $this->info("Success! {$user->email} may now log in.");

        return self::SUCCESS;
    }
}
