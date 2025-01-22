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
        Schema::create('studios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('preview_text')->nullable();
            $table->text('detail_text')->nullable();

            $table->decimal('cost_training', 10, 4)->nullable();

            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            $table->string('website_link')->nullable();
            $table->string('vk_link')->nullable();

            $table->string('coordinates')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();

            $table->string('tags')->nullable();
            $table->integer('sort')->nullable()->default(1);

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
