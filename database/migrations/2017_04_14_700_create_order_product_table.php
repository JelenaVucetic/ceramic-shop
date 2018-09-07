<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id')->unsigned();
            $table->foreign("order_id")
                ->references("id")
                ->on("order")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->integer('product_id')->unsigned();
            $table->foreign("product_id")
                ->references("id")
                ->on("product")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->integer('quantity');
            $table->double('price');
            $table->double('tax');
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
        Schema::drop('order_product');
    }
}
