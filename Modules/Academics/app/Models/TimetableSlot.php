<?php

namespace Modules\Academics\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimetableSlot extends Model
{
    protected $connection = 'mysql_academics';

    protected $fillable = [
        'class_id',
        'section_id',
        'subject_id',
        'day_of_week',
        'period',
        'start_time',
        'end_time',
        'room',
    ];

    // start_time / end_time are MySQL TIME columns (string in PHP e.g. "09:00:00")

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
