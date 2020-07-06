<?php
/*
./vendor/bin/phpunit tests/Unit/Coverage/ModelTest.php
*/

namespace Tests\Unit\Coverage;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tests\TestClassDataProvider;

/**
 * These tests check if known models have the modelFilter method which providers the name of the
 * model-filter class for the models filter.
 */
class ModelTest extends TestCase
{
    use TestClassDataProvider;

    /**
     * @test
     */
    public function temp()
    {
        $this->assertTrue(true);
    }

}
