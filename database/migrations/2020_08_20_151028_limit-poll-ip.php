<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LimitPollIp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_vote_ips', function (Blueprint $table){
           $table->bigIncrements('id');
           $table->ipAddress('ip');
           $table->string('voted_poll', 10);
           $table->timestamps();

           $table->foreign('voted_poll')->references('id')->on('polls')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('poll_vote_ips');
    }
}
