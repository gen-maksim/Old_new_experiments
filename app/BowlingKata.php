<?php

namespace App;


class BowlingKata
{

    //10 frames
    //1 or 2 shot per frame 20 shots
    //spare = 10 + next shot
    //strike = 10 + next + next
    protected $rolls = [];


    public function roll($pins)
    {
        $this->rolls[] = $pins;
    }

    /**
     * @return int
     */
    public function score()
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++)
        {
            if ($this->isStrike($roll))
            {
                $score += 10 + $this->getStrikeBonus($roll);
                $roll += 1;
            }
            elseif ($this->isSpare($roll))
            {
                $score += 10 + $this->getSpareBonus($roll);
                $roll += 2;
            }

            else
            {
                $score += $this->getDefaultFrameScore($roll);
                $roll += 2;
            }

        }

        return $score;
    }

    /**
     * @param int $roll
     * @return bool
     */
    private function isSpare(int $roll): bool
    {
        return $this->getDefaultFrameScore($roll) == 10;
    }

    /**
     * @param int $roll
     * @return bool
     */
    private function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] == 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getStrikeBonus(int $roll)
    {
        return ($this->rolls[$roll + 1] + $this->rolls[$roll + 2]);
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getSpareBonus(int $roll)
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getDefaultFrameScore(int $roll)
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }
}