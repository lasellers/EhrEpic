<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Log;
use ReflectionMethod;
use ReflectionProperty;
use Tests\CreatesApplication;
use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use PHPUnit\Framework\Constraint\IsInstanceOf;

trait TestCaseProtected
{
    public function getProperty($instance, $property): ReflectionProperty
    {
        $property = new \ReflectionProperty(get_class($instance), $property);
        $property->setAccessible(true);
        return $property;
    }

    public function getMethod($instance, $method): ReflectionMethod
    {
        $method = new \ReflectionMethod(get_class($instance), $method);
        $method->setAccessible(true);
        return $method;
    }

    public function getMocked($class, $methods = [])
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

}
