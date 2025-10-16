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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('isbn')->unique();
            $table->text('description')->nullable();
            $table->foreignId('auther_id')->constrained('authers')->cascadeOnDelete();
            $table->string('genre')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);
            $table->decimal('price',10,2)->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status',['available','unavailable'])->default('available');
            $table->timestamps();

            // for searching
            $table->index(['title','auther_id']);
            $table->index('isbn');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
