<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patientId', 64);
            $table->string('family', 132)->nullable();
            $table->string('given', 132)->nullable();
            $table->date('birthDate')->nullable();
            $table->enum('birthSex', ['female', 'male', 'other', 'unknown'])->default('unknown');
            $table->enum('sex', ['female', 'male', 'other', 'unknown'])->default('unknown');
            $table->string('address', 132)->nullable(); //latest
            $table->string('telecom', 132)->nullable(); //latest+primary
            $table->string('race', 132)->nullable();
            $table->string('ethnicity', 132)->nullable();
            $table->text('json')->default('{}');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
