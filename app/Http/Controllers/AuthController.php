<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'))
                ->with('auth_form', 'login');
        }

        if (! Auth::attempt($validator->validated(), $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password tidak sesuai.'])
                ->withInput($request->only('email'))
                ->with('auth_form', 'login');
        }

        $request->session()->regenerate();

        $destination = Auth::user()->role?->name === 'admin'
            ? route('admin.dashboard')
            : route('home');

        return redirect()->to($destination);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('name', 'email'))
                ->with('auth_form', 'register');
        }

        $user = DB::transaction(function () use ($validator) {
            $profile = Profile::create([
                'umur' => 0,
                'bio' => '',
                'alamat' => '',
            ]);

            $role = Role::firstOrCreate(['name' => 'user']);

            return User::create([
                'name' => $validator->validated()['name'],
                'email' => $validator->validated()['email'],
                'password' => $validator->validated()['password'],
                'profile_id' => $profile->id,
                'role_id' => $role->id,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}