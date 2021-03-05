<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisings', function (Blueprint $table){
            $table->increments('id');
            $table->longText('link');
            $table->longText('title');
            $table->string('price')->nullable();
            $table->string('area')->nullable();
            $table->longText('details')->nullable();
            $table->string('finishing')->nullable();
            $table->string('rooms')->nullable();
            $table->string('floor')->nullable();
            $table->string('type')->nullable();
            $table->string('supplier_name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('supplier_advertisings_count')->nullable();
            $table->string('website_name')->default('olx');
            $table->string('advertisings_date');
            
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
        Schema::dropIfExists('advertisings');
    }
}
