<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mysql_academics';

    public function up(): void
    {
        $schema = Schema::connection($this->connection);

        if ($schema->hasTable('classes')) {
            return;
        }

        $schema->create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('level')->nullable()->comment('Numeric order e.g. 1,2,3');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('classes');
    }
};
