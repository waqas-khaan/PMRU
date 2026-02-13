<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Auth\Models\User;
use Modules\Auth\Models\Role;

class AuthController extends Controller
{
    // Login page
    public function showLoginForm()
    {
        return view('auth::login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('auth.dashboard'); // redirect after login
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

    // Registration page
    public function showRegisterForm()
    {
        $roles = Role::all();
        return view('auth::register', compact('roles'));
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique(User::class, 'email')],
            'password' => 'required|confirmed|min:6',
            'role_id' => ['required', Rule::exists(Role::class, 'id')]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);

        // Attach role
        $user->roles()->sync([$request->role_id]);

        // Auto-login after registration (optional)
        Auth::login($user);

        return redirect()->route('auth.dashboard')->with('success', 'User registered successfully');
    }

    // Dashboard
    public function dashboard()
    {
        return view('auth::dashboard');
    }
}