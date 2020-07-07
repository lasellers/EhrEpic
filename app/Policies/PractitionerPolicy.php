<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Practitioner;
use Illuminate\Auth\Access\HandlesAuthorization;

class PractitionerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practitioner  $practitioner
     * @return mixed
     */
    public function view(User $user, Practitioner $practitioner)
    {
        return ($user->practitioner_id === $practitioner->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practitioner  $practitioner
     * @return mixed
     */
    public function update(User $user, Practitioner $practitioner)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practitioner  $practitioner
     * @return mixed
     */
    public function delete(User $user, Practitioner $practitioner)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practitioner  $practitioner
     * @return mixed
     */
    public function restore(User $user, Practitioner $practitioner)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Practitioner  $practitioner
     * @return mixed
     */
    public function forceDelete(User $user, Practitioner $practitioner)
    {
        //
    }
}
