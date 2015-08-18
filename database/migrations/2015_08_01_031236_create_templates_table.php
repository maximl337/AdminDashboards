<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price');
            $table->integer('price_multiple')->nullable();
            $table->integer('price_extended')->nullable();
            $table->string('version')->nullable();
            $table->text('description');
            $table->string('screenshot');
            $table->string('preview_url');
            $table->string('files_url');
            $table->integer('user_id')->unsigned();
            $table->boolean('exclusive')->default(false);
            $table->boolean('approved')->default(false);
            $table->boolean('rejected')->default(false);
            $table->boolean('disabled')->default(false);
            $table->timestamps();
        });

        Schema::table('templates', function (Blueprint $table) {

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('templates');
    }
}
