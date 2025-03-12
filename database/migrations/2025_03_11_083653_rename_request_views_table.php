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
        Schema::rename('request_views', 'request_call_views');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('rename_call_views', 'request_views');
    }
};
