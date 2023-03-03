<?php

namespace Tests\Unit;

use App\Http\Controllers\ApplicationController;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\MockInterface;
class AndroidTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function test_checkStatusAndroidApp()
    {
        $this->instance(
            ApplicationController::class,
            Mockery::mock(ApplicationController::class, function (MockInterface $mock) {
                $mock->shouldReceive('checkStatusAndroidApp')->once();
            })
        );
        $response = $this->get('api/check-google-play-status/{id}');
        $response->successful();
    }
    public function test_updateStatus()
    {
        $this->instance(
            ApplicationController::class,
            Mockery::mock(ApplicationController::class, function (MockInterface $mock) {
                $mock->shouldReceive('changeStatusExpired')->once();
            })
        );
        $response = $this->get('api/change-status-expired/{id}');
        $response->successful();
    }
}
