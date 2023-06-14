<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        return in_array(Role::IS_MANAGER, $userRoles);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        if (in_array(Role::IS_MANAGER, $userRoles)) {
            return Response::allow();
        }

        return Response::deny();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): Response
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        if (in_array(Role::IS_MANAGER, $userRoles)) {
            return Response::allow();
        }

        return Response::deny();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): Response
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        if (in_array(Role::IS_MANAGER, $userRoles)) {
            return Response::allow();
        }

        return Response::deny();
    }
}
