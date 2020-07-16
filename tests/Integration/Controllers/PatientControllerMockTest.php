<?php
/*
./vendor/bin/phpunit tests/Integration/Controllers/PatientControllerMockTest.php
*/

namespace Tests\Integration\Controllers;

use App\Http\Controllers\PatientController;
use App\Library\Services\EpicService;
use App\Library\Services\PatientService;
use App\Models\Patient;
use App\Models\Practitioner;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * // runTestsInSeparateProcesses
 * Class PatientControllerMockTest
 * @package Tests\Integration\Controllers
 */
class PatientControllerMockTest extends TestCase
{
    use DatabaseTransactions;

    /** @var EpicService */
    protected $epicService;
    /** @var PatientService */
    protected $patientService;
    /** @var PatientController */
    protected $controller;

    /**
     * Does a mocked service test
     * @test
     * @todo
     */
    public function epicPatientMock()
    {
        $this->markTestIncomplete();

        $patientId = 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB';
        $expected = (object)['resourceType' => 'Mocked'];

        //
        $this->mock = \Mockery::mock('overload:' . EpicService::class);
        $this->mock->shouldReceive('getPatient')
            ->with($patientId)
            ->andReturn($expected);
        $this->app->instance(EpicService::class, $this->mock);

        //
        $this->epicService = new EpicService();
        $this->patientService = new PatientService();
        $this->controller = new PatientController($this->epicService, $this->patientService);

        //
        $this->patient = factory(Patient::class)->create([
        ]);
        $this->assertInstanceOf(Patient::class, $this->patient);

        $response = $this->controller->epicPatient($patientId);

        self::assertNotNull($response);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('resourceType', $response);
        $this->assertEquals('Mocked', $response->resourceType);

        \Mockery::close();
    }

}
