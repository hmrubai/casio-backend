<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->text('description')->nullable();
            $table->text('description_bn')->nullable();
            $table->bigInteger('class_id');
            $table->bigInteger('chapter_id');
            $table->bigInteger('created_by')->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_details')->nullable();
            $table->text('raw_url')->nullable();
            $table->text('s3_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->text('download_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->float('duration')->default(0.00);
            $table->float('rating')->default(0.00);
            $table->integer('sequence')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topics');
    }
}
