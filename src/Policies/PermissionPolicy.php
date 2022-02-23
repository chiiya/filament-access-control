<?php

namespace Chiiya\FilamentAccessControl\Policies;

use Chiiya\FilamentAccessControl\Enumerators\PermissionName;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class PermissionPolicy
{
    public function viewAny(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }

    public function view(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }

    public function create(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }

    public function update(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }

    public function delete(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }

    public function restore(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }

    public function forceDelete(FilamentUser $user): bool
    {
        return $user->can(PermissionName::UPDATE_PERMISSIONS);
    }
}
