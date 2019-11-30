<?php

namespace App;


class BowlingKata
{

    //10 frames
    //1 or 2 shot per frame 20 shots
    //spare = 10 + next shot
    //strike = 10 + next + next
    protected $rolls;

    public function roll($pins)
    {
        if ($pins >= 0) {
            $this->rolls[] = $pins;
        } else {
            $this->rolls[] = 0;
        }
    }

    public function score()
    {
        $score = 0;
        $roll = 0;

        for ($i = 0; $i < 10; $i++)
        {
            if ($this->isStrike($roll)) {
                $score += $this->getStrikeBonusScore($roll);
                $roll += 1;
            }
            elseif ($this->isSpare($roll))
            {
                $score += $this->getSpareBonusScore($roll);
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
    private function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] == 10;
    }

    /**
     * @param int $roll
     * @return bool
     */
    private function isSpare(int $roll): bool
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1] == 10;
    }

    /**
     * @param int $roll
     * @return mixed
     */
    private function getDefaultFrameScore(int $roll)
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getSpareBonusScore(int $roll): int
    {
        return 10 + $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return int
     */
    private function getStrikeBonusScore(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }
}