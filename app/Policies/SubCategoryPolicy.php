<?php

namespace App\Policies;

use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_sub::category');
    }

    public function view(User $user, SubCategory $subCategory): bool
    {
        return $user->can('view_sub::category');
    }

    public function create(User $user): bool
    {
        return $user->can('create_sub::category');
    }

    public function update(User $user, SubCategory $subCategory): bool
    {
        return $user->can('update_sub::category');
    }

    public function delete(User $user, SubCategory $subCategory): bool
    {
        return $user->can('delete_sub::category');
    }

    public function restore(User $user, SubCategory $subCategory): bool
    {
        return $user->can('restore_sub::category');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_sub::category');
    }

    public function forceDelete(User $user, SubCategory $subCategory): bool
    {
        return $user->can('force_delete_sub::category');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_sub::category');
    }

    public function replicate(User $user, SubCategory $subCategory): bool
    {
        return $user->can('replicate_sub::category');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder');
    }
}
