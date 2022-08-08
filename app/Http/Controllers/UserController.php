<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\NewUserRequest;

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
        if (Gate::allows('admin', $role)) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => $role,
                'user_id' => $role::create()->id,
            ]);
            return redirect()->route('user.index')->withStatus(__('User successfully created.'));
        } else {
            return redirect()->back()->withErrors(['role' => 'You may not create this a user with this role']);
        }
    }
}
