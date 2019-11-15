<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Bowling;

class BowlingTest extends TestCase
{

    public function test_that_it_can_add_score()
    {
        $bowling = new Bowling();

        $bowling->addShot(10);
        $bowling->addShot(4);
        $bowling->addShot(6);
        $bowling->addShot(4);
        $bowling->addShot(0);
        $bowling->addShot(10);
        $bowling->addShot(7);
        $bowling->addShot(3);
        $bowling->addShot(10);


        $this->assertEquals(78, $bowling->getScore());
    }

    public function test_that_it_can_push_to_frame()
    {
        $bowling = new Bowling();

        $bowling->pushToFrame(5);
        $bowling->pushToFrame(3);
        $bowling->pushToFrame(10);
        $bowling->pushToFrame(8);

        $this->assertEquals([[5,3],[10],[8]], $bowling->getFrames());
    }

    public function test_that_it_can_check_frame()
    {
        $bowling = new Bowling();

        $bowling->pushToFrame(10);
        $bowling->pushToFrame(10);


        $this->assertEquals(true, $bowling->frameIsOpened());
    }

    public function test_that_it_can_push_score_and_create_frame()
    {
        $bowling = new Bowling();

        $bowling->pushToFrame(10);
        $bowling->pushToFrame(5);
        $bowling->pushToFrame(3);
        $bowling->pushToFrame(3);
        

        $this->assertEquals(true, $bowling->frameIsOpened());
        $this->assertEquals(8, $bowling->getScore());
    }

    public function test_that_it_can_push_to_strike()
    {
        $bowling = new Bowling();
        
        $bowling->pushToStrike();
        
        $this->assertEquals([[
            'count' => 2,
            'subtotal' => 10,
        ]], $bowling->getStrikes());
    }

    public function test_that_it_can_count_strikes()
    {
        $bowling = new Bowling();

        $bowling->pushToStrike();
        $bowling->checkStrike(5);

        $this->assertEquals([[
            'count' => 1,
            'subtotal' => 15,
        ]], $bowling->getStrikes());

        $bowling->checkStrike(3);

        $this->assertEquals(18, $bowling->getScore());
        $this->assertEquals([[
            'count' => 0,
            'subtotal' => 18,
        ]], $bowling->getStrikes());
    }

    public function test_that_it_can_count_spares()
    {
        $bowling = new Bowling();

        $bowling->pushToSpare();
        $bowling->checkStrike(5);

        $this->assertEquals([[
            'count' => 0,
            'subtotal' => 15,
        ]], $bowling->getStrikes());

        $bowling->checkStrike(3);

        $this->assertEquals(15, $bowling->getScore());
        $this->assertEquals([[
            'count' => -1,
            'subtotal' => 18,
        ]], $bowling->getStrikes());
    }
}
