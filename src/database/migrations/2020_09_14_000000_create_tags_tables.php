<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTables extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->json('metadata')->nullable();
            $table->smallInteger('order_column')->nullable();
            $table->timestamps();
        });

        $columnType = config('tags.taggable_reference_uuid') ? 'uuid' : 'unsignedBigInteger';

        Schema::create('taggables', function (Blueprint $table) use ($columnType) {
            $table->uuid('tag_id');
            $table->{$columnType}('taggable_id');
            $table->string('taggable_type');
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('taggables');
        Schema::drop('tags');
    }
}
