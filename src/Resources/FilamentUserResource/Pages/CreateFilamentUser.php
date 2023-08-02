<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Notifications\SetPassword;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class CreateFilamentUser extends CreateRecord
{
    protected static string $resource = FilamentUserResource::class;

    public function afterCreate(): void
    {
        $user = $this->record;
        $token = Password::broker('filament')->createToken($user);
        $url = Filament::getResetPasswordUrl($token, $user);
        $requestUrl = Filament::getRequestPasswordResetUrl();
        $user->notify(new SetPassword($url, $requestUrl));

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Str::random(40);

        return $data;
    }
}
