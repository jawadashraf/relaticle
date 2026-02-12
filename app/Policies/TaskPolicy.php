<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\HandlesAuthorization;

final readonly class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function view(User $user, Task $task): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function update(User $user, Task $task): bool
    {
        return $user->belongsToTeam($task->team);
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->belongsToTeam($task->team);
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function restore(User $user, Task $task): bool
    {
        return $user->belongsToTeam($task->team);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $user->currentTeam && $user->hasTeamRole($user->currentTeam, 'admin');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->currentTeam && $user->hasTeamRole($user->currentTeam, 'admin');
    }
}
