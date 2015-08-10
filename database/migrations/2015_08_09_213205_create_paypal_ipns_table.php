<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalIpnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_ipns', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('template_id')->unsigned();
            $table->string('licence_type')->nullable();
            $table->string('mc_gross')->nullable();
            $table->string('protection_eligibility')->nullable();
            $table->string('address_status')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('tax')->nullable();
            $table->string('address_street')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('charset')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('first_name')->nullable();
            $table->string('mc_fee')->nullable();
            $table->string('address_country_code')->nullable();
            $table->string('address_name')->nullable();
            $table->string('notify_version')->nullable();
            $table->string('payer_status')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_city')->nullable();
            $table->string('quantity')->nullable();
            $table->string('verify_sign')->nullable();
            $table->string('payer_email')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address_state')->nullable();
            $table->string('receiver_email')->nullable();
            $table->string('payment_fee')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('txn_type')->nullable();
            $table->string('item_name')->nullable();
            $table->string('mc_currency')->nullable();
            $table->string('item_number')->nullable();
            $table->string('residence_country')->nullable();
            $table->string('test_ipn')->nullable();
            $table->string('handling_amount')->nullable();
            $table->string('transaction_subject')->nullable();
            $table->string('payment_gross')->nullable();
            $table->string('shipping')->nullable();

            $table->timestamps();
        });

        Schema::table('paypal_ipns', function(Blueprint $table) {
            $table->foreign('template_id')
                    ->references('id')->on('templates');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paypal_ipns');
    }
}
