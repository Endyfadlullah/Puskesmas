<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added this import for DB facade

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->foreignId('poli_id')->after('user_id')->nullable()->constrained('polis')->onDelete('cascade');
        });

        // Update existing records to have poli_id based on user's poli
        DB::statement('UPDATE antrians SET poli_id = (SELECT poli_id FROM users WHERE users.id = antrians.user_id)');

        // Make poli_id not nullable after updating existing data
        Schema::table('antrians', function (Blueprint $table) {
            $table->foreignId('poli_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropForeign(['poli_id']);
            $table->dropColumn('poli_id');
        });
    }
};
