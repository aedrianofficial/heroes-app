<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('request_calls', function (Blueprint $table) {
            $table->unsignedBigInteger('incident_case_id')->nullable()->after('description');

            // Foreign key constraint to ensure referential integrity
            $table->foreign('incident_case_id')
                  ->references('id')
                  ->on('incident_cases')
                  ->onDelete('set null'); // If the case is deleted, keep request but set to null
        });
    }

    public function down(): void {
        Schema::table('request_calls', function (Blueprint $table) {
            $table->dropForeign(['incident_case_id']);
            $table->dropColumn('incident_case_id');
        });
    }
};
