<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Step 1: Add the column without foreign key
            $table->unsignedBigInteger('incident_type_id')->after('user_id')->nullable();
        });

        // Step 2: Set a default value for existing records (update all rows)
        DB::statement('UPDATE reports SET incident_type_id = 1 WHERE incident_type_id IS NULL');

        Schema::table('reports', function (Blueprint $table) {
            // Step 3: Add the foreign key constraint
            $table->foreign('incident_type_id')->references('id')->on('incident_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['incident_type_id']);
            $table->dropColumn('incident_type_id');
        });
    }
};
