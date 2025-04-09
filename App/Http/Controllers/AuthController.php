<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Core\Request;
use Core\Session;
use Core\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view(view: 'auth.login');
    }

    public function attempt(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $rules = [
            'email' => 'required|email'
        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            return redirect('/login');
        }

        $user = User::queryBuilder()
            ->where('email', '=', $data['email'])
            ->first() ?? null;
        if (!$user || !password_verify($data['password'], $user->password)) {
            Session::flash('error', 'Invalid email or password.');

            return redirect('/login');
        }

        $user = clone $user;
        unset($user->password);

        Session::set('user', $user);

        return redirect('/dashboard');
    }

    public function destroy()
    {
        Session::destroy();
        Session::flash('success', 'You have been logged out.');
        return redirect('/login');
    }
}
