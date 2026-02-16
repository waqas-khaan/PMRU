<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Models\Role;
use Modules\Auth\Models\User;

class AuthController extends Controller
{
    /**
     * Ensure default roles exist so register form can show role selection.
     */
    protected function ensureDefaultRolesExist(): void
    {
        if (! Schema::connection('mysql_auth')->hasTable('roles')) {
            return;
        }

        if (Role::query()->count() > 0) {
            return;
        }

        $roles = [
            ['name' => 'Admin', 'description' => 'Administrator with full access'],
            ['name' => 'Teacher', 'description' => 'Teaching staff'],
            ['name' => 'Student', 'description' => 'Student user'],
            ['name' => 'Parent', 'description' => 'Parent or guardian'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }

    public function showLoginForm()
    {
        return view('auth::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return $this->redirectAfterLogin($request);
            }
        } catch (\Throwable $e) {
            // Stored password may not be a valid bcrypt hash (e.g. plain text from manual SQL insert)
            report($e);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        $this->ensureDefaultRolesExist();

        $roles = Schema::connection('mysql_auth')->hasTable('roles')
            ? Role::orderBy('name')->get()
            : collect();

        return view('auth::register', compact('roles'));
    }

    public function register(Request $request)
    {
        $this->ensureDefaultRolesExist();

        $rolesExist = Schema::connection('mysql_auth')->hasTable('roles');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        if ($rolesExist) {
            $rules['role'] = ['required', Rule::exists(Role::class, 'id')];
        }

        $validated = $request->validate($rules, [
            'role.required' => 'Please select a role.',
            'role.exists' => 'The selected role is invalid.',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];
        if ($rolesExist && ! empty($validated['role'])) {
            $userData['role_id'] = $validated['role'];
        }

        $user = User::create($userData);

        if ($rolesExist && ! empty($validated['role'])) {
            $user->roles()->attach($validated['role']);
        }

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    /**
     * Role-based redirect after login: respect intended URL only if the user's role can access it.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectAfterLogin(Request $request)
    {
        /** @var \Modules\Auth\Models\User $user */
        $user = Auth::user();
        $intended = $request->session()->pull('url.intended');

        if ($intended && $user->canAccessPath($intended)) {
            return redirect()->to($intended);
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
