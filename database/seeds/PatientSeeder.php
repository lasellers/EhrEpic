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
        Patient::create([
            'patientId' => 'abc',
            'family' => 'Unknown',
            'given' => 'Abe',
            'json'=>'{}'
        ]);
        Patient::create([
            'patientId' => 'abc2',
            'family' => 'Unknown',
            'given' => 'Abe2',
            'json'=>'{}'
        ]);
        Patient::create([
            'patientId' => 'abc3',
            'family' => 'Unknown',
            'given' => 'Abe3',
            'json'=>'{}'
        ]);

        /*
         *         \DB::table('patients')->insert([
            ['patientId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB', 'family' => 'Argonaut', 'given' => 'Jason', json=>'{}'],
            ['patientId' => 'TUKRxL29bxE9lyAcdTIyrWC6Ln5gZ-z7CLr2r-2SY964B', 'family' => 'Argonaut', 'given' => 'Jessica', json=>'{}'],
            ['patientId' => 'ToHDIzZiIn5MNomO309q0f7TCmnOq6fbqOAWQHA1FRjkB', 'family' => 'Kirk', 'given' => 'James', json=>'{}'],
        ]);

         */
    }
}
