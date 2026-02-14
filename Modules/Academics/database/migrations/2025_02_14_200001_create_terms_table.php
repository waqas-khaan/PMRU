<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_academics';

    public function up(): void
    {
        Schema::connection($this->connection)->create('terms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->index('academic_year_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('terms');
    }
};
