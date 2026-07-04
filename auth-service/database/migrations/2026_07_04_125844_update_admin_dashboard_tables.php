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
        // 1. Blogs Table (with moderation tracking)
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->string('status')->default('pending'); // pending, approved, disabled
            $table->text('moderation_reason')->nullable(); // Written reason for takedowns
            $table->timestamps();
        });

        // 2. Profile Reports Table (for user/vendor profile moderation)
        Schema::create('profile_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reported_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->string('reason');
            $table->string('status')->default('open'); // open, resolved
            $table->timestamps();
        });

        // 3. Tags Table & Pivot (for filtering vendors)
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., "Premium", "Local Guide", "Food"
            $table->timestamps();
        });

        Schema::create('role_user_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
        });
    }
};
