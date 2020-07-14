<?php

use Illuminate\Database\Seeder;

//use PatientSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             PatientSeeder::class,
             PractitionerSeeder::class,
             ProcedureSeeder::class,
             ConditionSeeder::class,
             DeviceSeeder::class,
             CommentSeeder::class,
             PatientPractitionerSeeder::class,
         ]);
    }
}
