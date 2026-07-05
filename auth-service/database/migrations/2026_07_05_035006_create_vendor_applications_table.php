<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Intake Form Fields
            $table->string('shop_name');
            $table->string('physical_address');
            $table->string('business_license_number');

            // The Updated State Machine Engine
            // Allowed states: pending, revision_required, approved, rejected
            $table->string('status')->default('pending'); 
            
            // Feedback loop for revisions or rejection explanations
            $table->text('admin_notes')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_applications');
    }
};