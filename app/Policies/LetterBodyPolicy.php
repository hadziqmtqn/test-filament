<?php

namespace App\Policies;

use App\Models\LetterBody;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LetterBodyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_letter::body');
    }

    public function view(User $user, LetterBody $letterBody): bool
    {
        return $user->can('view_letter::body');
    }

    public function create(User $user): bool
    {
        return $user->can('create_letter::body');
    }

    public function update(User $user, LetterBody $letterBody): bool
    {
        return $user->can('update_letter::body');
    }

    public function delete(User $user, LetterBody $letterBody): bool
    {
        return $user->can('delete_letter::body');
    }

    public function restore(User $user, LetterBody $letterBody): bool
    {
        return $user->can('restore_letter::body');
    }

    public function forceDelete(User $user, LetterBody $letterBody): bool
    {
        return $user->can('force_delete_letter::body');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_letter::body');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_letter::body');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_letter::body');
    }
}
