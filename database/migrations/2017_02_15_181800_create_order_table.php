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
            $table->string('entry', 25)->nullable();
            $table->unsignedSmallInteger('type')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('paypal_name', 100)->nullable();
            $table->unsignedSmallInteger('clicks')->nullable();
            $table->boolean('put_on_top')->default(0);
            $table->dateTime('date_submitted')->nullable();
            $table->string('url', 250)->nullable();
            $table->string('stats', 250)->nullable();
            $table->boolean('in_rotator')->default(0);
            $table->unsignedSmallInteger('clicks_sent')->nullable();
            $table->unsignedSmallInteger('optins')->nullable();
            $table->boolean('followup_sent')->default(0);
            $table->string('screenshot', 250)->nullable();
            $table->unsignedTinyInteger('priority')->default(0);
            $table->unsignedSmallInteger('status')->default(1);
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
