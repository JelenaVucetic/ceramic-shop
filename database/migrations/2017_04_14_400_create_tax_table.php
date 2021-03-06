<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_id')->unsigned();;
            $table->foreign("product_id")
                ->references("id")
                ->on("product")
                ->onUpdate("cascade")
                ->onDelete("cascade");



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
        Schema::drop('tax');
    }
}
