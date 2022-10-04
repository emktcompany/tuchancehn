<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('summary');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->text('characteristics')->nullable();
            $table->string('link')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('bidder_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned();
            $table->dateTime('begin_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->boolean('is_active')->default(0);
            $table->boolean('allow_apply')->default(0);
            $table->integer('course_id')->unsigned()->nullable();
            $table->integer('remote_id')
                ->unsigned()
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
            $table->foreign('bidder_id')
                ->references('id')
                ->on('bidders')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::dropIfExists('opportunities');
    }
}
