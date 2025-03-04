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
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('ethnicity')->nullable();
            $table->string('birth_place')->nullable();
            $table->boolean('solo_parent')->default(false);
            $table->boolean('senior_citizen')->default(false);
            $table->string('vaccine_status')->nullable();
            $table->boolean('pregnant')->default(false);
            $table->boolean('lactating')->default(false);
            $table->boolean('pwd')->default(false);
            $table->string('zone')->nullable();
            $table->string('nameofbarangay')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn([
                 'marital_status', 'religion', 'ethnicity', 'birth_place',
                'solo_parent', 'senior_citizen', 'vaccine_status', 'pregnant',
                'lactating', 'pwd', 'zone', 'nameofbarangay'
            ]);
        });
    }
};
