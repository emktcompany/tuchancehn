<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('Name of the category');
            $table->string('slug')->comment('URL friendly name');
            $table->text('description')->nullable()->comment('Text describing a categorys');
            $table->boolean('is_active')->default(1)->comment('Flag to determine if a category is active (displayed)');
            $table->integer('weight')->default(0)->comment('The sorting indicator');
            $table->string('color')->nullable()->comment('The sorting indicator');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
