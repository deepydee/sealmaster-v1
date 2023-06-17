<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SlidePolicy
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

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        if ($user->isAdministrator()) {
            return Response::allow();
        }

        return Response::denyWithStatus(404);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Slide $slide): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        $userRoles = $user->roles->pluck('id')->toArray();

        if (in_array(Role::IS_ADMIN, $userRoles)) {
            return Response::allow();
        }

        return Response::denyWithStatus(404);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Slide $slide): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Slide $slide): bool
    {
        return $user->isAdministrator();
    }
}
