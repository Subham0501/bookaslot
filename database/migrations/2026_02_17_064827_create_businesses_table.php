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
        Schema::create('businesses', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            
            // 👤 Profile Management
            $table->string('business_name');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            
            // 📍 Contact & Location
            $table->string('address')->nullable();
            $table->string('google_maps_link')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->boolean('show_call_button')->default(true);
            $table->boolean('show_email_button')->default(true);
            $table->boolean('show_whatsapp_button')->default(true);
            $table->text('whatsapp_message_template')->nullable();
            
            // 🔗 Social Media
            $table->json('social_links')->nullable(); // Facebook, Instagram, TikTok, etc.
            
            // 🎨 Appearance / Theme Settings
            $table->string('theme')->default('light'); // light, dark, minimal
            $table->string('primary_color')->default('#ff6b6b');
            $table->string('font_style')->default('sans');
            $table->string('layout')->default('modern');
            
            // 📄 Footer Management
            $table->text('footer_about')->nullable();
            $table->string('copyright_text')->nullable();
            $table->boolean('show_map_preview')->default(true);
            
            // 🔐 Subscription Management
            $table->string('plan')->default('basic'); // basic, premium
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
