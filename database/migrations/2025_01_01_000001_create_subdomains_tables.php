<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    public function up(): void
    {
        Schema::create('subdomains', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., panel.example.com
            $table->string('title'); // e.g., Admin Panel
            $table->string('slug')->unique();
            $table->string('url');
            $table->string('short_description');
            $table->text('long_description');
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_highlighted')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subdomain_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subdomain_id')->constrained()->cascadeOnDelete();
            $table->string('image_url'); // Public URL from GCS
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subdomain_images');
        Schema::dropIfExists('subdomains');
    }
};
