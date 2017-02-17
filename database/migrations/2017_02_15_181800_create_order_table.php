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
            $table->string('entry', 25)->nullable()->default(null);
            $table->unsignedSmallInteger('type')->default(0);
            $table->string('name', 100)->default('');
            $table->string('email', 100)->default('');
            $table->string('paypal_name', 100)->default('');
            $table->unsignedSmallInteger('clicks')->default(0);
            $table->boolean('put_on_top')->default(0);
            $table->dateTime('date_submitted')->nullable()->default(null);
            $table->string('url', 250)->default('');
            $table->string('stats', 250)->default('');
            $table->boolean('in_rotator')->default(0);
            $table->unsignedSmallInteger('clicks_sent')->default(0);
            $table->unsignedSmallInteger('optins')->default(0);
            $table->boolean('followup_sent')->default(0);
            $table->string('screenshot', 250)->default('');
            $table->unsignedTinyInteger('priority')->default(0);
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
