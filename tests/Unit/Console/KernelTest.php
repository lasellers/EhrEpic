<?php
/*
./vendor/bin/phpunit tests/Unit/Console/KernelTest.php
*/

namespace Tests\Unit\Console;

use App\Console\Kernel;
use Illuminate\Console\Scheduling\Schedule;
use PHPUnit\Framework\TestCase;

class KernelTest extends TestCase
{
    /**
     * @test
     */
    public function temp()
    {
        $this->assertTrue(true);
    }

    /**
     * test
     * @throws \ReflectionException
     * @todo
     */
    public function schedule()
    {
        $class = Kernel::class;

        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        $schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->addMethods(['daily'])
            ->onlyMethods(['call'])
            ->getMock();

        //
        $schedule->expects($this->exactly(4))
            ->method('call')
            ->will($this->returnSelf());

        $schedule->expects($this->exactly(1))
            ->method('daily');

        //
        $method = new \ReflectionMethod($class, 'schedule');
        $method->setAccessible(true);
        $result = $method->invoke($mock, $schedule);

        $this->assertNull($result);
    }
}
