<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
     public function __construct()
    {
    }
    public function seeUser(User $user, User $secondUser){
        if($user->hasRole(getModelFromRoleName('student'))){
            // if you are a student trying to see students
            if ($secondUser->hasRole(getModelFromRoleName('student'))) {
                echo 'true';
                return true;
            }else{
               return false;
            }
        }
        if($user->hasRole(getModelFromRoleName('teacher'))){
            // if you are a teacher trying to see students and admins
            if ($secondUser->hasRole('App\Models\Admin')) {
                return false;
            }else{
                return true;
            }
        }
        return true;
    }
}
