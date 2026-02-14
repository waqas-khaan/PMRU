<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_academics';

    public function up(): void
    {
        Schema::connection($this->connection)->create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->string('name');
            $table->unsignedInteger('capacity')->nullable();
            $table->timestamps();

            $table->index('class_id');
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('sections');
    }
};
