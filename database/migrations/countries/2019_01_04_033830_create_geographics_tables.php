<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeographicsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('iso_name')->nullable();
            $table->string('iso')->nullable();
            $table->string('iso3')->nullable();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('numcode')->nullable();
            $table->unsignedInteger('region_id')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
            $table->index('name');
        });

        Schema::create('states', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->nullable();
            $table->string('name')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
            $table->index('name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('state_id')->nullable();
            $table->string('name')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
        Schema::dropIfExists('states');
        Schema::dropIfExists('cities');
    }
}
