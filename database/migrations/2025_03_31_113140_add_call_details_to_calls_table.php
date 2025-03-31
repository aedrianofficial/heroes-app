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
        Schema::table('calls', function (Blueprint $table) {
            $table->dateTime('call_time')->nullable()->after('caller_contact');
            $table->unsignedInteger('call_duration')->nullable()->after('call_time');
            $table->string('call_audio', 255)->nullable()->after('call_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calls', function (Blueprint $table) {
            $table->dropColumn(['call_time', 'call_duration', 'call_audio']);
        });
    }
};
