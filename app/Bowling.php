<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bowling extends Model
{
    protected $score;
    protected $strikes = [];
    protected $frame = [[]];
    protected $last_shots;

//    public function addShot($shot, $attempt_num) {
//        $come_for_strike = false;
//        for ($key = 0; $key < count($this->strikes); $key++) {
//            $come_for_strike = true;
//            $this->strikes[$key]['count']--;
//            $this->strikes[$key]['subtotal'] += $shot;
//            dump($attempt_num);
//            dump($this->strikes);
//            if ($this->strikes[$key]['count'] == 0) {
//                $this->score += $this->strikes[$key]['subtotal'];
////                array_splice($this->strikes, $key);
//            }
//        }
//        dump($this->score);
//        if ($shot === 10) {
//            $this->pushToStrike($attempt_num);
//        } elseif (!$come_for_strike) {
//            $this->score += $shot;
//        }
////        if (count($this->last_shots['strike']) == 3) {
////            $this->score = array_sum($this->last_shots['strike']);
////            $this->last_shots['strike'] = [];
////        }
//    }
    public function addShot($shot) {
        $this->pushToFrame($shot);
        if ($shot == 10) {
            $this->pushToStrike();
        }
        $this->checkStrike($shot);
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

    public function getFrames()
    {
        return $this->frame;
    }
    public function getLastFrame()
    {
        return $this->frame[count($this->frame) - 1];
    }

    public function CreateFrame()
    {
        $this->frame[] = [];
    }

    public function pushToFrame($shot)
    {
        if (!$this->frameIsOpened() or $shot == 10){
            if (array_sum($this->getLastFrame()) < 10) {
                $this->score += array_sum($this->getLastFrame());
            }
            $this->CreateFrame();
        }
        array_push($this->frame[count($this->frame) - 1], $shot);
    }

    public function frameIsOpened()
    {
        return (count($this->getLastFrame()) < 2 and array_sum($this->getLastFrame()) < 10);
    }

    public function getStrikes()
    {
        return $this->strikes;
    }

    public function pushToStrike() {
        $this->strikes[] = [
            'count' => 2,
            'subtotal' => 10,
        ];
    }

    public function getScore() {
        return $this->score;
    }
}
