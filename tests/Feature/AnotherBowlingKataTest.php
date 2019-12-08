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
   public function it_scores_zero_for_a_gutter_game()
   {
       $this->rollTimes(20, 0);

       $this->assertEquals(0, $this->score());
   }


   /** @test */
   public function it_scores_a_sum_of_knocked_down_pins()
   {
       $this->roll(5);
       $this->roll(4);
       $this->roll(1);

       $this->rollTimes(17, 0);

       $this->assertEquals(10, $this->score());
   }


   /** @test */
   public function it_awards_a_one_roll_bonus_for_a_spare()
   {
       $this->roll(5);
       $this->roll(5);//spare! 5+5+1+1
       $this->roll(1);

       $this->rollTimes(17, 0);

       $this->assertEquals(12, $this->score());
   }


   /** @test */
   public function it_awards_a_two_roll_bonus_for_a_strike()
   {
       $this->roll(10); //strike! 10 + 4 + 1 + 4 + 1
       $this->roll(4);
       $this->roll(1);

       $this->rollTimes(17, 0);

       $this->assertEquals(20, $this->score());
   }


   /** @test */
   public function it_ignore_non_valid_values()
   {
       $this->expectException(Exception::class);
       $this->roll(-10);
       $this->roll(5);
       $this->roll(100);

       $this->rollTimes(19, 0);

       $this->assertEquals(5, $this->score());
   }

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
}
