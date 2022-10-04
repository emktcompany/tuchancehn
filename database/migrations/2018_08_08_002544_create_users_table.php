<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_id')->unsigned()->comment('Id referencing the country a user belongs to');
            $table->integer('state_id')->unsigned()->nullable()->comment('Id referencing the state a user belongs to');
            $table->integer('city_id')->unsigned()->nullable()->comment('Id referencing the city a user belongs to');
            $table->boolean('is_active')->default(1)->comment('Flag to determine if a user account is active');
            $table->string('name')->comment('The user full names');
            $table->string('email')->unique()->comment('The email account the user account is registered to');
            $table->string('password')->comment('Encrypted password');
            $table->rememberToken()->comment('String used as a validation token when remember me option is enabled at login');
            $table->timestamp('login_at')->nullable()->comment('Timestamp for when the user last logged in');
            $table->integer('remote_id')
                ->unsigned()
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
