<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Bowling;

class BowlingTest extends TestCase
{
    /*
     * 10+ 12 22
     * 10+2 12
     * +2 2
     * 36
     * */
    /**@test
     * A basic test example.
     *
     * @return void
     */
    public function test_that_it_can_add_score()
    {
        $bowling = new Bowling();

        $bowling->addScore(10);
        $bowling->addScore(10);
        $bowling->addScore(2);

        $this->assertEquals(36, $bowling->getScore());

    }
}
