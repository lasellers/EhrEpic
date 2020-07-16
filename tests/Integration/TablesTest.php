<?php
/*
./vendor/bin/phpunit tests/Integration/TablesTest.php
*/

namespace Tests\Integration\Controller;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TablesTest extends TestCase

{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function tablePatients()
    {
        $this->assertDatabaseHas('patients', [
            'family' => 'Argonaut',
        ]);
    }

}
