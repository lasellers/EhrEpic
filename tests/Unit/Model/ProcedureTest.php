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

}
