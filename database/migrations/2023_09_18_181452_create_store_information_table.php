<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_information', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('store_name_bn')->nullable();
            $table->string('store_email')->nullable();
            $table->string('store_contact_no')->nullable();
            $table->string('store_address')->nullable();
            $table->string('store_trade_license')->nullable();
            $table->string('store_lat')->nullable();
            $table->string('store_long')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('division_id')->nullable();
            $table->bigInteger('thana_id')->nullable();
            $table->bigInteger('area_id')->nullable();
            $table->string('owner_name');
            $table->string('owner_email')->nullable();
            $table->string('owner_contact_no')->nullable();
            $table->string('owner_nid')->nullable();
            $table->float('rating')->default(0.00);
            $table->integer('sequence')->default(0);
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('store_information');
    }
}
