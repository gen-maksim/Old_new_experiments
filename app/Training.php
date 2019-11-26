<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = ['owner_id', 'max_participants', 'description', 'start_datetime', 'duration_in_mins', 'type', 'training_place_id'];

    public function involve($user_id)
    {
        if ($this->canInvolveThoseParticipants($user_id))
        {
            dump($user_id);
            $this->participants()->attach($user_id);
        }
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }

    public function takePlace($place)
    {
        $this->training_place()->associate($place);
    }

    public function training_place()
    {
        return $this->belongsTo(TrainingPlace::class);
    }

    /**
     * @return bool
     */
    private function canInvolveThoseParticipants($user_id): bool
    {
        $count = is_int($user_id) ? 1 : count($user_id);
//        dump(($this->participants()->count() + $count) <= $this->max_participants);
        return ($this->participants()->count() + $count) <= $this->max_participants;
    }
}
