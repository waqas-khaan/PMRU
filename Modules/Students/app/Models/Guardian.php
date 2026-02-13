<?php

namespace Modules\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    protected $connection = 'mysql_students';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'relationship',
        'address',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
