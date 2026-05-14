<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('title');
            $table->boolean('is_enabled')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('homepage_sections')->insert([
            ['key' => 'hero', 'title' => 'Hero Slider', 'is_enabled' => true, 'sort_order' => 1],
            ['key' => 'why_choose_us', 'title' => 'Why Choose Us', 'is_enabled' => true, 'sort_order' => 2],
            ['key' => 'cta', 'title' => 'Call to Action', 'is_enabled' => true, 'sort_order' => 3],
            ['key' => 'popular_destinations', 'title' => 'Popular Destinations', 'is_enabled' => true, 'sort_order' => 4],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_sections');
    }
};
