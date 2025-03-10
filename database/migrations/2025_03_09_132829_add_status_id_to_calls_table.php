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
            $table->foreignId('status_id')->default(1)->constrained()->onDelete('cascade')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calls', function (Blueprint $table) {
            //
        });
    }
};
