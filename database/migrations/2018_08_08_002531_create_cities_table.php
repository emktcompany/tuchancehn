<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->nullable()->comment('Id referencing the country a city belongs to');
            $table->integer('state_id')->unsigned()->nullable()->comment('Id referencing the state a city belongs to');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('country_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade');
            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
