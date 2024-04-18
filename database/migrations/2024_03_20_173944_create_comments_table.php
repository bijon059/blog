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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->integer('comment_by')->unsigned();
            $table->foreign('comment_by')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();

            //Indexing
            $table->index('post_id');
            $table->index('comment_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
