<?php

namespace Tests\Feature;

use App\BowlingKata;
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
    public function it_scores_a_zero_game_as_a_gutter()
    {
        $this->rollTimes(20, 0);

        $this->assertEquals(0, $this->game->score());
    }

    /** @test */
    public function it_scores_a_sum_of_knock_down_pins_for_a_game()
    {
        $this->roll(2);
        $this->roll(3);
        $this->roll(5);

        $this->rollTimes(17, 0);


        $this->assertEquals(10, $this->game->score());
    }

    /** @test */
    public function it_awards_a_one_bonus_roll_for_a_spare()
    {
        $this->rollSpare();
        $this->roll(5);

        $this->rollTimes(17, 0);


        $this->assertEquals(20, $this->game->score());
    }

    /** @test */
    public function it_awards_a_two_rolls_bonus_for_a_strike()
    {
        $this->rollStrike();
        $this->roll(3);
        $this->roll(5);

        $this->rollTimes(17, 0);


        $this->assertEquals(26, $this->game->score());
    }

    /** @test */
    public function it_scores_a_perfect_game()
    {
        $this->rollTimes(12, 10);

        $this->assertEquals(300, $this->game->score());
    }


    private function roll($pins)
    {
        return $this->game->roll($pins);
    }


    /**
     * @param $times
     * @param $pins
     */
    private function rollTimes($times, $pins)
    {
        for ($i = 0; $i < $times; $i++) {
            $this->roll($pins);
        }
    }

    private function rollSpare()
    {
        $this->roll(7);
        $this->roll(3);
    }

    private function rollStrike()
    {
        $this->roll(10);
    }
}
