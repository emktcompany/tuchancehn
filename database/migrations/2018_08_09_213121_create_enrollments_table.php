<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id')->unsigned();
            $table->integer('opportunity_id')->unsigned();
            $table->boolean('is_accepted')->default(0); // Accepted / Denied
            $table->boolean('is_fullfilled')->default(0); // Accepted / Denied
            $table->integer('remote_id')
                ->unsigned()
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('candidate_id')
                ->references('id')
                ->on('candidates')
                ->onDelete('cascade');
            $table->foreign('opportunity_id')
                ->references('id')
                ->on('opportunities')
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
        Schema::dropIfExists('enrollments');
    }
}
