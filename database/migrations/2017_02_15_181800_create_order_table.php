<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
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
            $table->unsignedInteger('payment');
            $table->string('entry', 10);
            $table->unsignedSmallInteger('type');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('paypal_name', 100);
            $table->smallInteger('clicks');
            $table->boolean('put_on_top');
            $table->dateTime('date_submitted');
            $table->string('url', 250);
            $table->string('stats', 250);
            $table->boolean('in_rotator');
            $table->smallInteger('clicks_sent');
            $table->smallInteger('optins');
            $table->boolean('followup_sent');
            $table->string('screenshot');
            $table->unsignedSmallInteger('status');
            $table->timestamps();
            $table->foreign('payment')
                  ->references('id')->on('payments')
                  ->onDelete('cascade');
            $table->foreign('type')
                  ->references('id')->on('order_types')
                  ->onDelete('cascade');
            $table->foreign('status')
                  ->references('id')->on('order_statuses')
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
        Schema::dropIfExists('orders');
    }
}
