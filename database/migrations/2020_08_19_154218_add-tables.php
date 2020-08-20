<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->string('id', 10)->primary()->unique();
            $table->string('name', 500);
            $table->boolean('finished');
            $table->timestamps();
        });

        Schema::create('poll-votes', function (Blueprint $table) {
           $table->string('id', 10)->primary()->unique();
           $table->string('name', 500);
           $table->integer('votes');
           $table->string('poll_id', 10);
           $table->timestamps();

           $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('polls');
        Schema::drop('poll-votes');
    }
}
