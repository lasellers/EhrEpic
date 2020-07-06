<?php
/*
./vendor/bin/phpunit tests/Unit/Model/PatientTest.php
*/

namespace Tests\Unit\Model;

use App\Patient;
use Tests\TestCase;
use Tests\TestClassDataProvider;

class PatientTest extends TestCase
{
    protected $modelClassName = Patient::class;

    use TestClassDataProvider;

    const UNIT_EXPECTED_STRING = "lorem ipsum";

    /**
     * @test
     */
    public function temp()
    {
        $this->assertTrue(true);
    }
}
