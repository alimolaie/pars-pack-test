<?php

namespace Tests\Unit;

use App\Http\Controllers\ApplicationController;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class IosTest extends TestCase
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
    public function test_checkStatusIosApp()
    {
        $this->instance(
            ApplicationController::class,
            Mockery::mock(ApplicationController::class, function (MockInterface $mock) {
                $mock->shouldReceive('checkStatusIOsApp')->once();
            })
        );
        $response = $this->get('check-app-store-status/{id}');
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
