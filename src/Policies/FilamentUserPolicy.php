<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Policies;

use Chiiya\FilamentAccessControl\Enumerators\PermissionName;
use Illuminate\Contracts\Auth\Access\Authorizable;

class FilamentUserPolicy
{
    public function viewAny(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function view(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function create(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function update(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function delete(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function restore(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }

    public function forceDelete(Authorizable $user): bool
    {
        return $user->can(PermissionName::UPDATE_ADMIN_USERS);
    }
}
