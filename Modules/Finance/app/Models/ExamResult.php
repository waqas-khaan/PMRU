<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResult extends Model
{
    protected $connection = 'mysql_finance';

    protected $fillable = [
        'exam_id',
        'student_id',
        'marks',
        'grade',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'marks' => 'decimal:2',
        ];
    }

    /**
     * student_id references students.id in school_students_db (cross-DB; no FK).
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
