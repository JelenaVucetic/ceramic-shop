<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_image', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();;
            $table->foreign("product_id")
                ->references("id")
                ->on("product")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->string('image');
            $table->boolean('main');
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
        Schema::drop('product_image');
    }
}
