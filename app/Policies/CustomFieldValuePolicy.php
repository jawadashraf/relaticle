<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\CustomFieldValue;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class CustomFieldValuePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function view(User $user, CustomFieldValue $customFieldValue): bool
    {
        return $user->belongsToTeam($customFieldValue->team);
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function update(User $user, CustomFieldValue $customFieldValue): bool
    {
        return $user->belongsToTeam($customFieldValue->team);
    }

    public function delete(User $user, CustomFieldValue $customFieldValue): bool
    {
        return $user->belongsToTeam($customFieldValue->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function restore(User $user, CustomFieldValue $customFieldValue): bool
    {
        return $user->belongsToTeam($customFieldValue->team);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasVerifiedEmail() && $user->currentTeam !== null;
    }

    public function forceDelete(User $user, CustomFieldValue $customFieldValue): bool
    {
        return $user->hasTeamRole(Filament::getTenant(), 'admin');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->hasTeamRole(Filament::getTenant(), 'admin');
    }
}
