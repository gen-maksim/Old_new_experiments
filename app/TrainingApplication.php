<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingApplication extends Model
{
    protected $fillable = ['training_id', 'user_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function confirm()
    {
        $this->training->involve($this->user->id);
        $this->state = 2;
        $this->save();
    }

    public function decline()
    {
        $this->state = 3;
        $this->save();
    }
}
