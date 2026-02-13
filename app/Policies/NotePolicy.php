<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class NotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function view(User $user, Note $note): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Note $note): bool
    {
        return true;
    }

    public function delete(User $user, Note $note): bool
    {
        return $user->is_system_admin;
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function restore(User $user, Note $note): bool
    {
        return $user->is_system_admin;
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function forceDelete(User $user, Note $note): bool
    {
        return $user->is_system_admin;
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->is_system_admin;
    }
}
