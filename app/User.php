<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function attend($trainings)
    {
        $trainings = collect($trainings);
        if (!is_a($trainings->first(), Training::class))
        {
            $trainings = Training::find($trainings);

        }

        foreach ($trainings as $training) {
            $training->involve($this->id);
        }
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }

    public function establishedTrainings()
    {
        return $this->hasMany(Training::class, 'owner_id');
    }

    public function applications()
    {
        return $this->hasMany(TrainingApplication::class);
    }

    public function fetchApplicationInbox()
    {
        $current_user_id = $this->id;
        $applications = TrainingApplication::whereHas('training', function($q) use($current_user_id) {
            return $q->where('owner_id', $current_user_id);
        })->get();

        return $applications;
    }

    public function confirm(TrainingApplication $application)
    {
        $application->confirm();

        return true;
    }

    public function decline(TrainingApplication $application)
    {
        $application->decline();

        return true;
    }

    public function applyFor(Training $training, $comment = '')
    {
        if ($training->canBeApplied()) {
            $application = $this->applications()->create([
                'training_id' => $training->id,
                'comment' => $comment,
            ]);
        }

        return $application ?? false;
    }
}
