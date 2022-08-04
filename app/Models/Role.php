<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, UsesUuid;
    public $fillable = ['name'];
    public const ADMIN = 'admin';
    public const STUDENT = 'student';
    public const TEACHER = 'teacher';
}
