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
    public function it_scores_a_gutter_game_as_zero()
    {
        $this->rollTimes(20, 0);

        $this->assertEquals(0, $this->score());
    }

    /**
     * @param $times
     * @param $pins
     */
    private function rollTimes($times, $pins): void
    {
        for ($i = 0; $i < $times; $i++) {
            $this->roll($pins);
        }
    }

    /**
     * @return int
     */
    private function roll($pins)
    {
        return $this->game->roll($pins);
    }

    /**
     * @return int
     */
    private function score()
    {
        return $this->game->score();
    }

    /** @test */
    public function it_scores_sum_of_all_knocked_down_pins_for_a_game()
    {
        $this->rollTimes(20, 1);

        $this->assertEquals(20, $this->score());
    }

    /** @test */
    public function it_awards_a_one_roll_bonus_for_a_spare()
    {
        $this->rollSpare();
        $this->roll(5);


        $this->rollTimes(17, 0);


        $this->assertEquals(20, $this->score());
    }

    private function rollSpare(): void
    {
        $this->roll(2);
        $this->roll(8); //this is a spare
    }

    /** @test */
    public function it_awards_a_two_roll_bonus_for_a_strike()
    {
        $this->roll(10);//strike
        $this->roll(2);
        $this->roll(7);

        $this->rollTimes(17, 0);

        $this->assertEquals(28, $this->score());
    }

    /** @test */
    public function it_scores_a_perfect_game()
    {
        $this->rollTimes(12, 10);

        $this->assertEquals(300, $this->score());
    }
}
