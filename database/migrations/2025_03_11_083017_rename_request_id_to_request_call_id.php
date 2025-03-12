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
        Schema::table('request_call_agency', function (Blueprint $table) {
            $table->renameColumn('request_id', 'request_call_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_call_agency', function (Blueprint $table) {
            $table->renameColumn('request_call_id', 'request_id');
        });
    }
};
