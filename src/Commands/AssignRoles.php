<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\search;

class AssignRoles extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament-access-control:assign-roles {user} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign roles to a filament user.';

    /**
     * @return class-string<Model>
     */
    protected static function getUserModel(): string
    {
        return config('filament-access-control.user_model');
    }

    /**
     * @return class-string<Model>
     */
    protected static function getRoleModel(): string
    {
        return config('permission.models.role');
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = static::getUserModel()::query()
            ->find($this->argument('user'));

        if (! $user) {
            return self::FAILURE;
        }

        $role = Role::findByName($this->argument('role'), config('filament-access-control.guard_name', 'filament'));

        $user->assignRole($role);
        $this->info("The role {$role} was assigned to User {$user->id}.");

        return self::SUCCESS;
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array<string, string>
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'user' => fn () => search(
                label: 'Search for a user by email:',
                options: fn ($value) => mb_strlen($value) > 0
                    ? static::getUserModel()::whereLike('email', "%{$value}%")->pluck('email', 'id')->all()
                    : [],
            ),
            'Which user ID do you want to manage?',
            'role' => fn () => search(
                label: 'Search for a role:',
                placeholder: 'e.g. admin',
                options: fn ($value) => mb_strlen($value) > 0
                    ? static::getRoleModel()::whereLike('name', "%{$value}%")->where('guard_name', 'filament')->pluck(
                        'name',
                    )->all()
                    : [],
            ),
        ];
    }
}
