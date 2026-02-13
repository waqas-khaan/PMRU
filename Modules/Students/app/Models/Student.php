<?php

namespace Modules\Students\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $connection = 'mysql_students';

    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'guardian_id',
        'class',
        'section',
        'enrollment_date',
    ];

    /**
     * Append single display name so UI/API always see "full name", not first/last separately.
     */
    protected $appends = ['name'];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'enrollment_date' => 'date',
        ];
    }

    /**
     * Single display name for the whole app: matches the "Full name" form field.
     * Prefer full_name, otherwise first_name + last_name (for DBs that only have those).
     */
    public function getNameAttribute(): string
    {
        $full = $this->attributes['full_name'] ?? null;
        if ($full !== null && $full !== '') {
            return $full;
        }
        return trim(($this->attributes['first_name'] ?? '') . ' ' . ($this->attributes['last_name'] ?? ''));
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class);
    }
}
