<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = ['owner_id', 'description', 'start_datetime', 'duration_in_mins', 'type', 'training_place_id'];

    public function involve($user_id)
    {
        $this->participants()->attach($user_id);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
}
