<?php

use Illuminate\Database\Seeder;
use App\Models\Condition;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Condition::create([
            'patient_id' => 1,
            'display' => 'Some condition'
        ]);
        Condition::create([
            'patient_id' => 1,
            'display' => 'Some condition #2'
        ]);
        Condition::create([
            'patient_id' => 1,
            'display' => 'Some condition #3'
        ]);
        Condition::create([
            'patient_id' => 2,
            'display' => 'Some condition'
        ]);
        Condition::create([
            'patient_id' => 3,
            'display' => 'Some condition'
        ]);
    }
}
