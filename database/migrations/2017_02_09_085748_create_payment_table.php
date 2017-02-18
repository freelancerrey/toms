<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference', 100);
            $table->unsignedSmallInteger('gateway');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->decimal('amount', 8, 2);
            $table->dateTime('date');
            $table->timestamps();
            $table->unique('reference', 'payment_reference');
            $table->foreign('gateway')
                  ->references('id')->on('payment_gateways')
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
        Schema::dropIfExists('payments');
    }
}
