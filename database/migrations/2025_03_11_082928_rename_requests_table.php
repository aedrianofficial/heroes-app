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
         // Rename 'requests' table to 'request_calls'
         Schema::rename('requests', 'request_calls');

         // Rename 'request_agency' pivot table to 'request_call_agency'
         Schema::rename('request_agency', 'request_call_agency');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('request_calls', 'requests');
        Schema::rename('request_call_agency', 'request_agency');
    }
};
