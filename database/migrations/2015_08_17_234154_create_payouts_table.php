<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->float('amount')->unsigned();
            $table->string('unique_id');

            $table->string('masspay_txn_id')->nullable();
            $table->string('status')->nullable();
            $table->string('mc_fee')->nullable();
            $table->string('mc_gross')->nullable();
            $table->string('reason_code')->nullable();
            $table->timestamps();
            
        });

        Schema::table('payouts', function (Blueprint $table) {

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payouts');
    }
}
