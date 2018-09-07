<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();;
            $table->foreign("user_id")
                ->references("id")
                ->on("user")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->integer('product_id')->unsigned();;
            $table->foreign("product_id")
                ->references("id")
                ->on("user")
                ->onUpdate("cascade")
                ->onDelete("cascade");

            $table->string('description');
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
        Schema::drop('comment');

    }
}
