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
        Schema::create('post_reactions', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->integer('reacted_by')->unsigned();
            $table->foreign('reacted_by')->references('id')->on('users')->cascadeOnDelete();
            $table->integer('reaction_id')->unsigned();
            $table->foreign('reaction_id')->references('id')->on('reactions')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_reactions');
    }
};
