<?php

namespace Modules\Auth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql_auth';

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user'); // pivot table fixed
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if user has at least one of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        if (empty($roles)) {
            return false;
        }

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Whether this user can access the given path (for role-based redirect after login).
     * Mirrors the same rules as the sidebar: Finance=Admin, Academics=Admin|Teacher, etc.
     */
    public function canAccessPath(string $path): bool
    {
        $path = '/' . ltrim(parse_url($path, PHP_URL_PATH) ?? '', '/');

        // Finance: Admin only
        if (str_starts_with($path, '/finance')) {
            return $this->hasRole('Admin');
        }
        // Academics: Admin, Teacher
        if (str_starts_with($path, '/academics')) {
            return $this->hasAnyRole(['Admin', 'Teacher']);
        }
        // Students create/edit/update/destroy: Admin, Teacher (index/show allowed for all)
        if (preg_match('#^/students/create#', $path) || preg_match('#^/students/\d+/edit#', $path)) {
            return $this->hasAnyRole(['Admin', 'Teacher']);
        }
        // Dashboard, students index/show: all roles
        return true;
    }
}