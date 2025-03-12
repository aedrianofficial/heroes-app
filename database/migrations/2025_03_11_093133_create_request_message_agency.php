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
        Schema::create('request_message_agency', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_message_id');
            $table->unsignedBigInteger('agency_id');
            $table->timestamps();

            $table->foreign('request_message_id')->references('id')->on('request_messages')->onDelete('cascade');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_message_agency');
    }
};
