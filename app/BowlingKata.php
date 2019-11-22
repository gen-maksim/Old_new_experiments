<?php

namespace App;


class BowlingKata
{
    protected $rolls;

    /**
     * @param $pins
     */
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

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += 10 + $this->strikeBonus($roll);
                $roll += 1;
            } elseif ($this->isSpare($roll)) {
                $score += 10 + $this->spareBonus($roll);
                $roll += 2;
            } else {
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
     * @return mixed
     */
    private function strikeBonus(int $roll)
    {
        return ($this->rolls[$roll + 1] + $this->rolls[$roll + 2]);
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
     * @return mixed
     */
    private function getDefaultFrameScore(int $roll)
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return mixed
     */
    private function spareBonus(int $roll)
    {
        return ($this->rolls[$roll + 2]);
    }
}