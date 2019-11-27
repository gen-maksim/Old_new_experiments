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
    public function it_scores_a_zero_for_a_gutter_game()
    {
        $this->rollTimes(20, 0);

        $this->assertEquals(0, $this->score());
    }

    /** @test */
    public function it_scores_a_sum_of_pins_knockout_in_a_game()
    {
        $this->roll(5);
        $this->roll(3);
        $this->roll(2);

        $this->rollTimes(17, 0);

        $this->assertEquals(10, $this->score());
    }


    /** @test */
    public function it_awards_a_one_roll_bonus_for_a_spare()
    {
        $this->rollSpare();
        $this->roll(2);

        $this->rollTimes(17, 0);

        $this->assertEquals(14, $this->score());
    }


    /** @test */
    public function it_awards_a_two_roll_bonus_for_a_strike()
    {
        $this->rollStrike();
        $this->roll(5);
        $this->roll(2);

        $this->rollTimes(17, 0);

        $this->assertEquals(24, $this->score());
    }


    /** @test */
    public function it_scores_a_perfect_game()
    {
        $this->rollTimes(12, 10);

        $this->assertEquals(300, $this->score());
    }

    /**
     * @param $pins
     * @return int
     */
    private function roll($pins)
    {
        return $this->game->roll($pins);
    }

    /**
     * @return mixed
     */
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
        $this->roll(5);
        $this->roll(5);//spare!
    }

    private function rollStrike(): void
    {
        $this->roll(10);//strike!
    }


}
