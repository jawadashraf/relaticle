<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\CustomFieldSection;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class CustomFieldSectionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function view(User $user, CustomFieldSection $customFieldSection): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, CustomFieldSection $customFieldSection): bool
    {
        return $user->belongsToTeam($customFieldSection->team);
    }

    public function delete(User $user, CustomFieldSection $customFieldSection): bool
    {
        return $user->belongsToTeam($customFieldSection->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function restore(User $user, CustomFieldSection $customFieldSection): bool
    {
        return $user->belongsToTeam($customFieldSection->team);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function forceDelete(User $user, CustomFieldSection $customFieldSection): bool
    {
        return $user->currentTeam && $user->hasTeamRole($user->currentTeam, 'admin');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->currentTeam && $user->hasTeamRole($user->currentTeam, 'admin');
    }
}
