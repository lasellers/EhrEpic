<?php
/*
./vendor/bin/phpunit tests/Functional/Routes/PatientIndexTest.php
*/

namespace Tests\Functional\Routes;

use App\Http\Controllers\PatientController;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function PatientIndex()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('searchPatients')->andReturn(['items' => [], 'meta' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/patients';
        $response = $this->withoutMiddleware()
            ->json('GET', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['items', 'meta']);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function patientId()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('getPatient')->andReturn(['items' => [], 'meta' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/patient/1';
        $response = $this->withoutMiddleware()
            ->json('GET', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['items', 'meta']);
    }
}
