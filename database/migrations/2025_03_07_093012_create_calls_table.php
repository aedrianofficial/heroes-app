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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();   
            $table->string('caller_contact');
            $table->timestamp('call_time')->useCurrent();
            $table->enum('verified_status', ['Verified', 'Guest'])->default('Guest');
            $table->boolean('agency_notified')->default(false);
            $table->timestamps();
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
