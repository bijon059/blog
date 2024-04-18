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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('image_url');
            $table->string('file_type');
            $table->integer('uploaded_by')->unsigned();
            $table->foreign('uploaded_by')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->unsignedInteger('comment_id')->nullable();
            $table->foreign('comment_id')->references('id')->on('comments')->cascadeOnDelete();
            $table->unsignedInteger('reply_id')->nullable();
            $table->foreign('reply_id')->references('id')->on('replies')->cascadeOnDelete();
            $table->timestamps();
            //Indexing
            $table->index('uploaded_by');
            $table->index('post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
