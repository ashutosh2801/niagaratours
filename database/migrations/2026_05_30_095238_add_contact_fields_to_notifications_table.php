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
        Schema::table('notifications', function (Blueprint $table) {
            if (! Schema::hasColumn('notifications', 'name')) {
                $table->string('name')->nullable();
            }

            if (! Schema::hasColumn('notifications', 'email')) {
                $table->string('email')->nullable();
            }

            if (! Schema::hasColumn('notifications', 'subject')) {
                $table->string('subject')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('notifications', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('notifications', 'subject')) {
                $table->dropColumn('subject');
            }
        });
    }
};
