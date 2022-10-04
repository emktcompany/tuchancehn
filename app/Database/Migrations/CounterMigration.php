<?php

namespace App\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

abstract class CounterMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->_table_name, function (Blueprint $table) {
            collect($this->_counters)
                ->each(function ($counter) use ($table) {
                    $table->integer($counter)
                        ->unsigned()
                        ->default(0);
                });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->_table_name, function (Blueprint $table) {
            $table->dropColumn($this->_counters);
        });
    }
}
