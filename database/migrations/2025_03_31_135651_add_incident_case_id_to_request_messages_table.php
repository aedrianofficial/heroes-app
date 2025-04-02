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
        Schema::table('request_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('incident_case_id')->nullable()->after('description');
            $table->foreign('incident_case_id')->references('id')->on('incident_cases')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_messages', function (Blueprint $table) {
            $table->dropForeign(['incident_case_id']);
            $table->dropColumn('incident_case_id');
        });
    }
};
