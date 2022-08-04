<?php

use App\Models\Role;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;

function getModelFromRoleName($role){
    $role = strtolower($role);
    switch($role){
        case Role::ADMIN:
            return Admin::class;
        case Role::STUDENT:
            return Student::class;
        case Role::TEACHER:
            return Teacher::class;
        default:
            return null;
    }
}