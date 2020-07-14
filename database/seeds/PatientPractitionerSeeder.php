<?php

use Illuminate\Database\Seeder;

use App\Models\PatientPractitioner;

class PatientPractitionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PatientPractitioner::create([
            'patient_id' => 1,
            'practitioner_id' => 1
        ]);
        PatientPractitioner::create([
            'patient_id' => 2,
            'practitioner_id' => 1
        ]);
        PatientPractitioner::create([
            'patient_id' => 3,
            'practitioner_id' => 2
        ]);
        PatientPractitioner::create([
            'patient_id' => 4,
            'practitioner_id' => 2
        ]);
    }
}
