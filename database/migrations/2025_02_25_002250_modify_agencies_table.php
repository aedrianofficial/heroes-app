<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->string('code')->after('name'); // Add 'code' column after 'name'
        });

        // Insert predefined agencies with their codes
        DB::table('agencies')->insert([
            ['name' => 'DEFAULT', 'code' => 'N/A'],
            ['name' => 'PNP', 'code' => 'CRIME'],
            ['name' => 'BFP', 'code' => 'FIRE'],
            ['name' => 'MDRRMO', 'code' => 'DISASTER'],
            ['name' => 'MHO', 'code' => 'HEALTH'],
            ['name' => 'COAST GUARD', 'code' => 'SEA'],
            ['name' => 'LGU', 'code' => 'GOVERNANCE'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('code'); // Remove 'code' column if rolled back
        });
    }
};
