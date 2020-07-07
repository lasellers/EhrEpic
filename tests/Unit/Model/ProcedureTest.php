<?php
/*
./vendor/bin/phpunit tests/Unit/Model/ProcedureTest.php
*/

namespace Tests\Unit\Model;

use App\Models\Patient;
use App\Models\Procedure;
use Tests\TestCase;
use Tests\TestClassDataProvider;

class ProcedureTest extends TestCase
{
    protected $modelClassName = Procedure::class;

    use TestClassDataProvider;

    const UNIT_EXPECTED_STRING = "lorem ipsum";

    /**
     * @test
     */
    public function temp()
    {
        $this->assertTrue(true);
    }

    /**
     * test
     * @todo
     */
    public function patient()
    {
        $mock = $this->getMockBuilder($this->modelClassName)
            ->disableOriginalConstructor()
            ->setMethods(['belongsTo'])
            ->getMock();

        $mock->expects($this->once())
            ->method('belongsTo')
            ->with($this->equalTo(PatienT::class), $this->equalTo('patient_id'), $this->equalTo('id'))
            ->will($this->returnValue(self::UNIT_EXPECTED_STRING));

        $result = $mock->patient_id();
        $this->assertEquals(self::UNIT_EXPECTED_STRING, $result);
    }

}
