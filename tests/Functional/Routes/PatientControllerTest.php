<?php
/*
./vendor/bin/phpunit tests/Functional/Routes/PatientControllerTest.php
*/

namespace Tests\Functional\Routes;

use App\Http\Controllers\PatientController;
use Tests\TestCase;

/**
 * These unit tests check that the specified urls map on to the expected controller class + methods.
 * Because of the router's "first thing that matches the regex" pattern matching, the ordering of
 * otherwise correct routes can short circuit to the wrong controller method.
 *
 * Class PatientControllerTest
 * @package Tests\Functional\Routes
 */
class PatientControllerTest extends TestCase
{

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function getAllPatients()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('getAllPatients')->andReturn(['items' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/patients';
        $response = $this->withoutMiddleware()
            ->json('GET', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['items']);

        \Mockery::close();
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function getPatient()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('getPatient')->andReturn(['item' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/patient/1';
        $response = $this->withoutMiddleware()
            ->json('GET', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['item']);

        \Mockery::close();
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function createPatient()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('createPatient')->andReturn(['item' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/patient';
        $response = $this->withoutMiddleware()
            ->json('POST', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['item']);

        \Mockery::close();
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function deletePatient()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('deletePatient')->andReturn(['item' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/patient/1';
        $response = $this->withoutMiddleware()
            ->json('DELETE', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['item']);

        \Mockery::close();
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function epicPatients()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('epicPatients')->andReturn(['items' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/epic/patients';
        $response = $this->withoutMiddleware()
            ->json('GET', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['items']);

        \Mockery::close();
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState false
     */
    public function epicPatient()
    {
        $mock = \Mockery::mock('overload:PatientController');
        $mock->shouldReceive('epicPatient')->andReturn(['item' => []]);
        $this->app->instance(PatientController::class, $mock);

        //
        $url = '/api/epic/patient/1';
        $response = $this->withoutMiddleware()
            ->json('GET', $url, [
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['item']);

        \Mockery::close();
    }
}
