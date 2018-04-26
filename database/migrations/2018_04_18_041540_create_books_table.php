<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('image');
            $table->string('price');
            $table->string('promotion_price')->nullable();
            $table->string('highlights')->nullable();
            $table->longtext('description')->nullable();
            $table->string('quantity')->nullable();
            $table->integer('id_category')->unsigned();
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('id_author')->unsigned();
            $table->foreign('id_author')->references('id')->on('authors')->onDelete('cascade');
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
}
