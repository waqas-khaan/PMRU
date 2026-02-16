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

        // If the table already exists (e.g. created manually or on a previous deploy),
        // don't fail the migration run.
        if ($schema->hasTable('academic_years')) {
            return;
        }

        $schema->create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('academic_years');
    }
};
