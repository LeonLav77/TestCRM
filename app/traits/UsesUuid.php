<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UsesUuid
{
	public function getIncrementing()
	{
		return false;
	}

	public function getKeyType()
	{
		return 'string';
	}

    protected static function boot(){
        parent::boot();
        static::creating(function($user){
            $user->id = Str::uuid();
        });
    }
}
