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
     * frame
     * shot
     *
     * */
    /**@test
     * A basic test example.
     *
     * @return void
     */
    public function test_that_it_can_add_score()
    {
        $bowling = new Bowling();

        $bowling->addShot(10, 1);
        $bowling->addShot(10, 2);
        $bowling->addShot(10, 3);
        $bowling->addShot(1, 4);
//        $bowling->addShot(1, 5);
//        $bowling->addScore(2);

        $this->assertEquals(65, $bowling->getScore());
    }

//    public function test_that_it_can_count_attempts()
//    {
//        $bowling = new Bowling();
//
//        $bowling->addAttempt(1);
//    }
}
