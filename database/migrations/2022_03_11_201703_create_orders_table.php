<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('user_id');//or unauthenticated user?
            $table->integer('subtotal');
            $table->integer('subtotal_with_coupon');
            $table->string('coupon_value');//coupon name, type, value
            $table->integer('shipping_fee');
            $table->integer('total');
            //$table->integer('status')->default(1); //ordered, delivered, canceled
            $table->string('payment_type');//cod or card or paypal
            //COD: pending, approved, declined, paid  ///  card/paypal: paid, refunded
            $table->string('payment_status');
            $table->dateTime('paid_on')->nullable();//paid by cart/paypal: now(), paid by cod :updated when paid
            $table->dateTime('shipped_on')->nullable();//
            $table->string('shipping_status')->default('pending');//pending, preparing, waiting for courier, in transit, returned, canceled
            $table->unsignedBigInteger('contacted_by')->nullable();//if cod and if user is not registered, call user first
            $table->text('admin_comment')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
