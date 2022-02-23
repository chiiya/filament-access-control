<?php

namespace Chiiya\FilamentAccessControl\Commands;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'filament:create-user {email} {first_name} {last_name} {password}';

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
        $email = $this->input->getArgument('email');
        $firstName = $this->input->getArgument('first_name');
        $lastName = $this->input->getArgument('last_name');
        $password = $this->input->getArgument('password');

        if (FilamentUser::query()->where('email', $email)->exists()) {
            $this->output->error('User already found in database.');

            return self::FAILURE;
        }

        $attributes = array_merge([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'password' => Hash::make($password),
        ], (Feature::ACCOUNT_EXPIRY)->enabled() ? [
            'expires_at' => now()->addMonths(6)->endOfDay(),
        ] : []);

        /** @var FilamentUser $user */
        $user = FilamentUser::query()->create($attributes);
        $user->assignRole(RoleName::SUPER_ADMIN);
        $user->save();
        $this->output->success('User has been added.');

        return self::SUCCESS;
    }
}
