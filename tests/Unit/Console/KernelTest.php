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
     * @todo
     * @throws \ReflectionException
     */
    public function schedule()
    {
        $class = Kernel::class;

        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        $schedule = $this->getMockBuilder(Schedule::class)
            ->disableOriginalConstructor()
            ->setMethods(['call', 'everyTenMinutes', 'daily', 'everyMinute'])
            ->getMock();

        //
        $schedule->expects($this->exactly(4))
            ->method('call')
            ->will($this->returnSelf());

        $schedule->expects($this->exactly(2))
            ->method('everyTenMinutes');

        $schedule->expects($this->exactly(1))
            ->method('daily');

        $schedule->expects($this->exactly(1))
            ->method('everyMinute');

        //
        $method = new \ReflectionMethod($class, 'schedule');
        $method->setAccessible(true);
        $result = $method->invoke($mock, $schedule);

        $this->assertNull($result);
    }
}
