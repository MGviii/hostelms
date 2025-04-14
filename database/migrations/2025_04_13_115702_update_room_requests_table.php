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
        Schema::table('room_requests', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['block_id']);
            $table->dropForeign(['room_id']);

            // Drop old columns that are no longer needed
            $table->dropColumn(['block_id', 'room_id', 'preferred_room_type', 'special_requirements']);

            // Add new columns
            $table->string('gender')->after('user_id');
            $table->integer('duration')->after('gender'); // Duration in months
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_requests', function (Blueprint $table) {
            // Re-add old columns
            $table->foreignId('block_id')->nullable()->constrained();
            $table->foreignId('room_id')->nullable()->constrained();
            $table->string('preferred_room_type')->nullable();
            $table->text('special_requirements')->nullable();

            // Drop new columns
            $table->dropColumn(['gender', 'duration']);
        });
    }
};
