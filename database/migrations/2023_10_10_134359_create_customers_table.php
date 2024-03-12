<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('ci', 10);
            $table->string('email', 255)->nullable();
            $table->string('phone',10)->nullable();
            $table->enum('disc',['NO','YES'])->default('NO');
            $table->string('address', 255);
            $table->string('image', 100)->nullable();
            $table->enum('status',['Active','Inactive'])->default('Active');

            $table->foreignId('location_id')->constrained();
            $table->foreignId('service_id')->constrained();

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
        Schema::dropIfExists('customers');
    }
}
