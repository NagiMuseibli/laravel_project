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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->integer('kod')->unique();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('client_id');
            $table->float('faiz');
            $table->float('depozit');
            $table->float('miqdar');
            $table->float('muddet');
            $table->integer('ay')->nullable();
            $table->integer('tesdiq');
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
        Schema::dropIfExists('credits');
    }
};
