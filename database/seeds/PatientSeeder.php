<?php

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        /*
        $patient = new Patient();
        $patient->patientId='Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB';
        $patient->family='Argonaut';
        $patient->given='Jason';
        $patient->save();*/

        Patient::create([
            'patientId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'family' => 'Argonaut',
            'given' => 'Jason',
            'json'=>'{}'
        ]);
        Patient::create([
            'patientId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'family' => 'Argonaut',
            'given' => 'Jessica',
            'json'=>'{}'
        ]);
        Patient::create([
            'patientId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'family' => 'Kirk',
            'given' => 'James',
            'json'=>'{}'
        ]);
        Patient::create([
            'patientId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'family' => 'Tinsley',
            'given' => 'Daisy',
            'json'=>'{}'
        ]);

    }
}
