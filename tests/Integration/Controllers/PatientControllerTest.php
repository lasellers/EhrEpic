<?php
/*
./vendor/bin/phpunit tests/Integration/Controllers/PatientControllerTest.php
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
use Tests\TestCaseAsserts;
use Tests\TestCaseAssertsCreate;
use Tests\TestCaseAssertsDelete;
use Tests\TestCaseHelpers;

class PatientControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @var EpicService */
    protected $epicService;
    /** @var PatientService */
    protected $patientService;

    /** @var PatientController */
    protected $controller;

    /** @var Patient */
    protected $patient;
    /** @var Practitioner */
    protected $practitioner;

    /** @var array */
    protected $idsPatient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->epicService = new EpicService();
        $this->patientService = new PatientService();
        $this->controller = new PatientController($this->epicService, $this->patientService);

        //
        $this->patient = factory(Patient::class)->create([
        ]);
        $this->assertInstanceOf(Patient::class, $this->patient);

        $this->idsPatient = [
            $this->patient->id
        ];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getAllPatients()
    {
        $input = [
        ];
        $request = new Request([
            $input
        ]);

        $response = $this->controller->getAllPatients($request);

        self::assertNotNull($response);
        // $this->assertInstanceOf(JsonResponse::class, $response);
        // $this->assertIsArray($response);
        // $this->assertIsArray($response);
        $this->assertInstanceOf(Collection::class, $response);
        // $items = json_decode($response->content());
        //$this->assertArrayHasKey('items', $response);
        $items = $response;
        $this->assertGreaterThanOrEqual(1, count($items));
        foreach ($items as $item) {
            // $this->assertInstanceOf(\stdClass::class, $item);
            $this->assertInstanceOf(Patient::class, $item);
        }
    }

    /**
     * @test
     */
    public function getPatient()
    {
        $id = 1;

        $response = $this->controller->getPatient($id);

        self::assertNotNull($response);
        $item = $response;
        $this->assertInstanceOf(Patient::class, $response);
        $this->assertEquals($id, $item->id);
    }

    /**
     * @test
     */
    public function createPatient()
    {
        $input = [
            'practitionerId' => 'abcd',
            'patientId' => '1234',
            'given' => 'Tests',
            'family' => 'Test'
        ];
        $request = new Request($input);

        $response = $this->controller->createPatient($request);

        self::assertNotNull($response);
        // $this->assertInstanceOf(JsonResponse::class, $response);
        // $this->assertIsArray($response);
        // $this->assertIsArray($response);
        $this->assertInstanceOf(Patient::class, $response);
        // $items = json_decode($response->content());
        //$this->assertArrayHasKey('items', $response);
    }

    /**
     * Does a live test of a valid test account.
     * @test
     */
    public function epicPatient()
    {
        $patientId = 'Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB';

        /*
        $mock = $this->getMockBuilder(EpicService::class)
            ->onlyMethods(['getPatient'])
            ->getMock();
        $mock->expects($this->once())
            ->method('getPatient')
         ; //   ->with($patientId);*/

        $response = $this->controller->epicPatient($patientId);

        self::assertNotNull($response);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('resourceType', $response);
        $this->assertEquals('Patient', $response->resourceType);
    }

    /**
     * Does a live test of an invalid account.
     * @test
     */
    public function epicPatientInvalid()
    {
        $patientId = '';

        $response = $this->controller->epicPatient($patientId);

        self::assertNotNull($response);
        $this->assertIsObject($response);

        $this->assertObjectHasAttribute('resourceType', $response);
        $this->assertEquals('Bundle', $response->resourceType);

        $this->assertObjectHasAttribute('total', $response);
        $this->assertEquals(0, $response->total);
    }

}
