<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mysql_auth';

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user'); // pivot table fixed
    }
}