<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\CustomFieldOption;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class CustomFieldOptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, CustomFieldOption $customFieldOption): bool
    {
        return $user->belongsToTeam($customFieldOption->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, CustomFieldOption $customFieldOption): bool
    {
        return $user->belongsToTeam($customFieldOption->team);
    }

    public function delete(User $user, CustomFieldOption $customFieldOption): bool
    {
        return $user->belongsToTeam($customFieldOption->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, CustomFieldOption $customFieldOption): bool
    {
        return $user->belongsToTeam($customFieldOption->team);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function forceDelete(User $user, CustomFieldOption $customFieldOption): bool
    {
        return $user->hasTeamRole(Filament::getTenant(), 'admin');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->hasTeamRole(Filament::getTenant(), 'admin');
    }
}
