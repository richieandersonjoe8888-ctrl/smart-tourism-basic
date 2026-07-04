<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // NOTE: The 'tags' table was already created in the previous dashboard migration,
        // so we only create the profiles and the pivot relationship table here.

        // 1. Vendor Profiles
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('picture')->nullable();
            $table->text('description')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->timestamps();
        });

        // 2. Pivot table linking Profiles to Tags
        Schema::create('tag_vendor_profile', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tag_vendor_profile');
        Schema::dropIfExists('vendor_profiles');
        // We leave 'tags' table drop logic to its original file
    }
};