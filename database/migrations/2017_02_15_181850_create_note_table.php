<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order');
            $table->unsignedInteger('user');
            $table->string('note', 750);
            $table->timestamps();
            $table->foreign('order')
                  ->references('id')->on('orders')
                  ->onDelete('cascade');
            $table->foreign('user')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
        DB::statement('alter table notes add fulltext note(note)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
