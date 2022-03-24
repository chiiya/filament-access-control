<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Policies;

use Chiiya\FilamentAccessControl\Enumerators\PermissionName;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class FilamentUserPolicy
{
    public function viewAny(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function view(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function create(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function update(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function delete(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function restore(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function forceDelete(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }
}
