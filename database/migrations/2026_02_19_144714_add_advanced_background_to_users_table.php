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
        Schema::table('users', function (Blueprint $table) {
            $table->string('bg_type')->default('color')->after('bg_color');
            $table->string('bg_gradient')->nullable()->after('bg_type');
            $table->string('bg_image')->nullable()->after('bg_gradient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bg_type', 'bg_gradient', 'bg_image']);
        });
    }
};
