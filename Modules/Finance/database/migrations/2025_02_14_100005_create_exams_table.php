<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_finance';

    public function up(): void
    {
        Schema::connection($this->connection)->create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('term_id');
            $table->string('name');
            $table->date('exam_date')->nullable();
            $table->string('class_name')->nullable()->comment('Optional: filter by class');
            $table->string('subject_name')->nullable()->comment('Optional: filter by subject');
            $table->decimal('total_marks', 8, 2)->nullable();
            $table->timestamps();

            $table->index('term_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('exams');
    }
};
