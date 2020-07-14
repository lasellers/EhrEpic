<?php

use Illuminate\Database\Seeder;
use App\Models\Practitioner;

class PractitionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Practitioner::create([
            'practitionerId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'name' => 'Dr. John Smith',
            'location' => 'Knoxille, TN',
        ]);
        Practitioner::create([
            'practitionerId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'name' => 'Dr. Jackery Smith',
            'location' => 'Area 51, NM',
        ]);
        Practitioner::create([
            'practitionerId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'name' => 'Dr. Bob James',
            'location' => 'New York, NY',
        ]);
        Practitioner::create([
            'practitionerId' => 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB',
            'name' => 'DT. Jennie Carnes',
            'location' => 'Orange County, CA',
        ]);
    }
}
