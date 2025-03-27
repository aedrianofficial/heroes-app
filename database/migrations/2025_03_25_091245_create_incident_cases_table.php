<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('incident_cases', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->string('case_number')->unique(); // Unique case number like "CRIME #1"
            $table->unsignedBigInteger('incident_type_id'); // Link to incident type
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('incident_cases');
    }
};
