<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bowling extends Model
{
    protected $score;
    protected $strikes = [];
    protected $last_shots;

    public function addShot($shot, $attempt_num) {
        for ($key = 0; $key < count($this->strikes); $key++) {
            $this->strikes[$key]['count']--;
            $this->strikes[$key]['subtotal'] += $shot;
            dump($this->strikes);
            if ($this->strikes[$key]['count'] == 0) {
                $this->score += $this->strikes[$key]['subtotal'];
                array_splice($this->strikes, $key);
            }
        }
        if ($shot === 10) {
            $this->pushToStrike($attempt_num);
        } else {
            $this->score += $shot;
        }
//        if (count($this->last_shots['strike']) == 3) {
//            $this->score = array_sum($this->last_shots['strike']);
//            $this->last_shots['strike'] = [];
//        }
    }

    public function pushToStrike($attempt_num) {
        $this->strikes[] = [
            'attempt_num' => $attempt_num,
            'count' => 2,
            'subtotal' => 10,
        ];
    }

    public function getScore() {
        return $this->score;
    }
}
