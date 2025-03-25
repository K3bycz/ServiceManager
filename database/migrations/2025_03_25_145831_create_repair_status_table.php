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
        Schema::create('repair_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('text_color');
            $table->string('background_color');
            $table->timestamps();
        });

        Schema::table('repairs', function (Blueprint $table) {
            $table->foreignId('status_id')
                ->constrained('repair_statuses')
                ->onDelete('cascade');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->string('status');
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });

        Schema::dropIfExists('repair_statuses');
    }
};
