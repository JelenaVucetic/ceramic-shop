<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();;
            $table->foreign("user_id")
                ->references("id")
                ->on("user")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->double('price');
            $table->enum('payment_status', ['not submitted', 'payment processing', 'payment successful', 'payment unsuccessful']);
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
        Schema::drop('order');
    }
}
