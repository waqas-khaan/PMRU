<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_academics';

    public function up(): void
    {
        Schema::connection($this->connection)->create('timetable_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedTinyInteger('day_of_week')->comment('1=Mon .. 7=Sun');
            $table->unsignedInteger('period');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('room', 100)->nullable();
            $table->timestamps();

            $table->index('class_id');
            $table->index('section_id');
            $table->index('subject_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('timetable_slots');
    }
};
