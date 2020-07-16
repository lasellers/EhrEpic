<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Routing\Middleware\ThrottleRequests;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** Hard Deleted */
    public const DELETE_TYPE_HARD = "Hard";
    /* Eloquent Soft deletes */
    public const DELETE_TYPE_SOFT = "Soft";

    /*
    protected function setUp(): void
    {
        parent::setup();
        // disable "429 Too Many Attempts" error because of throttle middleware
        $this->withoutMiddleware(
            ThrottleRequests::class
        );
    }

    protected function tearDown(): void
    {
        // \Mockery::close();

        parent::tearDown();
    }*/

}
