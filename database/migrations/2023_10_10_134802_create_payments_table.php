<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10,2);
            $table->integer('items')->nullable();
            $table->decimal('debt', 10,2)->nullable();
            $table->decimal('change', 10,2)->nullable();
            $table->date('date_serv');
            $table->enum('status',['PAID','PENDING','CANCELLED'])->default('PENDING');

            /* $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers'); */

            $table->foreignId('user_id')->constrained();
            $table->foreignId('customer_id')->constrained('customers');

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
        Schema::dropIfExists('payments');
    }
}
