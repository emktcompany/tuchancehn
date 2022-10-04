<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoteIdToOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('opportunities', function (Blueprint $table) {
            $table->integer('import_id')
                ->unsigned()
                ->nullable();
            $table->integer('subcategory_id')
                ->unsigned()
                ->nullable();
            $table->foreign('subcategory_id')
                ->references('id')
                ->on('subcategories')
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
        Schema::table('opportunities', function (Blueprint $table) {
            $table->dropForeign('opportunities_subcategory_id_foreign');
            $table->dropColumn(['subcategory_id']);
            $table->dropColumn('import_id');
        });
    }
}
