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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_case_id')->constrained()->onDelete('cascade');
            $table->string('report_number')->unique();
            $table->foreignId('generated_by')->constrained('users')->onDelete('cascade');
            $table->text('resolution_details')->nullable();
            $table->timestamp('resolution_date');
            $table->string('report_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
