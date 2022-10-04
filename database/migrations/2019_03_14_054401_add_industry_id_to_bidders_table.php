<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndustryIdToBiddersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bidders', function (Blueprint $table) {
            $table->integer('interest_id')
                ->unsigned()
                ->nullable();
            $table->foreign('interest_id')
                ->references('id')
                ->on('interests')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bidders', function (Blueprint $table) {
            $table->dropForeign('bidders_interest_id_foreign');
            $table->dropColumn('interest_id');
        });
    }
}
