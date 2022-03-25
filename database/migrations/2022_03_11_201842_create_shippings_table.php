<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('zip');
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('contact_person')->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
