<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\People;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class PeoplePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function view(User $user, People $people): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, People $people): bool
    {
        return true;
    }

    public function delete(User $user, People $people): bool
    {
        return $user->is_system_admin;
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function restore(User $user, People $people): bool
    {
        return $user->is_system_admin;
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function forceDelete(User $user, People $people): bool
    {
        return $user->is_system_admin;
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->is_system_admin;
    }
}
