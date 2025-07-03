<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function ($table) {
            $table->timestamp('took_at')->nullable()->change();
            $table->timestamp('deadline')->nullable()->change();
            $table->timestamp('did_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function ($table) {
            $table->date('took_at')->nullable()->change();
            $table->date('deadline')->nullable()->change();
            $table->date('did_at')->nullable()->change();
        });
    }
};
