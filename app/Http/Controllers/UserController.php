<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function create(){
        return view('users.create');
    }

    public function store(NewUserRequest $request){
        $role = getModelFromRoleName($request->role);
        if(!$role){
            return redirect()->back()->withErrors(['role' => 'Invalid role']);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => $role,
            'user_id' => $role::create()->id,
        ]);
        return $user;
    }
}
