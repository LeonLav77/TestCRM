<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
        $role_id = Role::where('name', $request->role)->first()->id ?? null;
        $role = getModelFromRoleName($request->role) ?? null;
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
                'role_id' => $role_id,
            ]);
            return redirect()->route('users.index')->withStatus(__('User successfully created.'));
        } else {
            return redirect()->back()->withErrors(['role' => 'You may not create this a user with this role']);
        }
    }

    public function edit(User $user){
        return view('users.create', ['user' => $user]);
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.create')->withStatus(__('User successfully deleted.'));
    }
}
