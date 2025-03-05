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
        Schema::create('status_log_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained()->onDelete('cascade'); // Link to messages table
            $table->foreignId('status_id')->constrained()->onDelete('cascade'); // Link to statuses table
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Who updated?
            $table->text('log_details'); // Log message (e.g., "The team is going", "One person died")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_log_messages', function (Blueprint $table) {
            //
        });
    }
};
