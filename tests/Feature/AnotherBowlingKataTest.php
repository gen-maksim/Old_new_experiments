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
    public function it_scores_zero_in_a_gutter_game()
    {

        for ($i = 0; $i < 20; $i++)
        {
            $this->game->roll(0);
        }

        $this->assertEquals(0, $this->game->score());
    }

    /** @test */
    public function it_scores_a_sum_of_knocked_down_pins_in_a_game()
    {
        $this->game->roll(1);
        $this->game->roll(5);
        $this->game->roll(3);


        $this->rollTimes(17, 0);

        $this->assertEquals(9, $this->game->score());
    }

    /** @test */
    public function is_awards_a_one_roll_bonus_for_a_spare()
    {
        $this->rollSpare();
        $this->game->roll(3);


        $this->rollTimes(17, 0);

        $this->assertEquals(16, $this->game->score());
    }

    /** @test */
    public function is_awards_a_two_rolls_bonus_for_a_strike()
    {
        $this->rollStrike();
        $this->game->roll(5);
        $this->game->roll(3);


        $this->rollTimes(17, 0);

        $this->assertEquals(26, $this->game->score());
    }

    /** @test */
    public function is_scores_a_perfect_game()
    {
        $this->rollTimes(12, 10);

        $this->assertEquals(300, $this->game->score());
    }

    /** @test */
    public function it_forbid_negative_rolls()
    {
        $this->game->roll(-10);

        $this->rollTimes(19, 0);

        $this->assertEquals(0, $this->game->score());
    }

    private function rollTimes($times, $pins)
    {
        for ($i = 0; $i < $times; $i++) {
            $this->game->roll($pins);
        }
    }

    private function rollStrike(): void
    {
        $this->game->roll(10);
    }

    private function rollSpare(): void
    {
        $this->game->roll(5);
        $this->game->roll(5);//spare! 10 + 3 + 3
    }
}
