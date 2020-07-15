<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** Hard Deleted, deleted!=0 */
    public const DELETE_TYPE_HARD = "Hard";
    /* Eloquent Soft deletes */
    public const DELETE_TYPE_SOFT = "Soft";

}
