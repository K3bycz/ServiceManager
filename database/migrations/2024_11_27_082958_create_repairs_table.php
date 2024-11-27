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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device')
                ->constrained('devices')
                ->onDelete('cascade');

            $table->string('title');
            $table->string('description')->nullable();
            $table->decimal('costs', 10, 2)->nullable();
            $table->decimal('profit', 10, 2)->nullable();
            $table->decimal('revenue', 10, 2)->nullable();
            $table->string('status'); 
            $table->date('date_received');
            $table->date('date_released')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
