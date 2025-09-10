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
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('CommentID');
            $table->integer('UserID')->sizeof(11);
            $table->integer('ProductID')->sizeof(11);
            $table->text('Comment');
            $table->integer('Rate')->range(1,5,1);
            $table->timestamps();

            $table->foreign('UserID')
                    ->references('UserID')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('ProductID')
                    ->references('ProductId')
                    ->on('products')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
