<?php

namespace App\Http\Controllers;

use App\Http\Models\DoctorProfile;
use App\Http\Models\Role;
use App\Http\Models\User;
use Core\Request;
use Core\Session;
use Core\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $doctorRole = Role::where('name', '=', 'doctor')[0];

        return view('doctor.manage-doctor.index', [
            'doctors' => User::where('role_id', '=', $doctorRole->id)
        ]);
    }

    public function create()
    {
        return view('doctor.manage-doctor.create');
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
            return redirect('/doctors/create');
        }

        $user = new User();
        $user->role_id = Role::where('name', '=', 'doctor')[0]->id;
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);

        if ($doctor = $user->save()) {
            $doctorProfile = new DoctorProfile();
            $doctorProfile->user_id = $doctor->id;
            $doctorProfile->save();
        }

        Session::flash('success', 'Doctor was successfully created!');

        return redirect('/doctors');
    }

    public function edit(User $user)
    {
        if (!$user->isRole('doctor')) {
            return redirect('/doctors');
        }

        $user = clone $user;
        unset($user->password);

        return view('doctor.manage-doctor.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (!$user->isRole('doctor')) {
            return redirect('/doctors');
        }

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
            return redirect('/doctors/edit/' . $user->id);
        }

        $user->update($data);

        Session::flash('success', 'Changes saved successfully!');

        return redirect('/doctors');
    }

    public function destroy(User $user)
    {
        if (!$user->isRole('doctor')) {
            return redirect('/doctors');
        }

        DoctorProfile::where('user_id', '=', $user->id)[0]->delete();

        $user->delete();

        Session::flash('success', 'Admin account has been successfully deleted!');

        return redirect('/doctors');
    }
}
