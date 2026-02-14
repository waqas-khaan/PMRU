<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_finance';

    public function up(): void
    {
        Schema::connection($this->connection)->create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->comment('References students.id in school_students_db');
            $table->unsignedBigInteger('fee_structure_id');
            $table->decimal('amount', 12, 2);
            $table->date('paid_at');
            $table->string('payment_method', 100)->nullable();
            $table->string('reference')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('student_id');
            $table->index('fee_structure_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('fee_payments');
    }
};
