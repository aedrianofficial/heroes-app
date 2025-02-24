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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Insert predefined agencies
        DB::table('agencies')->insert([
            ['name' => 'DEFAULT'],
            ['name' => 'PNP'],
            ['name' => 'BFP'],
            ['name' => 'MDRRMO'],
            ['name' => 'MHO'],
            ['name' => 'COAST GUARD'],
            ['name' => 'LGU'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
