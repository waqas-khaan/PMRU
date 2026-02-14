<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_finance';

    public function up(): void
    {
        Schema::connection($this->connection)->create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('term_id');
            $table->unsignedBigInteger('fee_type_id');
            $table->string('class_name')->nullable()->comment('e.g. Class 1, Grade 10; NULL = applies to all');
            $table->decimal('amount', 12, 2);
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table->index('term_id');
            $table->index('fee_type_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('fee_structures');
    }
};
