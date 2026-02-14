<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeePayment extends Model
{
    protected $connection = 'mysql_finance';

    protected $fillable = [
        'student_id',
        'fee_structure_id',
        'amount',
        'paid_at',
        'payment_method',
        'reference',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'date',
        ];
    }

    /**
     * student_id references students.id in school_students_db (cross-DB; no FK).
     */
    public function feeStructure(): BelongsTo
    {
        return $this->belongsTo(FeeStructure::class);
    }
}
