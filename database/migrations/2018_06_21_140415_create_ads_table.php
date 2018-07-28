<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration {

   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up() {
      Schema::create('ads', function (Blueprint $table) {
         $table->increments('id');
         $table->unsignedTinyInteger("category_id");
         $table->unsignedTinyInteger("ads_type");
         $table->unsignedMediumInteger("price")->default(0);
         $table->string("title", 255);
         $table->mediumText('description')->nullable($value = true);
         $table->string("email", 50);
         $table->tinyInteger("receive_email");
         $table->string('website', 100)->nullable($value = true);
         $table->string('phone', 30)->nullable($value = true);
         $table->string('postal_code', 30)->nullable($value = true);
         $table->tinyInteger("item_type")->default(1);
         $table->tinyInteger('commercial')->default(1);
         $table->tinyInteger('status')->default(1);
         $table->unsignedSmallInteger('city_id');
         $table->unsignedMediumInteger('visited')->default(0);
         $table->string('picture1', 4)->nullable($value = true);
         $table->string('picture2', 4)->nullable($value = true);
         $table->string('picture3', 4)->nullable($value = true);
         $table->string('picture4', 4)->nullable($value = true);
         $table->unsignedInteger("customer_id");
         $table->date("post_date")->nullable($value = true);
         $table->unsignedInteger("first_ad")->default(0);
         $table->foreign('category_id')->references('id')->on('categories');
         $table->foreign('city_id')->references('id')->on('cities');
         $table->foreign('customer_id')->references('id')->on('customers');
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down() {
      Schema::dropIfExists('ads');
   }

}
