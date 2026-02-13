<?php

declare(strict_types=1);

namespace Relaticle\SystemAdmin\Policies;

use App\Models\User;

final class NotePolicy
{
    public function viewAny(): bool
    {
        return true;
        // System admins can view all notes across all tenants
    }

    public function view(): bool
    {
        return true;
        // System admins can view any specific note
    }

    public function create(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function update(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function delete(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function deleteAny(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function restore(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function forceDelete(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->is_system_admin;
    }

    public function restoreAny(User $user): bool
    {
        return $user->is_system_admin;
    }
}
