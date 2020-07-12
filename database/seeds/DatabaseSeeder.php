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
             ProcedureSeeder::class,
             CommentSeeder::class,
         ]);
    }
}
