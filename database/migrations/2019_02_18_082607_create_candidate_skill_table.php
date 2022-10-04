<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_skill', function (Blueprint $table) {
            $table->integer('candidate_id')->unsigned();
            $table->integer('skill_id')->unsigned();
            $table->integer('weight')->unsigned();
            $table->foreign('candidate_id')
                ->references('id')
                ->on('candidates')
                ->onDelete('cascade');
            $table->foreign('skill_id')
                ->references('id')
                ->on('skills')
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
        Schema::dropIfExists('candidate_skill');
    }
}
