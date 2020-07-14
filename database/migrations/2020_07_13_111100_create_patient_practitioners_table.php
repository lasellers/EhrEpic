<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientPractitionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_practitioners', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('practitioner_id');
            $table->string('patientId', 64)->nullable();
            $table->string('practitionerId', 64)->nullable();
            //$table->foreign('patient_id')->references('id')->on('practitioner');
            //$table->foreign('practitioner_id')->references('id')->on('patient');
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
        Schema::dropIfExists('patient_practitioners');
    }
}
