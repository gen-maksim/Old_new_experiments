<?php

namespace Tests\Feature;

use App\BowlingKata;
use Exception;
use Tests\TestCase;

class AnotherBowlingKataTest extends TestCase
{
    protected $game;

    public function setUp(): void
    {
        parent::setUp();

        $this->game = new BowlingKata();
    }

    /** @test */
    public function it_scores_a_zero_for_a_gutter_game()
    {
        $this->rollTimes(20, 0);

        $this->assertEquals(0, $this->score());
    }


    /** @test */
    public function it_scores_a_sum_of_knocked_down_pins_for_a_game()
    {
        $this->roll(1);
        $this->roll(2);
        $this->roll(3);

        $this->rollTimes(17, 0);

        $this->assertEquals(6, $this->score());
    }



    /** @test */
    public function it_awards_a_one_roll_bonus_for_a_spare()
    {
        $this->rollSpare();
        $this->roll(3);

        $this->rollTimes(17, 0);

        $this->assertEquals(16, $this->score());
    }


    /** @test */
    public function it_award_a_two_roll_bonus_for_a_strike()
    {
        $this->rollStrike();
        $this->roll(4);
        $this->roll(3);

        $this->rollTimes(17, 0);

        $this->assertEquals(24, $this->score());
    }


    /** @test */
    public function it_scores_a_perfect_game()
    {
        $this->rollTimes(12, 10);

        $this->assertEquals(300, $this->score());
    }


    /** @test */
    public function it_skips_bad_pins_number()
    {
        $this->roll(3);
        $this->roll(-10); //bad!
        $this->roll(100); //bad!

        $this->rollTimes(19, 0);

        $this->assertEquals(3, $this->score());
    }

    //given 8 pins
    //given 7 pins
    //throw InvalidArgumentException
    //result sum of a frame can't be greater than 10.

    private function roll($pins)
    {
        return $this->game->roll($pins);
    }

    private function score()
    {
        return $this->game->score();
    }

    private function rollTimes($times, $pins)
    {
        for ($i = 0; $i < $times; $i++) {
            $this->roll($pins);
        }
    }

    private function rollSpare(): void
    {
        $this->roll(4);
        $this->roll(6);
    }

    private function rollStrike(): void
    {
        $this->roll(10);
    }
}
