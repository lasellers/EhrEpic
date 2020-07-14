<?php

use Illuminate\Database\Seeder;
use App\Models\Procedure;

class ProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Procedure::create([
            'patient_id' => 1,
            'display' => 'Some procedure'
        ]);
        Procedure::create([
            'patient_id' => 1,
            'display' => 'Some procedure #2'
        ]);
        Procedure::create([
            'patient_id' => 1,
            'display' => 'Some procedure #3'
        ]);
        Procedure::create([
            'patient_id' => 2,
            'display' => 'Some procedure'
        ]);
    }
}
