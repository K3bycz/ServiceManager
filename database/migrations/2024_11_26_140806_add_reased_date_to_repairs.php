<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->decimal('revenue', 10, 2)->nullable()->after('costs'); // Kolumna na przychód
            $table->date('date_received')->nullable()->after('updated_at'); // Zmień 'some_column' na kolumnę istniejącą w tabeli, po której chcesz dodać nową.
            $table->date('date_released')->nullable()->after('date_received');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repairs', function (Blueprint $table) {
            $table->dropColumn(['date_received', 'date_released', 'revenue']);
        });
    }
};