<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('picture', 4)->nullable($value = true);
            $table->string('first_name', 30)->nullable($value = true);
            $table->string('last_name', 30)->nullable($value = true);
            $table->string('location_name', 100)->nullable($value = true);     
            $table->string('postal_code', 30)->nullable($value = true);
            $table->mediumText('description')->nullable($value = true);
            $table->string('phone', 30)->nullable($value = true);
            $table->tinyInteger('commercial_seller')->default(1);
            $table->char('password', 32);
            $table->string('auth', 50)->default(1);
            $table->string('status', 20)->nullable($value = true);
            $table->tinyInteger('type')->default(1);
            $table->unsignedSmallInteger('visited')->default(1);
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
