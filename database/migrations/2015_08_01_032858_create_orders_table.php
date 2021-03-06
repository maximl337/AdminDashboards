<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('txn_id');
            $table->integer('template_id')->unsigned();
            $table->string('licence_type');
            $table->string('status')->default('pending');
            $table->string('email');
            $table->float('payment_gross');
            $table->float('tax');
            $table->integer('download_request_count')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {

            $table->foreign('template_id')
                    ->references('id')
                    ->on('templates');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
