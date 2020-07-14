<?php

use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::create([
            'patient_id' => 1,
            'display' => 'Some device'
        ]);
        Device::create([
            'patient_id' => 1,
            'display' => 'Some device #2'
        ]);
        Device::create([
            'patient_id' => 1,
            'display' => 'Some device #3'
        ]);
        Device::create([
            'patient_id' => 2,
            'display' => 'Some device'
        ]);
        Device::create([
            'patient_id' => 3,
            'display' => 'Some device'
        ]);
    }
}
