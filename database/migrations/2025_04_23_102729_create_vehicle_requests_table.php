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
        Schema::create('vehicle_requests', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('requested_by')->nullable()->constrained('users')->onDelete('set null'); // Foreign key to users table
            $table->string('vehicle_type', 100);
            $table->integer('quantity');
            $table->text('location');
            $table->text('reason');
            $table->enum('priority', ['Low', 'Medium', 'High']);
            $table->enum('status', ['Pending', 'Approved', 'Dispatched', 'Completed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_requests');
    }
};
