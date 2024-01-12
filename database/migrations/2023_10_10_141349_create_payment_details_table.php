<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();

            $table->decimal('price', 10,2);
            $table->decimal('quantity', 10,2)->nullable();
            $table->datetime('date_pay');
            $table->string('image', 100)->nullable();

            $table->foreignId('customer_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('payment_method_id')->constrained();

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
        Schema::dropIfExists('payment_details');
    }
}
