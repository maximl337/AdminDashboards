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
            $table->string('sender_batch_id');
            $table->string('sender_item_id');
            $table->string('payout_batch_id')->nullable();
            $table->string('payout_item_id')->nullable();
            $table->string('batch_status')->nullable();
            $table->string('trasaction_id')->nullable();
            $table->string('transaction_status')->nullable();
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
