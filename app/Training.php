<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = ['owner_id', 'max_participants', 'description', 'start_datetime', 'duration_in_mins', 'type', 'training_place_id'];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($training) {
            $training->involve($training->owner_id);
        });
    }


    public function involve($user_id)
    {
        if ($this->canInvolveThoseParticipants($user_id))
        {
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
        $this->save();
    }

    public function training_place()
    {
        return $this->belongsTo(TrainingPlace::class);
    }

    public function cancel()
    {
        $this->participants()->detach();

        $this->delete();
    }

    /**
     * @return bool
     */
    private function canInvolveThoseParticipants($user_id)
    {
        //check if any of them are already participate
        $users = is_int($user_id) ? collect($user_id) : $user_id;
        foreach ($users as $user) {
            if ($this->participants()->where('user_id', $user)->count()) return false;
        }

        //check if there is a room for those people
        $count = is_int($user_id) ? 1 : count($user_id);
        $current_participants_count = $this->participants()->count();
        $count_after_adding = $current_participants_count + $count;

        return $count_after_adding <= $this->max_participants;
    }
}
