<?php
/*
./vendor/bin/phpunit tests/Integration/TablesTest.php
*/

namespace Tests\Integration\Controller\TablesTest;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TablesTest extends TestCase

{
    use DatabaseTransactions;

    public function testTablePatients()
    {
        $this->assertDatabaseHas('patients', [
            'family' => 'Argonaut',
        ]);
    }

}
