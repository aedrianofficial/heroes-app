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
        Schema::table('vehicle_requests', function (Blueprint $table) {
            $table->foreignId('incident_case_id')->nullable()->constrained('incident_cases')->onDelete('cascade')->after('vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_requests', function (Blueprint $table) {
            $table->dropForeign(['incident_id']);
            $table->dropColumn('incident_id');
        });
    }
};
