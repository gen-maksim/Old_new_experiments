<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bowling extends Model
{
    protected $score;
    protected $strikes = [];
    protected $frame = [[]];


    public function addShot($shot) {
        $this->checkStrike($shot);
        $this->pushToFrame($shot);
    }


    public function getFrames()
    {
        return $this->frame;
    }

    public function getLastFrame()
    {
        return $this->frame[count($this->frame) - 1];
    }

    public function getScore() {
        return $this->score;
    }

    public function getStrikes()
    {
        return $this->strikes;
    }


    public function CreateFrame()
    {
        $this->frame[] = [];
    }

    public function frameIsOpened()
    {
        return (count($this->getLastFrame()) < 2 and array_sum($this->getLastFrame()) < 10);
    }

    public function checkStrike($shot)
    {
        for ($key = 0; $key < count($this->strikes); $key++) {
            $this->strikes[$key]['count']--;
            $this->strikes[$key]['subtotal'] += $shot;
            if ($this->strikes[$key]['count'] == 0) {
                $this->score += $this->strikes[$key]['subtotal'];
            }
        }
    }

    public function pushToFrame($shot)
    {
        array_push($this->frame[count($this->frame) - 1], $shot);
        if (!$this->frameIsOpened() or $shot == 10){
            if (array_sum($this->getLastFrame()) < 10) {
                $this->score += array_sum($this->getLastFrame());
            } else {
                count($this->getLastFrame()) === 2 ? $this->pushToSpare() : $this->pushToStrike();
            }
            $this->CreateFrame();
        }
    }

    public function pushToStrike() {
        $this->strikes[] = [
            'count' => 2,
            'subtotal' => 10,
        ];
    }

    public function pushToSpare() {
        $this->strikes[] = [
            'count' => 1,
            'subtotal' => 10,
        ];
    }
}
