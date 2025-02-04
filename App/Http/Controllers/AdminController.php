<?php

namespace App\Http\Controllers;

use App\Http\Models\Role;
use App\Http\Models\User;
use Core\Request;
use Core\Session;
use Core\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $adminRole = Role::where('name', '=', 'admin')[0];

        return view('admin.manage-admins.index', [
            'users' => User::where('role_id', '=', $adminRole->id)
        ]);
    }

    public function create()
    {
        return view('admin.manage-admins.create');
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ];

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            return redirect('/admins/create');
        }

        $user = new User();
        $user->role_id = 2;
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);

        $user->save();

        Session::flash('success', 'The admin was successfully registered!');

        return redirect('/admins');
    }

    public function edit(User $user)
    {
        $user = clone $user;
        unset($user->password);

        return view('admin.manage-admins.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email
        ];

        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id

        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            return redirect('/admins/edit/' . $user->id);
        }

        $user->update($data);

        Session::flash('success', 'Changes saved successfully!');

        return redirect('/admins');
    }


    public function destroy(User $user)
    {
        $user->delete();
        Session::flash('success', 'Admin account has been successfully deleted!');

        return redirect('/admins');
    }
}
