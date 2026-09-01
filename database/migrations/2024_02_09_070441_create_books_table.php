<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('binding_type_id');
            $table->unsignedBigInteger('condition_id');
            $table->string('binding');
            $table->string('name');
            $table->text('title_long');
            $table->string('isbn')->nullable();
            $table->string('isbn13')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->nullable();
            $table->string('edition')->nullable();
            $table->string('pages')->nullable();
            $table->string('dimensions')->nullable();
            $table->text('image')->nullable();
            $table->text('synopsis')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('original_price', 8, 2)->nullable();
            $table->decimal('offer', 8, 2)->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('books');
    }
};
