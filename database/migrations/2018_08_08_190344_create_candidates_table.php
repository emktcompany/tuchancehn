<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('driver_license')
                ->default(0)
                ->comment('Posee Licencia de Conducir.');
            $table->date('birth')
                ->nullable()
                ->comment('Fecha de Nacimiento.');
            $table->string('native_language')
                ->nullable()
                ->comment('Idioma Nativo.');
            $table->string('others_language')
                ->nullable()
                ->comment('Nombre de Otros Idiomas.');
            $table->string('phone')
                ->nullable()
                ->comment('Numero de Telefono.');
            $table->string('cell_phone')
                ->nullable()
                ->comment('Numero de Telefono Celular.');
            $table->integer('years_experience')
                ->nullable()
                ->comment('Años de Experiencia.');
            $table->text('professional_objective')
                ->nullable()
                ->comment('Objetivos Profesionales.');
            $table->text('professional_area')
                ->nullable()
                ->comment('Area Profesional.');
            $table->text('professional_experience')
                ->nullable()
                ->comment('Experiencia Profesional.');
            $table->text('training_education')
                ->nullable()
                ->comment('Capacitaciones o Educacion.');
            $table->text('summary')
                ->nullable()
                ->comment('Resumen.');
            $table->text('legacy_skills')
                ->nullable()
                ->comment('Habilidades.');
            $table->text('references')
                ->nullable()
                ->comment('Referencias.');
            $table->boolean('subscription')
                ->default(0)
                ->comment('Bandera de Subscripcion a SMS y Correos Electronicos.');
            $table->boolean('privacy')
                ->default(0)
                ->comment('Privacidad de Perfil: Publico, Privado.');
            $table->boolean('gender')
                ->comment('Genero.');
            $table->text('interests')
                ->nullable()
                ->comment('Intereses.');
            $table->integer('user_id')
                ->unsigned()
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
        Schema::dropIfExists('candidates');
    }
}
