<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user');
            $table->unsignedBigInteger('collection');
            $table->integer('rights')->default(0);
            $table->integer('wrongs')->default(0);
            $table->dateTime('played_at')->useCurrent();
            $table->dateTime('attached_at')->useCurrent();
            $table->foreign('user')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('collection')
                ->references('id')->on('collections')
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
        Schema::dropIfExists('score');
    }
}
