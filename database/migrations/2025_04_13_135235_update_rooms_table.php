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
        Schema::table('rooms', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['room_number', 'capacity', 'status']);

            // Add new columns
            $table->string('name')->after('block_id');
            $table->enum('gender', ['male', 'female'])->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Re-add old columns
            $table->string('room_number');
            $table->integer('capacity');
            $table->string('status')->default('available');

            // Drop new columns
            $table->dropColumn(['name', 'gender']);
        });
    }
};
