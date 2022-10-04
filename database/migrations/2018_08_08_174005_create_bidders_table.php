<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiddersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                ->comment('Nombre.');
            $table->string('slug')
                ->comment('Nombre de Oferente para utilizar url friendly.');
            $table->string('phone')
                ->nullable()
                ->comment('Número de Teléfono.');
            $table->string('cell_phone')
                ->nullable()
                ->comment('Número de Teléfono Celular.');
            $table->string('web')
                ->nullable()
                ->comment('Pagina Web.');
            $table->text('services')
                ->nullable()
                ->comment('Servicios.');
            $table->text('description')
                ->nullable()
                ->comment('Descripción.');
            $table->text('summary')
                ->nullable()
                ->comment('Resumen.');
            $table->boolean('is_active')->default(0);
            $table->integer('user_id')
                ->unsigned()
                ->nullable()
                ->comment('Identificador de Referencia con relacion de Usuario.');
            $table->integer('country_id')
                ->unsigned()
                ->comment('Identificador de Referencia con relacion de País.');
            $table->integer('state_id')
                ->unsigned()
                ->nullable()
                ->comment('Identificador de Referencia con relacion de Departamento.');
            $table->integer('city_id')
                ->unsigned()
                ->nullable()
                ->comment('Identificador de Referencia con relacion de Ciudad.');
            $table->integer('remote_id')
                ->unsigned()
                ->nullable();
            $table->timestamp('active_since')->nullable()->index();
            $table->timestamp('last_published_at')->nullable()->index();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidders');
    }
}
