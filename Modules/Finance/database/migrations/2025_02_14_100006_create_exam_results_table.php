<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_finance';

    public function up(): void
    {
        Schema::connection($this->connection)->create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id')->comment('References students.id in school_students_db');
            $table->decimal('marks', 8, 2);
            $table->string('grade', 20)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['exam_id', 'student_id']);
            $table->index('student_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('exam_results');
    }
};
