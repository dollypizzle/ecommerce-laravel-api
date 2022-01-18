<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->string('name');
            // $table->string('brand');
            // $table->string('image');
            // $table->string('description');
            // $table->integer('price');
            // $table->timestamps();
            // $table->increments('id');
            $table->string('name');
            $table->string('brand');
            $table->unsignedBigInteger('owner_id');
            $table->string('image');
            $table->decimal('price');
            $table->text('description')->nullable();
            $table->timestamps();



            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
