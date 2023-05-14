<?php

namespace App\Policies;

use App\Models\SportMatch;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SportMatchPolicy
{
    /**
     * Determine whether the user can view the model index.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SportMatch $sportMatch): bool
    {
        return $sportMatch->club_id === $user->club_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SportMatch $sportMatch): bool
    {
        return $user->hasRole('admin') && ($sportMatch->club_id === Auth::user()->club_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SportMatch $sportMatch): bool
    {
        return $user->hasRole('admin') && ($sportMatch->club_id === Auth::user()->club_id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SportMatch $sportMatch): bool
    {
        return $user->hasRole('admin') && ($sportMatch->club_id === Auth::user()->club_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SportMatch $sportMatch): bool
    {
        return $user->hasRole('admin') && ($sportMatch->club_id === Auth::user()->club_id);
    }
}
